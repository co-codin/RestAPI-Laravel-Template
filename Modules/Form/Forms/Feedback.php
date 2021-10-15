<?php


namespace Modules\Form\Forms;



class Feedback extends Form
{
    public bool $sendToCrm = false;
    public bool $sendToBitrix = true;

    public function title(): string
    {
        return 'Обратная связь';
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
        return 'send_form_feedback';
    }

    public function ga(): ?string
    {
        return 'send_form_feedback1';
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
}
