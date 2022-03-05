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
            'email' => 'required|string|email|max:255',
            'contact_person' => 'required|string|max:255',
            'message' => 'nullable|string|external_links',
            'file' => 'required|file|mimes:pdf,xlsx,xls,doc,docx,pptx,pps,ppt,jpeg,bmp,png|max:5120',
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'inn' => 'ИНН',
            'contact_person' => 'Контактное лицо',
            'message' => 'Текст претензии',
            'file' => 'Заявка',
        ];
    }

    public function messages(): array
    {
        return [
            'inn.regex' => 'ИНН может содержать от 10 до 15 символов',
            'file.max' => 'Размер файла в поле :attribute не может быть больше :max Кбайт.'
        ];
    }

    public function getComments(): string
    {
        $default = parent::getComments();

        $contactEmail = $this->getEmail();

        return "
                $default
                <br><b>Контактный E-mail:</b> $contactEmail
                ";
    }
}
