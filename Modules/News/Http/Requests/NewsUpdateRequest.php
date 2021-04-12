<?php


namespace Modules\News\Http\Requests;


use App\Enums\Status;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class NewsCreateRequest
 * @package Modules\News\Http\Requests\Admin
 * @property array $seo
 */
class NewsUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
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
            'image' => 'sometimes|required|string|max:255',
            'is_in_home' => 'sometimes|boolean',
            'published_at' => 'sometimes|required|date_format:Y-m-d',
        ];
    }
}
