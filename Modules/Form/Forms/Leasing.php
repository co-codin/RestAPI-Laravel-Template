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
            'phone' => 'required|string|phone:AM,AZ,RU,BY,UA,GE,KZ,MD,TM,KG,UZ,TJ|max:255',
//            'email' => 'sometimes|nullable|string|email|max:255',
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
            'phone' => 'Телефон',
            'email' => 'Email',
            'message' => 'Ваше сообщение',
        ];
    }

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
