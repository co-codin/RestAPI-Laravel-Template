<?php

namespace Modules\Cabinet\Listeners;

class UpdateView
{
    public function handle($event)
    {
        $event->cabinet->view_num = (int) $event->cabinet->view_num + 1;
    }
}
