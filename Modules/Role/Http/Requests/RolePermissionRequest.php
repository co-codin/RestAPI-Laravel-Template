<?php


namespace Modules\Role\Http\Requests;


use App\Http\Requests\BaseFormRequest;

class RolePermissionRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'permissions' => [
                'required',
                'array',
            ],
            'permissions.*.id' => [
                'required',
                'integer',
                'exists:permissions,id',
            ],
            'permissions.*.level' => [
                'required',
                'boolean',
            ],
        ];
    }

    public function attributes()
    {
        return [
            'permissions' => 'Права доступа',
            'permissions.*.id' => 'Право доступа',
            'permissions.*.level' => 'Уровень доступа',
        ];
    }
}
