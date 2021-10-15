<?php


namespace Modules\Form\Forms;



class Director extends Form
{
    public bool $sendToCrm = false;
    public bool $sendToBitrix = false;

    public function emails(): ?array
    {
        return config('services.mails.director');
    }

    public function title(): string
    {
        return 'Письмо директору';
    }

    public function rules(): array
    {
        return [
//            'name' => 'required|string|max:255',
            'subject' => 'required|string|max:255|external_links',
            'message' => 'required|string|external_links',
        ];
    }

    public function ym(): ?string
    {
        return 'letter_to_director_button_rush';
    }

    public function ga(): ?string
    {
        return 'letter_to_director_button_rush1';
    }

    public function attributeLabels(): array
    {
        return [
            'auth_name' => 'Имя',
            'message' => 'Ваше сообщение',
        ];
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getComments(): string
    {
        $default = parent::getComments();

        $name = $this->getAuthName();
        $message = $this->getAttribute('message');

        return "
                $default
                <br><b>Имя:</b> $name
                <br><b>Сообщение:</b> $message
                ";
    }

    public function popupTitle(): string
    {
        return "Письмо директору успешно отправлено";
    }

    public function popupMessage(): string
    {
        return "Мы с вами свяжемся";
    }


}
