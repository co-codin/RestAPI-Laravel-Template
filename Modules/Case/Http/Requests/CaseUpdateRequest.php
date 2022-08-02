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
            'summary' => 'sometimes|required|string|max:255',
            'note' => 'sometimes|nullable|string|max:255',
            'status' => [
                'sometimes',
                'required',
                new EnumValue(Status::class, false),
            ],
            'published_at' => 'sometimes|required|string|max:255',
            'image' => 'sometimes|required|string',
            'products' => 'sometimes|required|array',
            'products.*.id' => 'required|integer|distinct|exists:products,id',
        ];
    }

    public function attributes()
    {
        return [
            'published_at' => 'Дата поставки',
            'summary' => 'Второй заголовок',
            'note' => 'Заметка',
        ];
    }
}
