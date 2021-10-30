<?php

namespace Modules\Form\Forms;


use Modules\Product\Models\Product;

class Checkout extends Form
{
    public bool $sendToBitrix = false;

    public function title(): string
    {
        return 'Оформление заказа';
    }

    public function rules(): array
    {
        return [
            'products' => 'required|array',
            'products.*.id' => 'required|integer|exists:products,id',
            'products.*.number' => 'required|integer',
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'products' => 'Товары',
            'products.*.id' => 'Товар',
            'products.*.number' => 'Количество',
        ];
    }

    public function ym(): ?string
    {
        return 'get-price';
    }

    public function ga(): ?string
    {
        return 'submit_a_request';
    }

    public function fbq(): ?string
    {
        return 'new_order';
    }

    public function getComments(): string
    {
        $default = parent::getComments();

        $products = collect($this->getAttribute('products'))->map(function ($item) {
            $product = Product::find($item['id']);

            return $product->brand->name
                . " " . $product->name
                . " - " . $item['number'] . " шт.";
        })
            ->join("<br>");

        return "
                $default
                <br><b>Товары:</b> <br> $products
                ";
    }
}
