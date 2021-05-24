<?php


namespace Modules\Form\Forms;


use Carbon\Carbon;

class PartnerRecommend extends Form
{
    public function title(): string
    {
        return 'Рекомендация';
    }

    public function rules(): array
    {
        return [
            'company' => 'required|string|max:255',
            'city-title' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'post' => 'required|string|max:255',
            'phone' => 'required|string|phone:AM,AZ,RU,BY,UA,GE,KZ,MD,TM,KG,UZ,TJ|max:255',
//            'email' => 'required|string|email|max:255',
            'recommend_name' => 'required|string|max:255',
            'recommend_phone' => 'required|string|phone:AM,AZ,RU,BY,UA,GE,KZ,MD,TM,KG,UZ,TJ|max:255',
            'recommend_email' => 'required|string|email|max:255',
            'comment' => 'required|string|max:1024',
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'company' => 'Название компании',
            'city' => 'Город',
            'name' => 'ФИО контактного лица',
            'post' => 'Должность',
            'phone' => 'Телефон контактного лица',
            'email' => 'Email контактного лица',
            'recommend_name' => 'ФИО рекомендующего',
            'recommend_phone' => 'Телефон рекомендующего',
            'recommend_email' => 'email рекомендующего',
            'comment' => 'Комментарий',
        ];
    }

    public function getComments(): string
    {
        $company = \Arr::get($this->attributes, 'company');
        $city = \Arr::get($this->attributes, 'city');
        $name = \Arr::get($this->attributes, 'name');
        $post = \Arr::get($this->attributes, 'post');

        $recommend_name = \Arr::get($this->attributes, 'recommend_name');
        $recommend_phone = \Arr::get($this->attributes, 'recommend_phone');
        $recommend_email = \Arr::get($this->attributes, 'recommend_email');
        $comment = \Arr::get($this->attributes, 'comment');

        $date = Carbon::parse(now())->format('d.m.Y H:i:s');
        $url = url()->previous();

        return "
                <b>Получена заявка:</b> $date
                <br><b>Форма:</b> {$this->title()}
                <br><b>Страница:</b> $url
                <br><b>Данные рекомендуемой компании:</b>
                <br><b>Компания:</b> {$company}
                <br><b>Город:</b> {$city}
                <br><b>ФИО лица, принимающего решения:</b> {$name}
                <br><b>Должность:</b> {$post}
                <br><b>Телефон:</b> {$this->getPhone()}
                <br><b>Email:</b> {$this->getEmail()}
                <br><b>Ваши контактные данные:</b>
                <br><b>ФИО:</b> {$recommend_name}
                <br><b>Телефон:</b> {$recommend_phone}
                <br><b>Email:</b> {$recommend_email}
                <br><b>Комментарий:</b> {$comment}
                ";
    }
}
