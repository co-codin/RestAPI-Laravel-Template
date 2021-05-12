<?php

namespace Modules\Filter\Helpers;

class FilterSeoHelper
{
    /**
     * @param string $template
     * @return string
     */
    public static function clearTemplate(string $template): string
    {
        // удаляем все незамененные переменные фильтров
        $template = preg_replace('/{[a-z-_0-9]+}/', '', $template);

        // удаляем все двойные точки с запятой
        $template = preg_replace('/(;\s){2,}/', '; ', $template);

        $template = str_replace('- ;', '- ', $template);

        // удаляем все множественные проблеы
        $template = preg_replace('!\s+!', ' ', $template);

        // удаляем двойные тире
        $template = preg_replace('/(- ){2,}/', '- ', $template);

        $template = trim($template, '\t\n\r\0\x0B; -');

        return $template;
    }

    /**
     * @param string $url
     * @return string
     */
    public static function modifyCanonical(string $url): string
    {
        return preg_replace_callback(
            "~(?<=filters).*~",
            static fn ($filtersMatch) => preg_replace(["~\/[^\/]*(?=-from-).+?(?=\/|$)~", "~(?=-or-).+?(?=\/|$)~"], ['', ''], $filtersMatch[0]),
            $url
        );
    }
}
