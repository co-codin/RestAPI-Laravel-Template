<?php


namespace Modules\Form\Repositories\Contracts;


use Illuminate\Support\Collection;
use Medeq\Bitrix24\Models\Model;

/**
 * Interface BaseRepositoryInterface
 */
interface BaseRepository
{
    /**
     * @return Model[]|Collection|null
     */
    public function findAll(): ? Collection;

    /**
     * @param int $id
     * @return Model|null
     */
    public function findById(int $id): ? Model;
}
