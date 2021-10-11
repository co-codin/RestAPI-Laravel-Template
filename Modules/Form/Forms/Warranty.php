<?php

namespace Modules\Form\Forms;

class Warranty extends Form
{
    public bool $sendToBitrix = false;

    public function title(): string
    {
        return 'Гарантия';
    }

    public function rules(): array
    {
        return [
            'inn' => 'nullable|regex:/^\d{10,15}$/',
            'contact_person' => 'required|string|max:255',
            'message' => 'nullable|string|external_links',
            'file' => 'required|file|mimes:pdf,xlsx,xls,doc,docx,pptx,pps,ppt,jpeg,bmp,png|max:1024',
            'email' => 'required|string|email|max:255',
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'inn' => 'ИНН',
            'email' => 'E-mail',
            'contact_person' => 'Контактное лицо',
            'message' => 'Текст претензии',
            'file' => 'Заявка',
        ];
    }

    public function messages(): array
    {
        return [
            'inn.regex' => 'ИНН может содержать от 10 до 15 символов',
        ];
    }
}
