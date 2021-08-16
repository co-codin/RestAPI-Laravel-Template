<?php

namespace Modules\Form\Forms;

class TestForm extends Form
{
    public bool $sendToBitrix = false;

    public function title(): string
    {
        return 'test form';
    }

    public function rules(): array
    {
        return [
            'document' => 'required|file',
            'images' => 'required',
            'images.*' => 'required|image',
            'name' => 'required|string',
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'document' => 'Документ',
            'images' => 'Изображения',
            'images.*' => 'Изображение',
            'name' => 'Имя',
        ];
    }
}
