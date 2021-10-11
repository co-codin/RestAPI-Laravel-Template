<?php

namespace Modules\Form\Forms;


class ProductConsultation extends Form
{
    public function title() : string
    {
        return 'Консультация (страница товара)';
    }

    public function rules() : array
    {
        return [
            'product' => 'required|integer|exists:products,id',
            'message' => 'required|string|max:1000|external_links',
        ];
    }

    public function ga(): ?string
    {
        return 'need_consultation1';
    }

    public function getComments(): string
    {
        $default = parent::getComments();

        $message = $this->getAttribute('message');
        $product = $this->getProduct();

        $link = config('app.site_url') . "/product/$product->slug/$product->id";
        $productFullTitle = $product->brand->name . ' ' . $product->name;

        return "
                $default
                <br><b>Сообщение:</b> $message
                <br><b>Оборудование:</b> $productFullTitle
                <br><b>Ссылка на оборудование:</b> $link
                ";
    }
}
