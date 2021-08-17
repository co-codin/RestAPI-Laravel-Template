<?php


namespace Modules\Publication\Services;


use Modules\Publication\Dto\PublicationDto;
use Modules\Publication\Models\Publication;

class PublicationStorage
{
    public function store(PublicationDto $publicationDto)
    {
        $attributes = $publicationDto->toArray();

        $attributes['assigned_by_id'] = $dto->assigned_by_id ?? auth('custom-token')->id();

        return Publication::query()->create($attributes);
    }

    public function update(Publication $publication, PublicationDto $publicationDto)
    {
        $attributes = $publicationDto->toArray();

        $attributes['assigned_by_id'] = $dto->assigned_by_id ?? null;

        if (!$publication->update($attributes)) {
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
