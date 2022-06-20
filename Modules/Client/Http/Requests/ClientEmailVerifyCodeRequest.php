<?php

namespace Modules\Client\Http\Requests;

use App\Http\Requests\BaseFormRequest;
use Illuminate\Validation\Validator;
use Modules\Client\Http\Validators\ClientEmailVerifyCodePostValidator;

class ClientEmailVerifyCodeRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|string|max:255|email|unique:clients,email',
            'code' => 'required|string|size:4',
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            if ($validator->errors()->isEmpty()) {
                ClientEmailVerifyCodePostValidator::run($validator);
            }
        });
    }
}
