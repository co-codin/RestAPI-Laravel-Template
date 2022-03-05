<?php


namespace Modules\News\Http\Requests;


use App\Enums\Status;
use BenSampo\Enum\Rules\EnumValue;
use App\Http\Requests\BaseFormRequest;

class NewsCreateRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'short_description' => 'required|string|max:255',
            'full_description' => 'required|string',
            'status' => [
                'required',
                new EnumValue(Status::class, false),
            ],
            'slug' => 'sometimes|regex:/^[a-z0-9_\-]*$/|nullable|max:255|unique:news,slug',
            'image' => 'required|image',
            'is_in_home' => 'sometimes|boolean',
            'published_at' => 'required|date',
            'view_num' => 'sometimes|nullable|integer',
            'assigned_by_id' => 'sometimes|nullable|integer',
            'category' => 'string|nullable|max:255',
        ];
    }

    public function attributes()
    {
        return [
            'published_at' => 'Дата публикации',
            'category' => 'Рубрика',
        ];
    }
}
