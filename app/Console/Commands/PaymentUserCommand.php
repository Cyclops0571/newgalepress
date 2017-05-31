<?php

namespace App\Console\Commands;

use App\Library\MyPayment;
use App\Mail\PaymentAdminRemainderMailler;
use App\Models\PaymentAccount;
use Illuminate\Console\Command;
use Mail;

class PaymentUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zz-my-tasks:payment-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gets the payment from customer with Iyzico Service';

    /**
     * Create a new command instance.
     *
     * @return void
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
        $WarningMailSet = [];
        $paymentAccounts = PaymentAccount::get();
        foreach ($paymentAccounts as $paymentAccount)
        {
            $payment = new MyPayment();
            $result = $payment->paymentWithToken($paymentAccount);
            sleep(60);
            if (!empty($result))
            {
                $WarningMailSet[] = $result;
            }
        }

        if (!empty($WarningMailSet))
        {
            Mail::to(config('mail.admin_email'))->queue(new PaymentAdminRemainderMailler($WarningMailSet));
        }
    }
}
