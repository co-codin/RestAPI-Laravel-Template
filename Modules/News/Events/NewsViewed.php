<?php

namespace Modules\News\Events;

use Illuminate\Queue\SerializesModels;
use Modules\News\Models\News;

class NewsViewed
{
    use SerializesModels;

    public $news;

    public function __construct(News $news)
    {
        $this->news = $news;
    }
}
