<?php

namespace Modules\Contact\Http\Requests;

use App\Http\Requests\BaseFormRequest;

class ContactUpdateRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'first_name' => 'sometimes|required|string|max:255',
            'last_name' => 'sometimes|required|string|max:255',
            'job_position' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email',
            'phone' => 'sometimes|required|string|max:255',
            'image' => 'sometimes|required|string',
            'position' => 'sometimes|nullable|integer',
            'is_enabled' => 'sometimes|boolean',
        ];
    }
}
