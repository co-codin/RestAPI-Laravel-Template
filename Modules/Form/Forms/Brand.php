<?php

namespace Modules\Form\Forms;


/**
 * Class Brand
 * @package Modules\Form\Forms
 */
class Brand extends Form
{
    public function title(): string
    {
        return 'Подробнее о производителе';
    }

    public function rules(): array
    {
        return [
            'brand' => 'required|string|max:255|exists:brands,slug',
        ];
    }

    public function ym(): ?string
    {
        return 'contact_us';
    }

    public function ga(): ?string
    {
        return 'contact_us';
    }

    public function getComments(): string
    {
        $default = parent::getComments();

        $brand = $this->getBrand();

        return "
                $default
                <br><b>Производитель:</b> {$brand->name}
                ";
    }
}
