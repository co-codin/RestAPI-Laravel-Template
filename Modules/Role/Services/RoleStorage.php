<?php

namespace Modules\Role\Services;

use Modules\Role\Dto\RoleDto;
use Modules\Role\Models\Role;

class RoleStorage
{
    public function store(RoleDto $dto)
    {
        return Role::query()->create($dto->toArray());
    }

    public function update(Role $role, RoleDto $dto)
    {
        if (!$role->update($dto->toArray())) {
            throw new \LogicException('can not update role');
        }

        return $role;
    }

    public function delete(Role $role)
    {
        if (!$role->delete()) {
            throw new \LogicException('can not delete role');
        }
    }
}
