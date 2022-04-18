<?php


namespace Modules\Redirect\Http\Requests;


use App\Http\Requests\BaseFormRequest;
use BenSampo\Enum\Rules\EnumValue;
use Modules\Redirect\Enums\RedirectCode;

/**
 * Class RedirectCreateRequest
 * @package Modules\Redirect\Http\Requests\Admin
 */
class RedirectUpdateRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'source' => 'sometimes|required|string|max:255|unique:redirects,source,' . $this->route('redirect'),
            'destination' => 'sometimes|required|string|max:255',
            'code' => [
                'sometimes',
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
