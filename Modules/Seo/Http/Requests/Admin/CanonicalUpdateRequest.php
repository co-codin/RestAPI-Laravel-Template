<?php


namespace Modules\Seo\Http\Requests\Admin;


use App\Http\Requests\BaseFormRequest;

class CanonicalUpdateRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'url' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                'unique:canonicals,url,' . $this->route('canonical.id'),
            ],
            'canonical' => 'sometimes|required|string|max:255',
            'assigned_by_id' => 'sometimes|nullable|integer',
        ];
    }
}
