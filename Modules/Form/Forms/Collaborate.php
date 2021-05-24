<?php

namespace Modules\Form\Forms;

class Collaborate extends Form
{
    public bool $sendToBitrix = false;

    public function title(): string
    {
        return "Сотрудничество";
    }

    public function rules(): array
    {
        return [
            'company' => 'required|string|max:255',
            'inn' => 'required|regex:/^\d{10,15}$/',
            'already_collaborate' => 'nullable|boolean',
            'collaborated_earlier' => 'nullable|boolean',
            'message' => 'nullable|string|external_links',
            'file' => 'required|file|mimes:pdf,xlsx,xls,doc,docx,pptx,pps,ppt,jpeg,bmp,png|max:1024',
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'company' => 'Организация',
            'inn' => 'ИНН',
            'already_collaborate' => 'Есть ли у вас текущие договорные отношения с Медэк Старз?',
            'collaborated_earlier' => 'Вы уже сотрудничали с Медэк Старз ранее?',
            'message' => 'Текст претензии',
            'file' => 'Заявка',
        ];
    }

    public function messages(): array
    {
        return [
            'inn.regex' => 'ИНН может содержать от 10 до 15 символов',
            'file.file' => 'Необходимо прикрепить файл к заявке',
            'file.required' => 'Необходимо прикрепить файл к заявке',
        ];
    }
}
