<?php

namespace Modules\News\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Modules\News\Models\News;

class UpdateViewJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $news;

    public function __construct(News $news)
    {
        $this->news = $news;
    }

    public function handle()
    {
        $this->news->update([
            'view_num' => $this->news->view_num + 1
        ]);
    }
}
