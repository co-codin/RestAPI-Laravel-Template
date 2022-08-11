<?php

namespace Modules\Seo\Enums;

use Modules\Role\Contracts\PermissionEnum;

class SeoRulePermission implements PermissionEnum
{
    const CREATE_SEO_RULES = 'create seo rules';
    const VIEW_SEO_RULES = 'view seo rules';
    const EDIT_SEO_RULES = 'edit seo rules';
    const DELETE_SEO_RULES = 'delete seo rules';

    public static function module(): string
    {
        return 'SEO правила';
    }

    public static function descriptions() : array
    {
        return [
            static::CREATE_SEO_RULES => 'Добавление SEO правил',
            static::VIEW_SEO_RULES => 'Просмотр SEO правил',
            static::EDIT_SEO_RULES => 'Редактирование SEO правил',
            static::DELETE_SEO_RULES => 'Удаление SEO правил',
        ];
    }
}
