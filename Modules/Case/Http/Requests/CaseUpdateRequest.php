<?php

namespace Modules\Case\Http\Requests;

use App\Enums\Status;
use App\Http\Requests\BaseFormRequest;
use BenSampo\Enum\Rules\EnumValue;

class CaseUpdateRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'city_id' => 'sometimes|required|integer|exists:cities,id',
            'name' => 'sometimes|required|string|max:255',
            'slug' => 'sometimes|required|string|max:255|regex:/^[a-z0-9_\-]*$/|unique:case_models,slug,' . $this->route('case_model'),
            'short_description' => 'sometimes|required|string',
            'full_description' => 'sometimes|required|string',
            'body' => 'sometimes|required|string',
            'summary' => 'sometimes|required|string|max:255',
            'note' => 'sometimes|nullable|string|max:255',
            'status' => [
                'sometimes',
                'required',
                new EnumValue(Status::class, false),
            ],
            'image' => 'sometimes|required|string',
            'images' => 'sometimes|nullable|array',
            'images.*.image' => 'required|string|max:255',
            'images.*.caption' => 'required|string|max:255',
            'products' => 'sometimes|required|array',
            'products.*.id' => 'required|integer|distinct|exists:products,id',
            'released_year' => 'sometimes|required|int|max:2100|min:2000',
            'released_quarter' => 'sometimes|required|int|max:4|min:1',
        ];
    }

    public function attributes()
    {
        return [
            'summary' => 'Что сделано?',
            'note' => 'Заметка',
            'images' => 'Галерея',
            'images.*.image' => 'Изображение',
            'images.*.caption' => 'Подпись к изображению',
            'released_year' => 'Год реализации',
            'released_quarter' => 'Квартал реализации',
        ];
    }
}
