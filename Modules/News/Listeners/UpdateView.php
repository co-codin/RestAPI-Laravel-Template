<?php

namespace Modules\News\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateView
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
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        var_dump($event->news->view_num);
        $event->news->update([
            'view_num' => $event->news->view_num ? $event->news->view_num + 1 : 1
        ]);
    }
}
