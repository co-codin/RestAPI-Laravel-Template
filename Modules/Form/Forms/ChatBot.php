<?php

namespace Modules\Form\Forms;


/**
 * Class ChatBot
 * @package Modules\Form\Forms
 * @property array $companyTypes
 * @property array $options
 */
class ChatBot extends Form
{
    protected $companyTypes = [
        "private" => "Частная",
        "state" => "Государственная",
        "trade" => "Торговая",
    ];

    protected $options = [
        'obsie' => 'Общие',
        'kardiologiceskie' => 'Кардио',
        'ginekologiceskie' => 'Гинекология',
        'fibroskopy' => 'Фиброэндоскопия',
        'videoendoskopy' => 'Видеоэндоскопия',
        'prinadleznosti-2' => 'Комплектующие',
        'narkozniki' => 'Наркозник',
        'apparaty-ivl' => 'Аппарат ИВЛ',
        'monitory' => 'Монитор пациента',
        'defibrillatory' => 'Дефибриллятор',
        'dla-novorozdennyh' => 'Инкубатор',
        'lor_kombajny' => 'ЛОР комбайн',
        'kresla' => 'Кресло',
        'prinadleznosti' => 'Комплектующие',
        'mrt' => 'МРТ',
        'kt' => 'КТ',
        'pet' => 'ПЭТ',
        'stacionarnye_2' => 'Стационарный',
        'palatnye' => 'Палатный',
        'mammografy' => 'Маммограф',
        'angiografy_i_s_dugi' => 'Ангиограф или С-дуга',
        'fluorografy' => 'Флюорограф',
        'kolposkopy_2' => 'Кольпоскоп',
        'kombajny' => 'Гинекологический комбайн',
        'kresla_2' => 'Кресло',
    ];

    public function title(): string
    {
        return 'Чат бот';
    }

    public function rules(): array
    {
        $options = implode(',', array_keys($this->options));
        $companyTypes = implode(',', array_keys($this->companyTypes));

        return [
            'phone' => 'required|string|phone:AM,AZ,RU,BY,UA,GE,KZ,MD,TM,KG,UZ,TJ|max:255',
            'brand' => 'sometimes|nullable|string|max:255|exists:brands,slug',
            'hasBrand' => 'sometimes|nullable|string',
            'category' => 'sometimes|nullable|string|max:255|exists:categories,slug',
            'subCategory' => 'sometimes|nullable|string|max:255|in:' . $options,
            'companyType' => 'sometimes|nullable|string|max:255|in:' . $companyTypes,
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'phone' => 'Телефон',
            'category' => 'Направление',
            'subCategory' => 'Доп. вопрос',
            'companyType' => 'Тип компании',
            'brand' => 'Производитель',
            'hasBrand' => 'Определились с производителем',
        ];
    }

    public function ym(): ?string
    {
        return 'bot_button_rush';
    }

    public function ga(): ?string
    {
        return 'bot_button_rush';
    }

    public function jsCallbackReturn(): bool
    {
        return true;
    }

    protected function getCompanyType(): string
    {
        $type = \Arr::get($this->attributes, 'companyType');
        return \Arr::get($this->companyTypes, $type, 'Не выбран тип компании');
    }

    protected function getSubCategory(): string
    {
        $subCategory = \Arr::get($this->attributes, 'subCategory');
        return \Arr::get($this->options, $subCategory, 'Не ответили на доп. вопрос');
    }

    public function getComments(): string
    {
        $default = parent::getComments();

        $hasBrand = \Arr::get($this->attributes, 'hasBrand');
        $hasBrand = $hasBrand === 'Yes' ? 'Да' : 'Нет';

        $brand = $this->getBrand();
        $brandTitle = optional($brand)->title;
        $brandComment = $this->getComment("<br><b>Производитель:</b>", $brandTitle);

        $category = $this->getCategory();
        $categoryTitle = optional($category)->title;
        $categoryComment = $this->getComment("<br><b>Категория:</b>", $categoryTitle);

        $companyType = $this->getCompanyType();
        $subCategory = $this->getSubCategory();

        return "
                $default
                $brandComment
                $categoryComment
                <br><b>Тип компании:</b> {$companyType}
                <br><b>Доп. вопрос:</b> {$subCategory}
                <br><b>Определились с производителем:</b> {$hasBrand}
                ";
    }
}
