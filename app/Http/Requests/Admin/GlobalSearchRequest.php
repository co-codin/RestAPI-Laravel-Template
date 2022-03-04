<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class GlobalSearchRequest extends FormRequest
{
    public function rules()
    {
        return [
            'term' => 'required|string|max:70|min:2',
        ];
    }
}
