<?php


namespace Modules\Form\Forms;



class Director extends Form
{
    public bool $sendToCrm = false;
    public bool $sendToBitrix = false;

    public function emails(): ?array
    {
        $email = config('services.mails.director');

        return !is_null($email) ? $email : null;
    }

    public function title(): string
    {
        return 'Письмо директору';
    }

    public function rules(): array
    {
        return [
//            'name' => 'required|string|max:255',
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
            'name' => 'Имя',
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

        $name = \Arr::get($this->attributes, 'name');
        $message = \Arr::get($this->attributes, 'message');

        return "
                $default
                <br><b>Имя:</b> {$name}
                <br><b>Сообщение:</b> {$message}
                ";
    }
}
