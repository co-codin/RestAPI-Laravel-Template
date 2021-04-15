<?php


namespace Modules\News\Services;

use App\Services\File\ImageUploader;
use Illuminate\Http\UploadedFile;
use Modules\News\Dto\NewsDto;
use Modules\News\Models\News;

class NewsStorage
{
    protected ImageUploader $imageUploader;

    public function __construct(ImageUploader $imageUploader)
    {
        $this->imageUploader = $imageUploader;
    }

    public function store(NewsDto $newsDto)
    {
        $attributes = $newsDto->except('image')->toArray();
        $attributes['image'] = $this->imageUploader->upload($newsDto->image);

        return News::query()->create($attributes);
    }

    public function update(News $news, NewsDto $newsDto)
    {
        $attributes = $newsDto->except('image')->toArray();

        if($newsDto->image) {
            $attributes['image'] = $this->imageUploader->upload($newsDto->image);
        }

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
