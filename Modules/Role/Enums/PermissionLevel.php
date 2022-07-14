<?php

namespace Modules\Role\Enums;

use App\Enums\BaseEnum;

final class PermissionLevel extends BaseEnum
{
    const OWN = 'own'; # свои
    const DEPARTMENT = 'department'; # свои и своего отдела
    const SUBDEPARTMENT = 'subdepartment'; # свои, своего отдела и подотделов
    const ANY = 'any'; # все

    public static function callbacks(): array
    {
        return [
            self::OWN => 'checkOwn',
            self::DEPARTMENT => 'checkDepartment',
            self::SUBDEPARTMENT => 'checkSubdepartment',
            self::ANY => 'checkAny'
        ];
    }
}
