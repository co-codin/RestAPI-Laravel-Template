<?php


namespace Modules\Form\Forms;


/**
 * Class GetClientsList
 * @package Modules\Form\Forms
 */
class GetClientsList extends Form
{
    public function title(): string
    {
        return 'Запрос на список клиентов из города';
    }

    public function rules(): array
    {
        return [
            'phone' => 'required|string|phone:AM,AZ,RU,BY,UA,GE,KZ,MD,TM,KG,UZ,TJ|max:255',
//            'email' => 'required|string|email|max:255',
            'city' => 'required|integer|exists:cities,id',
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'phone' => 'Телефон',
            'email' => 'E-mail',
        ];
    }

    public function ym(): ?string
    {
        return 'city';
    }

    public function ga(): ?string
    {
        return 'city1';
    }

    public function getComments(): string
    {
        $default = parent::getComments();

        $city = $this->getCity();

        return "
                $default
                <br><b>Город:</b> {$city->title}
                ";
    }
}
