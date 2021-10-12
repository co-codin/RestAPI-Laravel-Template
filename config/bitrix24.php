<?php

return [
    'domain' => env('BITRIX24_DOMAIN'),
    'token' => env('BITRIX24_TOKEN'),
    'user_id' => env('BITRIX24_USER_ID'),

    /*
    |--------------------------------------------------------------------------
    | ID тестовой сделки
    |--------------------------------------------------------------------------
    |
    | Если заявка определяется как тестовая, то все данные добавляются в эту тестовую сделку
    |
    */
    'test_deal_id' => env('BITRIX24_TEST_DEAL_ID'),

    /*
    |--------------------------------------------------------------------------
    | ID ответственного по новой заявке
    |--------------------------------------------------------------------------
    |
    | При получении новой заявки, ей назначается в поле ASSIGNED_BY_ID это значение.
    | Это необходимо для того, чтобы потом отдельно распределять новые и повторные сделки
    |
    */
    'new_deal_assigned_id' => env('BITRIX24_NEW_DEAL_ASSIGNED_ID'),

    /*
    |--------------------------------------------------------------------------
    | ID ответственного по повторной заявке
    |--------------------------------------------------------------------------
    |
    | При получении повторной заявки, ей назначается в поле ASSIGNED_BY_ID это значение.
    | Это необходимо для того, чтобы потом отдельно распределять новые и повторные сделки
    |
    */
    'repeat_deal_assigned_id' => env('BITRIX24_REPEAT_DEAL_ASSIGNED_ID'),

    /*
    |--------------------------------------------------------------------------
    | ID ответственного по заявке без номера телефона
    |--------------------------------------------------------------------------
    |
    | При получении заявки без номера телефона, ей назначается в поле ASSIGNED_BY_ID это значение.
    | Это необходимо для того, чтобы эти сделки не попадали в распределении
    |
    */
    'no_phone_deal_assigned_id' => env('BITRIX24_NO_PHONE_DEAL_ASSIGNED_ID'),

    /*
    |--------------------------------------------------------------------------
    | ID отдела продаж
    |--------------------------------------------------------------------------
    */
    'sales_department_id' => env('BITRIX24_SALES_DEPARTMENT_ID'),

    /*
    |--------------------------------------------------------------------------
    | ID поля "Категория" в Лидах
    |--------------------------------------------------------------------------
    |
    | В Битрикс 24 можно создавать пользовательские поля для разных CRM сущностей (Лиды, Сделки и т.д.).
    | Этим полям присваивается уникальный идентификатор, начинающийся с UF_.
    | Для того, чтобы можно было на тестовой площадке использовать другой идентификатор, вынесли это в конфиг
    |
    */
    'lead_category_field_id' => env('BITRIX24_LEAD_CATEGORY_FIELD_ID'),

    /*
    |--------------------------------------------------------------------------
    | ID поля "roistat" в Лидах
    |--------------------------------------------------------------------------
    */
    'lead_roistat_field_id' => env('BITRIX24_LEAD_ROISTAT_FIELD_ID'),
];