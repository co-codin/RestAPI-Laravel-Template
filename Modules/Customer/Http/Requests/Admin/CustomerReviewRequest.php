<?php


namespace Modules\Customer\Http\Requests\Admin;


use App\Http\RequestFilters\SanitizesInput;
use App\Http\Requests\BaseFormRequest;

abstract class CustomerReviewRequest extends BaseFormRequest
{
    use SanitizesInput;

    public function filters(): array
    {
        return [
            'type'  => 'nullable-cast:integer',
            'is_in_home'  => 'nullable-cast:boolean',
        ];
    }

    public function attributes(): array
    {
        return [
            'post' => 'Имя клиента',
            'author' => 'Автор',
            'type' => 'Тип клиента',
            'video' => 'Ссылка на youtube видео',
            'review_file' => 'Ссылка на файл с отзывом',
            'is_in_home' => 'На главной',
            'comment' => 'Комментарий к отзыву',
            'logo' => 'Логотип компании',
        ];
    }
}
