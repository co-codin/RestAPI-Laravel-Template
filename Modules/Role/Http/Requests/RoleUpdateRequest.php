<?php

namespace Modules\Role\Http\Requests;

use App\Http\Requests\BaseFormRequest;
use BenSampo\Enum\Rules\EnumValue;
use Modules\Role\Enums\PermissionLevel;

class RoleUpdateRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'key' => 'sometimes|required|string|max:255|regex:/[A-Z0-9_-]+/',
            'guard_name' => 'sometimes|nullable|string|max:255',
            'permissions' => 'sometimes|required|array',
            'permissions.*.id' => 'required|exists:permissions,id',
            'permissions.*.level' => [
                'required',
                new EnumValue(PermissionLevel::class),
            ],
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Название роли',
            'guard_name' => 'guard_name',
        ];
    }
}
