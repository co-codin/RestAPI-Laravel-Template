<?php

namespace Modules\Client\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientActivityStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'action' => 'required|string',
            'data' => 'sometimes|array'
        ];
    }
}
