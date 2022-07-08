<?php

namespace Modules\Geo\Http\Requests;

use App\Http\Requests\BaseFormRequest;

class CityPageRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'name' => 'sometimes|required|string|max:30',
        ];
    }
}
