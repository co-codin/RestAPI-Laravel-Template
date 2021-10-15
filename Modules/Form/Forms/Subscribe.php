<?php

namespace Modules\Form\Forms;

class Subscribe extends Form
{
    public bool $sendToCrm = false;
    public bool $withAuth = false;

    public function title(): string
    {
        return 'Подписка';
    }

    public function rules(): array
    {
        return [
            'contact_email' => 'required|string|email|max:255',
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'contact_email' => 'E-mail',
        ];
    }

    public function getComments(): string
    {
        $default = parent::getComments();

        $contactEmail = $this->getAttribute('contact_email');

        return "
                $default
                <br><b>Контактный E-mail:</b> $contactEmail
                ";
    }
}
