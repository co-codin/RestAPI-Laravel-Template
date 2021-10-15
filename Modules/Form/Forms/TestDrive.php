<?php

namespace Modules\Form\Forms;

use Modules\Category\Models\Category;
use Modules\Form\Casts\CategoryCast;

/**
 * Class TestDrive
 * @package Modules\Form\Forms
 */
class TestDrive extends Form
{
    public function title() : string
    {
        return 'Тест-драйв';
    }

    public function rules() : array
    {
        return [
            'product' => 'required|integer|exists:products,id',
        ];
    }

    public function ym(): ?string
    {
        return 'send_view_request';
    }

    public function ga(): ?string
    {
        return 'send_view_request1';
    }

    public function attributeLabels() : array
    {
        return [
            'product' => 'Продукция',
        ];
    }

    public function getCategory(): ?Category
    {
        $product = $this->getProduct();

        return (new CategoryCast())->getCategoryByProduct($product);
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
