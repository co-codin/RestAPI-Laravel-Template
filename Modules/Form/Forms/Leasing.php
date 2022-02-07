<?php


namespace Modules\Form\Forms;


class Leasing extends Form
{
    public function title(): string
    {
        return 'Заявка на финансирование';
    }

    public function rules(): array
    {
        return [
            'product' => 'required|integer|exists:products,id',
            'approximate_price' => 'required|integer',
            'advance_amount' => 'required|integer',
            'leasing_term' => 'required|string|max:255',
            'initial_payment' => 'required|integer',
            'monthly_payment' => 'required|integer',
        ];
    }

    public function ym(): ?string
    {
        return 'send_installment_plan';
    }

    public function ga(): ?string
    {
        return 'send_installment_plan1';
    }

    public function attributeLabels(): array
    {
        return [
            'auth_name' => 'Имя',
            'approximate_price' => 'Примерная стоимость',
            'advance_amount' => 'Размер аванса',
            'leasing_term' => 'Срок лизинга',
            'initial_payment' => 'Первоначальный взнос',
            'monthly_payment' => 'Ежемесячный платеж',
        ];
    }

    public function getComments(): string
    {
        $default = parent::getComments();

        $name = $this->getAuthName();

        $approximatePrice = $this->getAttribute('approximate_price');
        $advanceAmount = $this->getAttribute('advance_amount');
        $leasingTerm = $this->getAttribute('leasing_term');
        $initialPayment = $this->getAttribute('initial_payment');
        $monthlyPayment = $this->getAttribute('monthly_payment');

        return "
                $default
                <br><b>Имя:</b> $name
                <br><b>Примерная стоимость:</b> $approximatePrice
                <br><b>Размер аванса:</b> $advanceAmount
                <br><b>Срок лизинга:</b> $leasingTerm
                <br><b>Первоначальный взнос:</b> $initialPayment
                <br><b>Ежемесячный платеж:</b> $monthlyPayment
                ";
    }
}
