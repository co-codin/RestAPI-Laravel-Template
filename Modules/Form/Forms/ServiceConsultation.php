<?php

namespace Modules\Form\Forms;


/**
 * Class ServiceConsultation
 * @package Modules\Form\Forms
 */
class ServiceConsultation extends Form
{
    public function title(): string
    {
        return 'Консультация (страница сервиса)';
    }

    public function rules(): array
    {
        return [
            'phone' => 'required|string|phone:AM,AZ,RU,BY,UA,GE,KZ,MD,TM,KG,UZ,TJ|max:30',
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'phone' => 'Телефон',
        ];
    }
}
