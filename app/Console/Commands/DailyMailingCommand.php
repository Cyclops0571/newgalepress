<?php

namespace App\Console\Commands;

use App\Mail\PaymentAccountantMailler;
use App\Mail\SubscriptionExpireMailler;
use App\Models\Application;
use App\Models\MailLog;
use Carbon\Carbon;
use Common;
use DB;
use eStatus;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;
use Mail;
use sts\config;
use View;

class DailyMailingCommand extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zz-my-tasks:daily-mailing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends daily mails';

    /**
     * Create a new command instance.
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Mail::to(config('mail.accounting_emails'))->queue(new PaymentAccountantMailler());
        $this->applicationExpire();

        return;
        $this->tutorial();
        $this->webinar();
        $this->trialEndsInTwoDays();
        $this->newFeature();
        $this->trialEndsToday();
        $this->feedback();
    }

    private function tutorial()
    {
        $applications = Application::where('StartDate', Carbon::today()->subDays(3))
            ->where('Trail', 1)
            ->whereHas('Contents')->get();
        $this->sendMail($applications, "Tutorial", View::make('mail-templates.tutorial.index')->render(), config('mail.admin_email'), 3);
    }

    private function webinar()
    {

        $applications = Application::where('StartDate', Carbon::today()->subDays(4))
            ->where('Trail', 1)
            ->get();
        $this->sendMail($applications, "Webinar", View::make('mail-templates.webinar.index')->render(), config('mail.admin_email'), 4);
    }

    private function trialEndsInTwoDays()
    {

        $applications = Application::where('StartDate', Carbon::today()->subDays(5))
            ->where('Trail', 1)
            ->get();
        $this->sendMail($applications, "Try Period Ending After 2 Days", View::make('mail-templates.tryending2days.index')->render(), config('mail.admin_email'), 5);
    }


    private function newFeature()
    {

        $applications = Application::where('StartDate', Carbon::today()->subDays(6))
            ->where('Trail', 1)
            ->get();
        $this->sendMail($applications, "New Features", View::make('mail-templates.newfeature.index')->render(), config('mail.admin_email'), 6);
    }

    private function trialEndsToday()
    {

        $applications = Application::where('StartDate', Carbon::today()->subDays(7))
            ->where('Trail', 1)
            ->get();
        $this->sendMail($applications, "Try Ending Today", View::make('mail-templates.tryendingtoday.index')->render(), config('mail.admin_email'), 7);
    }

    private function feedback()
    {

        $applications = Application::where('StartDate', Carbon::today()->subDays(8))
            ->where('Trail', 1)
            ->get();
        $this->sendMail($applications, "Feedback", View::make('mail-templates.feedback.index')->render(), config('mail.admin_email'), 8);
    }


    function sendMail($apps, $subjectName, $view, $userEmail, $mailID)
    {
        foreach ($apps as $app)
        {
            $users = DB::table('User')
                ->where('CustomerID', $app->CustomerID)
                ->where('StatusID', 1)
                ->get();
            foreach ($users as $user)
            {
                $subject = $subjectName;
                $msg = $view;
                //                $mailStatus = \Mail::to($userEmail)->
                //                 $mailStatus = false;
                //                Common::sendHtmlEmail($userEmail, $user->FirstName . ' ' . $user->LastName, $subject, $msg);


                $m = new MailLog();
                $m->MailID = $mailID; //MailType
                $m->UserID = $user->UserID;
                if (!$mailStatus)
                {
                    $m->Arrived = 0;
                } else
                {
                    $m->Arrived = 1;
                }
                $m->StatusID = eStatus::Active;
                $m->save();
            }
        }

    }

    private function applicationExpire()
    {

        /** @var Application[] $apps */
        $apps = Application::where(function (Builder $query)
        {
            $query->where('ExpirationDate', Carbon::today()->addDays(15)->format('Y-m-d')); //son 15
            $query->orWhere('ExpirationDate', Carbon::today()->addDays(7)->format('Y-m-d')); //son hafta
            $query->orWhere('ExpirationDate', Carbon::today()->format('Y-m-d')); //son gun
        })
            ->get();

        foreach ($apps as $app)
        {
            Mail::queue(new SubscriptionExpireMailler($app));
            $expirationDate = new Carbon($app->ExpirationDate);


            foreach ($app->Users as $user)
            {
                $emails = [
                    "info@galepress.com",
                    $user->Email,
                ];
                Mail::to($emails)->queue(new SubscriptionExpireMailler($app));

            }
        }

    }
}
