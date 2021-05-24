<?php

namespace Modules\Form\Forms;


/**
 * Class Dealers
 * @package Modules\Form\Forms
 */
class Dealers extends Form
{
    public function title(): string
    {
        return 'Консультация (страница дилеров)';
    }

    public function rules(): array
    {
        return [
            'phone' => 'required|string|phone:AM,AZ,RU,BY,UA,GE,KZ,MD,TM,KG,UZ,TJ|max:30',
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'phone' => 'Телефон',
        ];
    }

    public function ym(): ?string
    {
        return 'contact_us_dealer';
    }

    public function ga(): ?string
    {
        return 'contact_us_dealer1';
    }
}
