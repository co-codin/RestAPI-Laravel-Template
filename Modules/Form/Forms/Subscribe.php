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
            'email' => 'required|string|email|max:255',
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
