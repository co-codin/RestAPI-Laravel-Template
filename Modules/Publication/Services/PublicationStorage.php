<?php


namespace Modules\Publication\Services;


use Modules\Publication\Dto\PublicationDto;
use Modules\Publication\Models\Publication;

class PublicationStorage
{
    public function store(PublicationDto $publicationDto)
    {
        return Publication::query()->create($publicationDto->toArray());
    }

    public function update(Publication $publication, PublicationDto $publicationDto)
    {
        if (!$publication->update($publicationDto->toArray())) {
            throw new \LogicException('can not update publication');
        }
        return $publication;
    }

    public function delete(Publication $publication)
    {
        if (!$publication->delete()) {
            throw new \LogicException('can not delete publication');
        }
    }
}
