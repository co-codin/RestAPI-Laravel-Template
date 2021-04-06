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
class PageUpdateRequest extends FormRequest
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
            'full_description' => 'sometimes|nullable|string',
            'status' => [
                'sometimes',
                'required',
                new EnumValue(Status::class, false),
            ],
            'slug' => 'sometimes|nullable|string|max:255|unique:pages,slug,' . $this->route('page'),
            'parent_id' => 'sometimes|nullable|integer|exists:pages,id',
        ];
    }
}
