<?php

namespace Modules\Client\Http\Requests;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Validation\Validator;

class ClientPhoneVerifyCodeRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'phone' => 'required|string|max:255|phone_default_countries|unique:clients,phone',
            'code' => 'required|string|size:4',
        ];
    }

    public function withValidator(Validator $validator): void
    {

    }
}
