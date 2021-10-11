<?php

namespace Modules\Form\Repositories\Contracts;

use Illuminate\Support\Collection;
use Medeq\Bitrix24\Models\Department\Department;

/**
 * Interface DepartmentRepositoryInterface
 * @package Medeq\CRM\Contracts
 *
 * @method Department[]|Collection findAll()
 * @method Department findById()
 */
interface DepartmentRepository extends BaseRepository
{
    /**
     * @param int $parent_id
     * @return Department[]|Collection
     */
    public function getDepartmentsByParentId(int $parent_id): Collection;
}
