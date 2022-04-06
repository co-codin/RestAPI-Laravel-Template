<?php


namespace Modules\News\Services;

use App\Services\File\ImageUploader;
use Modules\News\Dto\NewsDto;
use Modules\News\Models\News;

class NewsStorage
{
    public function __construct(protected ImageUploader $imageUploader) {}

    public function store(NewsDto $newsDto)
    {
        return News::query()->create($newsDto->toArray());
    }

    public function update(News $news, NewsDto $newsDto)
    {
        $attributes = $newsDto->toArray();

        if (!$news->update($attributes)) {
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
