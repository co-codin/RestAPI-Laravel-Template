<?php

namespace Modules\News\Listeners;


class UpdateView
{
    public function handle($event)
    {
        $event->news_single->view_num = (int) $event->news_single->view_num + 1;
    }
}
