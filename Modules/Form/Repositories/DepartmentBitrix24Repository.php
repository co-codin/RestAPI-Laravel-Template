<?php

namespace Modules\Form\Repositories;

use Illuminate\Support\Collection;
use Medeq\Bitrix24\Models\Builder;
use Medeq\Bitrix24\Models\Department\Department;
use Medeq\Bitrix24\Models\Model;
use Modules\Form\Repositories\Contracts\DepartmentRepository;

/**
 * Class DepartmentBitrix24Repository
 * @package Medeq\CRM\Connections\Bitrix24\Repositories
 * @property Department $model
 */
class DepartmentBitrix24Repository implements DepartmentRepository
{
    protected $model = Department::class;

    /**
     * @return Builder
     */
    protected function getQuery(): Builder
    {
        return $this->model::query();
    }

    /**
     * @return Department[]|Collection
     */
    public function findAll(): Collection
    {
        return $this->getQuery()->get();
    }

    /**
     * @param int $id
     * @return Department|Model
     */
    public function findById(int $id): Model
    {
        return $this->getQuery()->find($id);
    }

    /**
     * @param int $parent_id
     * @return Department[]|Collection
     */
    public function getDepartmentsByParentId(int $parent_id): Collection
    {
        return $this->getQuery()
            ->where('parent', $parent_id)
            ->get();
    }
}
