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
        ];
    }

    public function attributeLabels(): array
    {
        return [
        ];
    }
}
