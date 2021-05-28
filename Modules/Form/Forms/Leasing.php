<?php


namespace Modules\Form\Forms;


class Leasing extends Form
{
    public function title(): string
    {
        return 'Заявка на финансирование';
    }

    public function rules(): array
    {
        return [
//            'name' => 'required|string|max:255',
            'message' => 'required|string',
        ];
    }

    public function ym(): ?string
    {
        return 'send_installment_plan';
    }

    public function ga(): ?string
    {
        return 'send_installment_plan1';
    }

    public function attributeLabels(): array
    {
        return [
            'name' => 'Имя',
            'message' => 'Ваше сообщение',
        ];
    }

    public function getComments(): string
    {
        $default = parent::getComments();

        $name = $this->getAttribute('name');
        $message = $this->getAttribute('message');

        return "
                $default
                <br><b>Имя:</b> $name
                <br><b>Сообщение:</b> $message
                ";
    }
}
