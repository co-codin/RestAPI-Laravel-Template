<?php


namespace Modules\News\Http\Requests;


use App\Enums\Status;
use BenSampo\Enum\Rules\EnumValue;
use App\Http\Requests\BaseFormRequest;

class NewsUpdateRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'short_description' => 'sometimes|required|string|max:500',
            'full_description' => 'sometimes|required|string',
            'status' => [
                'sometimes',
                'required',
                new EnumValue(Status::class, false),
            ],
            'slug' => 'sometimes|regex:/^[a-z0-9_\-]*$/|nullable|max:255|unique:brands,slug,' . $this->route('news'),
            'image' => 'sometimes|required|image',
            'is_in_home' => 'sometimes|boolean',
            'published_at' => 'sometimes|required|date',
            'assigned_by_id' => 'sometimes|nullable|integer',
        ];
    }

    public function attributes()
    {
        return [
            'published_at' => 'Дата публикации',
        ];
    }
}
