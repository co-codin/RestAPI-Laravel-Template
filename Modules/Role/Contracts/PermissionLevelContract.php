<?php

namespace Modules\Role\Contracts;

interface PermissionLevelContract
{
    public function checkAny($user, $model);

    public function checkOwn($user, $model);

    public function checkDepartment($user, $model);

    public function checkSubdepartment($user, $model);
}
