<?php


namespace Modules\Seo\Http\Requests\Admin;


use App\Http\Requests\BaseFormRequest;

class CanonicalCreateRequest extends BaseFormRequest
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
