<?php

namespace Modules\Client\Http\Requests;

use App\Http\Requests\BaseFormRequest;
use BenSampo\Enum\Rules\EnumValue;
use Modules\Client\Enums\VerifyType;

class ClientSendCodeRequest extends BaseFormRequest
{
    public function prepareForValidation(): void
    {
        if (\Str::length($this->phone) === 11 && \Str::startsWith($this->phone, '8')) {
            $this->merge([
                'phone' => \Str::replaceFirst('8', '+7', $this->phone)
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'phone' => 'required|string|max:255|phone_default_countries|exists:clients,phone',
            'verify_type' => [
                'required',
                'int',
                new EnumValue(VerifyType::class, false)
            ]
        ];
    }
}
