<?php


namespace Modules\Page\Http\Requests;


use App\Enums\Status;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class PageCreateRequest
 * @package Modules\Page\Http\Requests\Admin
 * @property array $seo
 */
class PageCreateRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'full_description' => 'sometimes|nullable|string',
            'status' => [
                'required',
                new EnumValue(Status::class, false),
            ],
            'slug' => 'sometimes|nullable|string|max:255|unique:pages,slug',
            'parent_id' => 'sometimes|nullable|integer|exists:pages,id',
        ];
    }
}
