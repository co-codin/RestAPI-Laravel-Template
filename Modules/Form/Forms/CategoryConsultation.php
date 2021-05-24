<?php

namespace Modules\Form\Forms;


/**
 * Class CategoryConsultation
 * @package Modules\Form\Forms
 */
class CategoryConsultation extends Form
{
    public function title() : string
    {
        return 'Консультация (страница категории)';
    }

    public function rules() : array
    {
        return [
            'phone' => 'required|string|phone:AM,AZ,RU,BY,UA,GE,KZ,MD,TM,KG,UZ,TJ|max:255',
            'category' => 'required|string|max:255|exists:categories,slug',
            'brand' => 'sometimes|string|max:255|exists:brands,slug',
        ];
    }

    public function ga(): ?string
    {
        return 'need_consultation1';
    }

    public function attributeLabels() : array
    {
        return [
            'phone' => 'Телефон',
            'category' => 'Категория',
            'brand' => 'Производитель',
        ];
    }

    public function getComments(): string
    {
        $default = parent::getComments();

        $category = $this->getCategory();

        $brand = $this->getBrand();
        $title = optional($brand)->title;

        $brandComment = $this->getComment("<br><b>Производитель:</b>", $title);

        return "
                $default
                $brandComment
                <br><b>Категория:</b> {$category->title}
                ";
    }
}
