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
            'url' => 'sometimes|nullable|string|max:255',
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'first_name' => 'Имя',
            'last_name' => 'Фамилия',
            'url' => 'url',
        ];
    }

    public function getComments(): string
    {
        $default = parent::getComments();

        $vacancyUrlComment = $this->getComment(
            "<br><b>Ссылка на вакансию:</b>",
            $this->getAttribute('url')
        );

        return "
                $default
                $vacancyUrlComment
                ";
    }
}
