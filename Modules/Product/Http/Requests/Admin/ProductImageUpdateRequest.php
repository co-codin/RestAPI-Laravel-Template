<?php


namespace Modules\Product\Http\Requests\Admin;


use Illuminate\Foundation\Http\FormRequest;

class ProductImageUpdateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'images' => 'array|nullable',
            'images.*.id' => 'integer|nullable|exists:images,id',
            'images*.image' => 'required|string|distinct',
            'images*.position' => 'integer|nullable',
            'images*.caption' => 'string|nullable|max:255',
            'images*.alt' => 'string|nullable|max:255',
            'images*.title' => 'string|nullable|max:255',
        ];
    }
}
