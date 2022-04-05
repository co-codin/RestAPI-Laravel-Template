<?php


namespace Modules\Seo\Services\Admin;


use Modules\Seo\Dto\CanonicalDto;
use Modules\Seo\Models\Canonical;

/**
 * Class CanonicalStorage
 * @package Modules\Seo\Services\Admin
 */
class CanonicalStorage
{
    /**
     * @param CanonicalDto $dto
     * @return Canonical
     * @throws \Exception
     */
    public function store(CanonicalDto $dto): Canonical
    {
        $attributes = $dto->toArray();

        $attributes['assigned_by_id'] = $dto->assigned_by_id ?? auth('sanctum')->id();

        $canonical = new Canonical($attributes);

        if (!$canonical->save()) {
            throw new \Exception('Не удалось сохранить Canonical');
        }

        return $canonical;
    }

    /**
     * @param Canonical $canonical
     * @param CanonicalDto $dto
     * @return Canonical
     * @throws \Exception
     */
    public function update(Canonical $canonical, CanonicalDto $dto): Canonical
    {
        $attributes = $dto->toArray();

        $attributes['assigned_by_id'] = $dto->assigned_by_id ?? null;

        if (!$canonical->update($attributes)) {
            throw new \Exception('Не удалось обновить Canonical - id' . $canonical->id);
        }

        return $canonical;
    }

    /**
     * @param Canonical $canonical
     * @return Canonical
     * @throws \Exception
     */
    public function delete(Canonical $canonical): Canonical
    {
        if (!$canonical->delete()) {
            throw new \Exception('Не удалось удалить запись из таблицы Canonical - id' . $canonical->id);
        }

        return $canonical;
    }
}
