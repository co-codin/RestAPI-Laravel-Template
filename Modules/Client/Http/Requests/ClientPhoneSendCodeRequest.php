<?php

namespace Modules\Client\Http\Requests;

use App\Http\Requests\BaseFormRequest;
use BenSampo\Enum\Rules\EnumValue;
use Modules\Client\Enums\VerifyType;

class ClientPhoneSendCodeRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'phone' => 'required|string|max:255|phone_default_countries|unique:clients,phone',
            'verify_type' => [
                'required',
                'int',
                new EnumValue(VerifyType::class, false),
            ],
        ];
    }
}
