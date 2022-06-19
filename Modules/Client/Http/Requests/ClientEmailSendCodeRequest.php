<?php

namespace Modules\Client\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientEmailSendCodeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|string|max:255|email|unique:clients,email'
        ];
    }
}
