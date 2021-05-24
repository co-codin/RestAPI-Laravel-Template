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
            'phone' => 'required|string|phone:AM,AZ,RU,BY,UA,GE,KZ,MD,TM,KG,UZ,TJ|max:255',
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
            'phone' => 'Телефон',
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

        $product = $this->getProduct()->present();

        $category = $this->getCategory();
        $categoryTitle = optional($category)->title;
        $categoryComment = $this->getComment("<br><b>Категория:</b>", $categoryTitle);

        $link = route('product-view', [
            'slug' => $product->slug,
            'id' => $product->id,
        ]);

        return "
                $default
                $categoryComment
                <br><b>Оборудование:</b> {$product->getFullTitle()}
                <br><b>Ссылка на оборудование:</b> $link
                ";
    }
}
