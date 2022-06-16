<?php

namespace Modules\Client\Http\Requests;

use App\Http\Requests\BaseFormRequest;

class FastRegisterRequest extends BaseFormRequest
{
    protected function prepareForValidation()
    {
        if (!empty($this->phone) && (is_string($this->phone) || is_int($this->phone))) {
            $this->merge([
                'phone' => $this->formatPhone((string)$this->phone)
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

    protected function formatPhone(string $phone): string
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);

        if (strlen($phone) === 11) {
            $phone = preg_replace('/^8/', 7, $phone);
        }

        if (strlen($phone) === 10 && preg_match('/^9/', $phone, $matches)) {
            $phone = '7' . $phone;
        }

        return '+' . $phone;
    }
}
