<?php


namespace App\Http\Requests\Admin;


use Illuminate\Foundation\Http\FormRequest;

class FieldValueUpdateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'value' => 'required|unique:field_values,value,' . $this->route('field_value'),
        ];
    }
}
