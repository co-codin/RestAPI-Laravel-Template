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
}
