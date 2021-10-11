<?php

namespace Modules\Form\Repositories;

use Illuminate\Support\Collection;
use Medeq\Bitrix24\Models\Builder;
use Medeq\Bitrix24\Models\Model;
use Medeq\Bitrix24\Models\User\User;
use Modules\Form\Repositories\Contracts\ManagerRepository;

/**
 * Class ManagerBitrix24Repository
 * @package Medeq\CRM\Connections\Bitrix24\Repositories
 * @property User $model
 */
class ManagerBitrix24Repository implements ManagerRepository
{
    protected $model = User::class;

    /**
     * @return Builder
     */
    protected function getQuery(): Builder
    {
        return $this->model::query();
    }

    /**
     * @return User[]|Collection
     */
    public function findAll(): Collection
    {
        return $this->getQuery()->get();
    }

    /**
     * @param int $id
     * @return User|Model
     */
    public function findById(int $id): Model
    {
        return $this->getQuery()->find($id);
    }

    /**
     * @param array $departmentIds
     * @return User[]|Collection
     */
    public function getManagersByDepartmentIds(array $departmentIds): Collection
    {
        return $this->getQuery()
            ->where('active', true)
            ->whereIn('uf_department', $departmentIds)
            ->get();
    }
}
