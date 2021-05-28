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
            'name' => 'ФИО',
        ];
    }

    public function getComments(): string
    {
        $name = $this->getAttribute('name');

        $date = Carbon::parse(now())->format('d.m.Y H:i:s');
        $url = url()->previous();

        return "
                <b>Получена заявка:</b> $date
                <br><b>Форма:</b> {$this->title()}
                <br><b>Страница:</b> $url
                <br><b>ФИО лица:</b> $name
                <br><b>Телефон:</b> {$this->getPhone()}
                <br><b>Email:</b> {$this->getEmail()}
                ";
    }
}
