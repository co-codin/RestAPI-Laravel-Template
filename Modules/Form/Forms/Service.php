<?php


namespace Modules\Form\Forms;


use Carbon\Carbon;

class Service extends Form
{
    public function title(): string
    {
        return 'Ремонт';
    }

    public function rules(): array
    {
        return [
//            'name' => 'required|string|max:255',
        ];
    }

    public function ym(): ?string
    {
        return 'repair_button_rush';
    }

    public function ga(): ?string
    {
        return 'repair_button_rush1';
    }

    public function attributeLabels(): array
    {
        return [
            'auth_name' => 'ФИО',
        ];
    }

    public function getComments(): string
    {
        $date = Carbon::parse(now())->format('d.m.Y H:i:s');
        $url = url()->previous();

        return "
                <b>Получена заявка:</b> $date
                <br><b>Форма:</b> {$this->title()}
                <br><b>Страница:</b> $url
                <br><b>ФИО лица:</b> {$this->getAuthName()}
                <br><b>Телефон:</b> {$this->getAuthPhone()}
                <br><b>Email:</b> {$this->getAuthEmail()}
                ";
    }
}
