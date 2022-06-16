<?php

namespace Modules\Client\Http\Requests;

use App\Http\Requests\BaseFormRequest;
use Modules\Client\Helpers\PhoneHelper;

class ClientRegisterRequest extends BaseFormRequest
{
    protected function prepareForValidation()
    {
        if (!empty($this->phone) && (is_string($this->phone) || is_int($this->phone))) {
            $this->merge([
                'phone' => PhoneHelper::format((string)$this->phone),
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:clients,email',
            'phone' => 'required|string|max:255|phone_default_countries|unique:clients,phone',
        ];
    }

    public function attributes(): array
    {
        return [
            'phone' => 'Номер телефона',
        ];
    }
}
