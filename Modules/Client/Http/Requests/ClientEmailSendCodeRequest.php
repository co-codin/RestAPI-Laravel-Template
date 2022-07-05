<?php

namespace Modules\Client\Http\Requests;

use App\Http\Requests\BaseFormRequest;

class ClientEmailSendCodeRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|string|max:255|email|unique:clients,email'
        ];
    }
}
