<?php

namespace Modules\Client\Http\Requests;

use App\Http\Requests\BaseFormRequest;
use Modules\Client\Helpers\PhoneHelper;

class ClientFastRegisterRequest extends BaseFormRequest
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
            'phone' => 'required|string|phone_default_countries|max:255',
        ];
    }

    public function attributes(): array
    {
        return [
            'phone' => 'Номер телефона',
        ];
    }
}
