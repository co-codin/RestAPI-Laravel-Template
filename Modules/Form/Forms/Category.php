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

    public function getComments(): string
    {
        $default = parent::getComments();

        $categoryName = $this->getCategory()->name;

        return "
                $default
                <br><b>Категория:</b> $categoryName
                ";
    }
}
