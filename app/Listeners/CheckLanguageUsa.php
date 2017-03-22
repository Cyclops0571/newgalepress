<?php

namespace App\Listeners;

use App\Events\WebRouteLoadedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CheckLanguageUsa
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  WebRouteLoadedEvent  $event
     * @return void
     */
    public function handle(WebRouteLoadedEvent $event)
    {
        if(app()->getLocale() == 'usa') {
            app('config')->set('application.languages', ['usa']);
            app('config')->set('application.langs', ['usa' => 4]);
        }
    }
}
