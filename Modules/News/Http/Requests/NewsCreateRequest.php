<?php


namespace Modules\News\Http\Requests;


use App\Enums\Status;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;

class NewsCreateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'short_description' => 'required|string|max:500',
            'full_description' => 'required|string',
            'status' => [
                'required',
                new EnumValue(Status::class, false),
            ],
            'slug' => 'sometimes|nullable|max:255|unique:news,slug',
            'image' => 'required|image|max:512',
            'is_in_home' => 'sometimes|boolean',
            'published_at' => 'required|date_format:d.m.Y',
        ];
    }

    public function attributes()
    {
        return [
            'published_at' => 'Дата публикации',
        ];
    }
}
