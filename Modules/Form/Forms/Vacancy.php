<?php


namespace Modules\Form\Forms;


class Vacancy extends Form
{
    public bool $sendToCrm = false;
    public bool $sendToBitrix = false;

    public function title(): string
    {
        return 'Заявка на вакансию';
    }

    public function rules(): array
    {
        return [
//            'email' => 'required|string|email|max:255',
            'phone' => 'required|string|phone:AM,AZ,RU,BY,UA,GE,KZ,MD,TM,KG,UZ,TJ|max:255',
            'url' => 'sometimes|nullable|string|max:255',
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'first_name' => 'Имя',
            'last_name' => 'Фамилия',
            'email' => 'Email',
            'phone' => 'Телефон',
            'url' => 'url',
        ];
    }

    public function getComments(): string
    {
        $default = parent::getComments();

        $vacancyUrl = \Arr::get($this->attributes, 'url');
        $vacancyUrlComment = $this->getComment("<br><b>Ссылка на вакансию:</b>", $vacancyUrl);

        return "
                $default
                $vacancyUrlComment
                ";
    }
}
