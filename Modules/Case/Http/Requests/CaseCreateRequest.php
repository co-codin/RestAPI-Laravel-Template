<?php

namespace Modules\Case\Http\Requests;

use App\Enums\Status;
use App\Http\Requests\BaseFormRequest;
use BenSampo\Enum\Rules\EnumValue;

class CaseCreateRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'city_id' => 'required|integer|exists:cities,id',
            'name' => 'required|string|max:255',
            'slug' => 'required|max:255|regex:/^[a-z0-9_\-]*$/|unique:cases,slug',
            'short_description' => 'required|string',
            'full_description' => 'required|string',
            'summary' => 'required|string|max:255',
            'status' => [
                'required',
                new EnumValue(Status::class, false),
            ],
            'published_at' => 'required|string|max:255',
            'image' => 'required|string',
        ];
    }

    public function attributes()
    {
        return [
            'published_at' => 'Дата поставки',
            'summary' => 'Что сделано?',
        ];
    }
}
