<?php

namespace Modules\Client\Http\Requests;

use App\Http\Requests\BaseFormRequest;
use BenSampo\Enum\Rules\EnumValue;
use Modules\Client\Enums\OrgType;

class ClientPayerUpdateRequest extends BaseFormRequest
{
    public function authorize(): bool
    {
        return $this->route('payer')->client_id === auth('client-api')->id();
    }

    public function rules(): array
    {
        return [
            'org_type' => [
                'required',
                'integer',
                new EnumValue(OrgType::class, false),
            ],
            'name' => 'required|string|max:255',
            'inn' => 'required|regex:/^\d{10,15}$/|unique:client_payers,inn,'  . $this->route('payer')->id,
            'delivery_address' => 'required|string|max:255',
            'site' => 'nullable|url|max:255',
            'email' => 'nullable|string|email|max:255|unique:client_payers,email,' . $this->route('payer')->id,
            'position' => 'nullable|string|max:255',
        ];
    }

    public function attributes(): array
    {
        return [
            'org_type' => 'Тип организации',
            'name' => 'Название',
            'inn' => 'ИНН',
            'delivery_address' => 'Адрес доставки',
            'site' => 'Сайт',
            'email' => 'Email',
            'position' => 'Должность',
        ];
    }
}
