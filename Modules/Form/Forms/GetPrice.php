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
            'product_id' => 'required|integer|exists:products,id',
        ];
    }

    public function attributeLabels(): array
    {
        return [
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

        $product = $this->getProduct();

        $categoryComment = $this->getComment(
            "<br><b>Категория:</b>",
            optional($this->getCategory())->name
        );

        $link = route('product-view', [
            'slug' => $product->slug,
            'id' => $product->id,
        ]);

        $productFullTitle = $product->brand->name . ' ' . $product->name;

        return "
                $default
                $categoryComment
                <br><b>Оборудование:</b> $productFullTitle
                <br><b>Ссылка на оборудование:</b> $link
                ";
    }
}
