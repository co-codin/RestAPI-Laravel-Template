<?php

namespace Modules\Form\Forms;

use Modules\Category\Models\Category;
use Modules\Form\Casts\CategoryCast;

/**
 * Class Consultation
 * @package Modules\Form\Forms
 */
class Consultation extends Form
{
    public function title() : string
    {
        return 'Консультация';
    }

    public function rules() : array
    {
        return [
            'product' => 'required|integer|exists:products,id',
        ];
    }

    public function attributeLabels() : array
    {
        return [
            'product' => 'Продукция',
        ];
    }

    public function ym(): ?string
    {
        return 'need_consultation_card';
    }

    public function ga(): ?string
    {
        return 'need_consultation_card1';
    }

    public function getCategory(): ?Category
    {
        return (new CategoryCast())->getCategoryByProduct(
            $this->getProduct()
        );
    }

    public function getComments(): string
    {
        $default = parent::getComments();

        $product = $this->getProduct();

        $categoryComment = $this->getComment("<br><b>Категория:</b>", $this->getCategory()?->name);

        $link = config('app.site_url') . "/product/$product->slug/$product->id";

        $productFullTitle = $product->brand->name . ' ' . $product->name;

        return "
                $default
                $categoryComment
                <br><b>Оборудование:</b> $productFullTitle
                <br><b>Ссылка на оборудование:</b> $link
                ";
    }
}
