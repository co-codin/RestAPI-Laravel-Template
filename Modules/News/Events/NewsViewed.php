<?php

namespace Modules\News\Events;

use Illuminate\Queue\SerializesModels;

class NewsViewed
{
    use SerializesModels;

    public $news_single;

    public function __construct($news_single)
    {
        $this->news_single = $news_single;
    }
}
