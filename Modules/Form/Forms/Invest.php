<?php


namespace Modules\Form\Forms;


class Invest extends Form
{
    public function title(): string
    {
        return 'Свяжитесь со мной (страница для инвесторов)';
    }

    public function rules(): array
    {
        return [
            'phone' => 'required|string|phone:AM,AZ,RU,BY,UA,GE,KZ,MD,TM,KG,UZ,TJ|max:255',
//            'email' => 'required|string|email|max:255',
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'phone' => 'Телефон',
            'email' => 'E-mail',
        ];
    }
}
