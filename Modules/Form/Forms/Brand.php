<?php

namespace Modules\Form\Forms;


/**
 * Class Brand
 * @package Modules\Form\Forms
 */
class Brand extends Form
{
    public function title(): string
    {
        return 'Подробнее о производителе';
    }

    public function rules(): array
    {
        return [
            'phone' => 'required|string|phone:AM,AZ,RU,BY,UA,GE,KZ,MD,TM,KG,UZ,TJ|max:255',
            'brand' => 'required|string|max:255|exists:brands,slug',
        ];
    }

    public function ym(): ?string
    {
        return 'contact_us';
    }

    public function ga(): ?string
    {
        return 'contact_us';
    }


    public function attributeLabels(): array
    {
        return [
            'phone' => 'Телефон',
            'brand' => 'Производитель',
        ];
    }

    public function getComments(): string
    {
        $default = parent::getComments();

        $brand = $this->getBrand();

        return "
                $default
                <br><b>Производитель:</b> {$brand->title}
                ";
    }
}
