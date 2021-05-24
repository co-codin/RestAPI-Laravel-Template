<?php

namespace Modules\Form\Forms;

class HomeSubscribe extends Form
{
    public bool $sendToCrm = false;
    public bool $sendToBitrix = false;

    public function title(): string
    {
        return 'Подписка на акции (главная)';
    }

    public function rules(): array
    {
        return [
//            'email' => 'required|string|email|max:255',
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'email' => 'E-mail',
        ];
    }

    public function ym(): ?string
    {
        return 'mailing_button_rush';
    }

    public function ga(): ?string
    {
        return 'mailing_button_rush';
    }
}
