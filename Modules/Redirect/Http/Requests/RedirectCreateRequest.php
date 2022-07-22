<?php


namespace Modules\Redirect\Http\Requests;


use App\Http\Requests\BaseFormRequest;
use BenSampo\Enum\Rules\EnumValue;
use Modules\Redirect\Enums\RedirectCode;

class RedirectCreateRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'source' => 'required|string|max:255|unique:redirects,source',
            'destination' => 'required|string|max:255',
            'code' => [
                'required',
                'integer',
                'digits:3',
                new EnumValue(RedirectCode::class, false),
            ],
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
