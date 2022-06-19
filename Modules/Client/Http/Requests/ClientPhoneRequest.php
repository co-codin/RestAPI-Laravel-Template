<?php

namespace Modules\Client\Http\Requests;

use App\Http\Requests\BaseFormRequest;

class ClientPhoneRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'phone' => 'required|string|max:255|phone_default_countries|unique:clients,phone',
        ];
    }
}
