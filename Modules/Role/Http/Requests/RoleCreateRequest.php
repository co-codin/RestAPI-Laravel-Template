<?php

namespace Modules\Role\Http\Requests;

use App\Http\Requests\BaseFormRequest;
use BenSampo\Enum\Rules\EnumValue;
use Modules\Role\Enums\PermissionLevel;

class RoleCreateRequest extends BaseFormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'key' => 'required|string|max:255|regex:/[A-Z0-9_-]+/',
            'guard_name' => 'sometimes|nullable|string|max:255',
            'permissions' => 'required|array',
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
            'description' => 'Название роли на русском языке',
            'guard_name' => 'guard_name',
        ];
    }
}
