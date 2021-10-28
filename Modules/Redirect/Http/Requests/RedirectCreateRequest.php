<?php


namespace Modules\Redirect\Http\Requests;


use App\Http\Requests\BaseFormRequest;

class RedirectCreateRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'source' => 'required|string|max:255|unique:redirects,source',
            'destination' => 'required|string|max:255',
            'code' => 'sometimes|integer|digits:3|in:301,302',
            'assigned_by_id' => 'sometimes|nullable|integer',
        ];
    }

    public function attributes()
    {
        return [
            'source' => 'Откуда',
            'destination' => 'Куда',
            'code' => 'Код',
        ];
    }
}
