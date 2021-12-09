<?php


namespace Modules\Form\Forms;


/**
 * Class GetClientsList
 * @package Modules\Form\Forms
 */
class GetClientsList extends Form
{
    public function title(): string
    {
        return 'Запрос на список клиентов из города';
    }

    public function rules(): array
    {
        return [
            'city' => 'required|integer|exists:cities,id',
        ];
    }

    public function ym(): ?string
    {
        return 'city';
    }

    public function ga(): ?string
    {
        return 'city1';
    }

    public function getComments(): string
    {
        $default = parent::getComments();

        $cityName = $this->getCity()?->name;

        return "
                $default
                <br><b>Город: $cityName</b>
                ";
    }
}
