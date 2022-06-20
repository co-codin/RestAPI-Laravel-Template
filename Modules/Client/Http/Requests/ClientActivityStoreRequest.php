<?php

namespace Modules\Client\Http\Requests;

use App\Http\Requests\BaseFormRequest;

class ClientActivityStoreRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'action' => 'required|string',
            'data' => 'sometimes|array'
        ];
    }
}
