<?php

namespace Modules\Role\Http\Requests;

use App\Http\Requests\BaseFormRequest;

class RoleUpdateRequest extends BaseFormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string|max:255',
            'guard_name' => 'sometimes|nullable|string|max:255',
            'role_ids' => 'nullable|array'
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
