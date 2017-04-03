<?php

namespace App\Jobs;

use App\Mail\CustomerWelcomeMailler;
use App\Models\ContentFile;
use Common;
use eStatus;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Database\Query\Builder;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Interactivity;
use Mail;

class CreateInteractivePdf implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;
    protected $request;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        Mail::to('srdsaygili@gmail.com')->queue(new CustomerWelcomeMailler($this->request));
        try {
            /** @var ContentFile[] $cf */
            $cf = ContentFile::where('Interactivity', '=', Interactivity::ProcessQueued)
                ->where(function (Builder $query) {
                    $query->whereNull('HasCreated');
                    $query->orWhere('HasCreated', '<>', 1);
                })
                ->where(function (Builder $query) {
                    $query->whereNull('ErrorCount');
                    $query->orWhere('ErrorCount', '<', 2);
                })
                ->get();

            foreach ($cf as $f) {
                try {
                    $f->createInteractivePdf();
                } catch (Exception $e) {

                    $msg = __('common.task_message', array(
                            'task' => '`CreateInteractivePDF`',
                            'detail' => $e->getMessage() . " --- Trace ---" . $e->getTraceAsString()
                        )
                    );
                    Common::sendErrorMail($msg);
                }
            }
        } catch (Exception $e) {
            $msg = __('common.task_message', array(
                    'task' => '`CreateInteractivePDF`',
                    'detail' => $e->getMessage() . " --- Trace ---" . $e->getTraceAsString()
                )
            );
            Common::sendErrorMail($msg);
        }

    }
}
