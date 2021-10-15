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

    public function popupTitle(): string
    {
        return 'Вы успешно подписались на новостную рассылку!';
    }

    public function popupMessage(): string
    {
        return 'В скором времени вы начнете получать новости';
    }
}
