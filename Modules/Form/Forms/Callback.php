<?php


namespace Modules\Form\Forms;


class Callback extends Form
{
    public bool $sendToCrm = false;
    public bool $sendToBitrix = true;

    public function title(): string
    {
        return 'Обратный звонок';
    }

    public function ym(): ?string
    {
        return 'send_form';
    }

    public function ga(): ?string
    {
        return 'form_send1';
    }

    public function rules(): array
    {
        return [
            'phone' => 'required|string|phone:AM,AZ,RU,BY,UA,GE,KZ,MD,TM,KG,UZ,TJ|max:255',
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'phone' => 'Телефон',
        ];
    }
}
