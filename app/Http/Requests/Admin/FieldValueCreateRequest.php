<?php


namespace App\Http\Requests\Admin;


use Illuminate\Foundation\Http\FormRequest;

class FieldValueCreateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'value' => 'required|unique:field_values,value',
        ];
    }
}
