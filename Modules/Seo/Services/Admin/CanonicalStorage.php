<?php


namespace Modules\Seo\Services\Admin;


use Modules\Seo\Dto\Admin\CanonicalDto;
use Modules\Seo\Models\CanonicalEntity;

/**
 * Class CanonicalStorage
 * @package Modules\Seo\Services\Admin
 */
class CanonicalStorage
{
    /**
     * @param CanonicalDto $dto
     * @return CanonicalEntity
     * @throws \Exception
     */
    public function store(CanonicalDto $dto): CanonicalEntity
    {
        $canonical = new CanonicalEntity($dto->toArray());

        if (!$canonical->save()) {
            throw new \Exception('Не удалось сохранить Canonical');
        }

        return $canonical;
    }

    /**
     * @param CanonicalEntity $canonical
     * @param CanonicalDto $dto
     * @return CanonicalEntity
     * @throws \Exception
     */
    public function update(CanonicalEntity $canonical, CanonicalDto $dto): CanonicalEntity
    {
        if (!$canonical->update($dto->toArray())) {
            throw new \Exception('Не удалось обновить Canonical - id' . $canonical->id);
        }

        return $canonical;
    }

    /**
     * @param CanonicalEntity $canonical
     * @return CanonicalEntity
     * @throws \Exception
     */
    public function delete(CanonicalEntity $canonical): CanonicalEntity
    {
        if (!$canonical->delete()) {
            throw new \Exception('Не удалось удалить запись из таблицы Canonical - id' . $canonical->id);
        }

        return $canonical;
    }
}
