<?php


namespace Modules\Publication\Services;


use App\Services\File\ImageUploader;
use Modules\Publication\Dto\PublicationDto;
use Modules\Publication\Models\Publication;

class PublicationStorage
{
    public function __construct(protected ImageUploader $imageUploader) {}

    public function store(PublicationDto $publicationDto)
    {
        $attributes = $publicationDto->toArray();
        $attributes['logo'] = $this->imageUploader->upload($publicationDto->logo, 'publications');

        return Publication::query()->create($attributes);
    }

    public function update(Publication $publication, PublicationDto $publicationDto)
    {
        $attributes = $publicationDto->toArray();

        if($publicationDto->logo) {
            $attributes['logo'] = $this->imageUploader->upload($publicationDto->logo, 'publications');
        }

        if (!$publication->update($attributes)) {
            throw new \LogicException('can not update publication');
        }

        return $publication;
    }

    public function delete(Publication $publication)
    {
        if ($publication->delete()) {
            unlink(storage_path($publication->logo));
        } else {
            throw new \LogicException('can not delete publication');
        }
    }
}
