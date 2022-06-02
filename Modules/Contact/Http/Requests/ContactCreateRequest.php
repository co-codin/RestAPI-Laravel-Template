<?php

namespace Modules\Contact\Http\Requests;

use App\Http\Requests\BaseFormRequest;

class ContactCreateRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'job_position' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:255',
            'image' => 'required|string',
            'position' => 'sometimes|nullable|integer',
            'is_enabled' => 'sometimes|boolean',
        ];
    }
}
