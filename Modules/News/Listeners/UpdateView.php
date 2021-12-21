<?php

namespace Modules\News\Listeners;


class UpdateView
{
    public function handle($event)
    {
        $event->news_single->increment('view_num');
    }
}
