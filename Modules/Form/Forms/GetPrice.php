<?php

namespace Modules\Form\Forms;

use Modules\Category\Models\Category;
use Modules\Form\Casts\CategoryCast;

/**
 * Class GetPrice
 * @package Modules\Form\Forms
 */
class GetPrice extends Form
{
    public function title(): string
    {
        return 'Быстрый заказ';
    }

    public function rules(): array
    {
        return [
            'phone' => 'required|string|phone:AM,AZ,RU,BY,UA,GE,KZ,MD,TM,KG,UZ,TJ|max:255',
            'product_id' => 'required|integer|exists:products,id',
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'phone' => 'Телефон',
            'product_id' => 'Продукция',
            'accept' => 'accept',
        ];
    }

    public function response(): array
    {
        return array_merge(parent::response(), [
            'title' => $this->popupTitle(),
            'message' => $this->popupMessage(),
        ]);
    }

    public function ym(): ?string
    {
        return 'get-price';
    }

    public function ga(): ?string
    {
        return 'submit_a_request';
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
