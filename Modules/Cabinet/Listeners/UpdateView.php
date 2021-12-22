<?php

namespace Modules\Cabinet\Listeners;

class UpdateView
{
    public function handle($event)
    {
        $event->cabinet?->increment('view_num');
    }
}
