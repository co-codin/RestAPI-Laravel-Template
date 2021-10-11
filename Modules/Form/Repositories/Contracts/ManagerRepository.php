<?php

namespace Modules\Form\Repositories\Contracts;

use Illuminate\Support\Collection;
use Medeq\Bitrix24\Models\User\User;

/**
 * Interface ManagerRepositoryInterface
 * @package Medeq\CRM\Contracts
 *
 * @method User[]|Collection findAll()
 * @method User findById()
 */
interface ManagerRepository extends BaseRepository
{
    /**
     * @param array $departmentIds
     * @return User[]|Collection
     */
    public function getManagersByDepartmentIds(array $departmentIds): Collection;
}
