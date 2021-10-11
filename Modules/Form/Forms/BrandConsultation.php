<?php

namespace Modules\Form\Forms;


class BrandConsultation extends Form
{
    public function title() : string
    {
        return 'Консультация (страница производителя)';
    }

    public function rules() : array
    {
        return [
            'brand' => 'required|string|max:255|exists:brands,id',
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

        $brandName = $this->getBrand()->name;
        $message = $this->getAttribute('message');

        return "
                $default
                <br><b>Производитель:</b> $brandName
                <br><b>Сообщение:</b> $message
                ";
    }
}
