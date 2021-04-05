<?php


namespace Modules\News\Services;


use Modules\News\Dto\NewsDto;
use Modules\News\Models\News;

class NewsStorage
{
    public function store(NewsDto $newsDto)
    {
        return News::query()->create($newsDto->toArray());
    }

    public function update(News $news, NewsDto $newsDto)
    {
        if (!$news->update($newsDto->toArray())) {
            throw new \LogicException('can not update news');
        }
        return $news;
    }

    public function delete(News $news)
    {
        if (!$news->delete()) {
            throw new \LogicException('can not delete news');
        }
    }
}
