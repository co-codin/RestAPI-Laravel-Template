<?php

namespace Modules\News\Listeners;


use Modules\News\Events\NewsViewed;

class UpdateView
{
    public function handle(NewsViewed $event)
    {
        $event->news_single
            ?->disableLogging()
            ->increment('view_num');
    }
}
