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
            'category' => 'required|string|max:255|exists:categories,slug',
            'brand' => 'sometimes|string|max:255|exists:brands,slug',
        ];
    }

    public function ga(): ?string
    {
        return 'need_consultation1';
    }

    public function getComments(): string
    {
        $default = parent::getComments();

        $categoryName = $this->getCategory()->name;
        $brandComment = $this->getComment("<br><b>Производитель:</b>", $this->getBrand()?->name);

        return "
                $default
                $brandComment
                <br><b>Категория:</b> $categoryName
                ";
    }
}
