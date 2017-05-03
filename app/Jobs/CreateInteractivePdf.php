<?php

namespace App\Jobs;

use App\Mail\ErrorMailler;
use App\Models\ContentFile;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Interactivity;
use Mail;

class CreateInteractivePdf implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
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
                    Mail::to(config('mail.admin_email'))->queue(new ErrorMailler($msg));

                }
            }
        } catch (Exception $e) {
            $msg = __('common.task_message', array(
                    'task' => '`CreateInteractivePDF`',
                    'detail' => $e->getMessage() . " --- Trace ---" . $e->getTraceAsString()
                )
            );
            Mail::to(config('mail.admin_email'))->queue(new ErrorMailler($msg));
        }

    }
}
