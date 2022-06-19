<?php

namespace Modules\Client\Http\Requests;

use App\Http\Requests\BaseFormRequest;

class ClientUpdateRequest extends BaseFormRequest
{
    public function rules(): array
    {
        return [
            'first_name' => 'sometimes|required|string|max:255',
            'last_name' => 'sometimes|required|string|max:255',
            'social_networks' => 'sometimes|array|nullable',
            'social_networks.vkontakte' => 'sometimes|string|nullable|max:255',
            'social_networks.twitter' => 'sometimes|string|nullable|max:255',
            'social_networks.facebook' => 'sometimes|string|nullable|max:255',
            'social_networks.instagram' => 'sometimes|string|nullable|max:255',
            'social_networks.odnoklassniki' => 'sometimes|string|nullable|max:255',
            'settings' => 'sometimes|required',
            'settings.block_visibility' => 'required_with:settings|array',
            'settings.block_visibility.first_name' => 'sometimes|required|boolean',
            'settings.block_visibility.last_name' => 'sometimes|required|boolean',
            'settings.block_visibility.email' => 'sometimes|required|boolean',
            'settings.block_visibility.phone' => 'sometimes|required|boolean',
            'settings.block_visibility.social_networks' => 'sometimes|required|boolean',
            'settings.mailing' => 'required_with:settings|array',
            'settings.mailing.hot' => 'sometimes|required|boolean',
            'settings.mailing.price-decreased' => 'sometimes|required|boolean',
        ];
    }

    public function attributes(): array
    {
        return [
            'social_networks' => 'Социальные сети',
            'social_networks.vkontakte' => 'Вконтакте',
            'social_networks.twitter' => 'Twitter',
            'social_networks.facebook' => 'Facebook',
            'social_networks.instagram' => 'Инстаграм',
            'social_networks.odnoklassniki' => 'Одноклассники',
            'settings' => 'Настройки',
            'settings.block_visibility' => 'Общедоступная информация',
            'settings.block_visibility.first_name' => 'Отображение имени',
            'settings.block_visibility.last_name' => 'Отображение фамилии',
            'settings.block_visibility.email' => 'Отображение email',
            'settings.block_visibility.phone' => 'Отображение телефона',
            'settings.block_visibility.social_networks' => 'Отображение социальных сетей',
            'settings.mailing' => 'Подписка на рассылки',
            'settings.mailing.hot' => 'Подписка на "Скидки и акции"',
            'settings.mailing.price-decreased' => 'Подписка "Снизилась цена на избранное"',
        ];
    }
}
