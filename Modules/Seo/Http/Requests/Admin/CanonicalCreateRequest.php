<?php


namespace Modules\Seo\Http\Requests\Admin;


use Illuminate\Foundation\Http\FormRequest;

/**
 * Class CanonicalCreateRequest
 * @package Modules\Seo\Http\Requests\Admin
 */
class CanonicalCreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'url' => [
                'required',
                'string',
                'max:255',
                'unique:canonicals,url,' . $this->route('canonical.id'),
            ],
            'canonical' => 'required|string|max:255',
        ];
    }
}
