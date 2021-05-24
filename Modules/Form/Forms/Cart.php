<?php

namespace Modules\Form\Forms;


use Modules\Product\Models\ProductVariation;

class Cart extends Form
{
    public bool $sendToBitrix = false;

    public function title(): string
    {
        return 'Оформление заказа';
    }

    public function rules(): array
    {
        return [
            'variations' => 'required|array',
            'variations.*.id' => 'required|integer|exists:product_variations,id',
            'variations.*.number' => 'required|integer',
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'variations' => 'Товары',
            'variations.*.id' => 'Товар',
            'variations.*.number' => 'Количество',
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

    public function getComments(): string
    {
        $default = parent::getComments();

        $variations = collect($this->getAttribute('variations'))->map(function($item) {
            $variation = ProductVariation::find($item['id']);
            return $variation->product->brand->title . " " . $variation->product->title . " - " . $item['number'] . " шт.";
        })->join("<br>");

        return "
                $default
                <br><b>Товары:</b> <br> {$variations}
                ";
    }
}
