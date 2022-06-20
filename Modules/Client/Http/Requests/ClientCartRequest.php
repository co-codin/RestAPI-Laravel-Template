<?php

namespace Modules\Client\Http\Requests;

use App\Http\Requests\BaseFormRequest;

class ClientCartRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'product_variation_id' => 'required|integer|exists:product_variations,id|unique:client_carts,product_variation_id,' . $this->get('id'),
            'count' => 'required|integer',
        ];
    }
}
