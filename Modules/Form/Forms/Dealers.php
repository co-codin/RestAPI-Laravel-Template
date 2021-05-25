<?php

namespace Modules\Form\Forms;


/**
 * Class Dealers
 * @package Modules\Form\Forms
 */
class Dealers extends Form
{
    public function title(): string
    {
        return 'Консультация (страница дилеров)';
    }

    public function ym(): ?string
    {
        return 'contact_us_dealer';
    }

    public function ga(): ?string
    {
        return 'contact_us_dealer1';
    }
}
