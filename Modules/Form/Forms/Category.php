<?php

namespace Modules\Form\Forms;


/**
 * Class Category
 * @package Modules\Form\Forms
 */
class Category extends Form
{
    public function title(): string
    {
        return 'Подробнее о категории';
    }

    public function rules(): array
    {
        return [
            'phone' => 'required|string|phone:AM,AZ,RU,BY,UA,GE,KZ,MD,TM,KG,UZ,TJ|max:255',
            'category' => 'required|string|max:255|exists:categories,slug',
        ];
    }

    public function ym(): ?string
    {
        return 'contact_us_category';
    }

    public function ga(): ?string
    {
        return 'contact_us_category1';
    }

    public function attributeLabels(): array
    {
        return [
            'phone' => 'Телефон',
            'category' => 'Категория',
        ];
    }
}
