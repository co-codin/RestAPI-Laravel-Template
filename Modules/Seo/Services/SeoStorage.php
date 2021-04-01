<?php


namespace Modules\Seo\Services;


use Modules\Seo\Dto\SeoDto;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class SeoStorage
{
    public function update(MorphOne $relation, SeoDto $dto)
    {
        $relation->exists()
            ? $relation->update($dto->toArray())
            : $relation->create($dto->toArray());

        return $relation->first();
    }
}
