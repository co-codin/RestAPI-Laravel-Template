<?php


namespace Modules\News\Http\Requests;


use App\Enums\Status;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;

class NewsUpdateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'short_description' => 'sometimes|required|string|max:500',
            'full_description' => 'sometimes|required|string|max:500',
            'status' => [
                'sometimes',
                'required',
                new EnumValue(Status::class, false),
            ],
            'slug' => 'sometimes|nullable|max:255|unique:brands,slug,' . $this->route('news'),
            'image' => 'sometimes|required|image',
            'is_in_home' => 'sometimes|boolean',
            'published_at' => 'sometimes|required|date_format:Y-m-d',
        ];
    }

    public function attributes()
    {
        return [
            'published_at' => 'Дата публикации',
        ];
    }
}
