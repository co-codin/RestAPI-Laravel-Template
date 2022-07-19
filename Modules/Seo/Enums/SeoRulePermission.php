<?php

namespace Modules\Seo\Enums;

use App\Enums\BaseEnum;

class SeoRulePermission extends BaseEnum
{
    const CREATE_SEO_RULES = 'create seo rules';
    const VIEW_SEO_RULES = 'view seo rules';
    const EDIT_SEO_RULES = 'edit seo rules';
    const DELETE_SEO_RULES = 'delete seo rules';

    public static function descriptions() : array
    {
        return [
            static::CREATE_SEO_RULES => 'Создание seo правила',
            static::VIEW_SEO_RULES => 'Просмотр seo правила',
            static::EDIT_SEO_RULES => 'Редактирование seo правила',
            static::DELETE_SEO_RULES => 'Удаление seo правила',
        ];
    }
}
