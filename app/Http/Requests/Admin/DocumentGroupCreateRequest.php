<?php


namespace App\Http\Requests\Admin;


use Illuminate\Foundation\Http\FormRequest;

class DocumentGroupCreateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|unique:document_groups,name',
        ];
    }
}
