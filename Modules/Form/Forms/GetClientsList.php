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
//            'city' => 'required|integer|exists:cities,id', //не интегрирована еще эта таблица
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

//        $city = $this->getCity();

        return "
                $default
                <br><b>Город:</b>
                ";
    }
}
