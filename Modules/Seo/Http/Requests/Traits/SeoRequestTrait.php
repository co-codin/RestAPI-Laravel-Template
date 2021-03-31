<?php


namespace Modules\Seo\Http\Requests\Traits;

use Modules\Seo\Dto\SeoDto;
use Modules\Seo\Enums\SeoType;

/**
 * Trait SeoRequestTrait
 * @package Modules\Seo\Http\Requests
 */
trait SeoRequestTrait
{
    public static function getSeoRules(SeoDto $dto, string $seoArrName = 'seo'): array
    {
        $rules = [
            $seoArrName => 'required|array',
            $seoArrName . '.is_enabled' => 'required|boolean'
        ];

        if ($dto->is_enabled) {
            $rules = array_merge($rules, [
                $seoArrName . '.title' => 'required_without_all:' . self::exceptField($seoArrName . '.title') . '|nullable|string|max:500',
                $seoArrName . '.h1' => 'required_without_all:' . self::exceptField($seoArrName . '.h1') . '|nullable|string|max:500',
                $seoArrName . '.description' => 'required_without_all:' . self::exceptField($seoArrName . '.description') . '|nullable|string|max:500',
                $seoArrName . '.type' => 'sometimes|enum_value:' . SeoType::class,
                $seoArrName . '.meta_tags' => 'required_without_all:' . self::exceptField($seoArrName . '.meta_tags') . '|nullable|array|max:255',
                $seoArrName . '.meta_tags.*' => 'required|array',
                $seoArrName . '.meta_tags.*.name' => 'required|string|max:255',
                $seoArrName . '.meta_tags.*.content' => 'required|string|max:255',
                $seoArrName . '.texts' => 'nullable|array',
                $seoArrName . '.texts.*' => 'required|array',
                $seoArrName . '.texts.*.name' => 'required|string',
                $seoArrName . '.texts.*.key' => 'nullable|string',
                $seoArrName . '.texts.*.text' => 'required|string',
            ]);
        }

        return $rules;
    }

    private static function exceptField(string $field): string
    {
        $fieldsArray = collect(self::getSeoAttributes());

        return $fieldsArray->except($field)
            ->flip()
            ->join(',');
    }

    public static function getSeoAttributes(string $seoArrName = 'seo'): array
    {
        return [
            $seoArrName . '.title' => 'Мета-тег title',
            $seoArrName . '.h1' => 'h1',
            $seoArrName . '.description' => 'Мета-тег description',
            $seoArrName . '.type' => 'Тип Seo',
            $seoArrName . '.meta_tags' => 'Мета тэги',
            $seoArrName . '.meta_tags.*.title' => 'Название',
            $seoArrName . '.meta_tags.*.content' => 'Контент',
            $seoArrName . '.texts' => 'Тексты',
            $seoArrName . '.texts.*.name' => 'Название',
            $seoArrName . '.texts.*.key' => 'Ключ',
            $seoArrName . '.texts.*.text' => 'Текст',
        ];
    }

    public static function getSeoMessages(string $seoArrName = 'seo'): array
    {
        return [
            'required_without_all' => 'Заполните хотя бы одно поле',
            $seoArrName . '.*.required' => 'Поле :attribute обязательно для заполнения.',
            $seoArrName . '.*.required_if' => 'Поле :attribute обязательно для заполнения, т.к. включено SEO.',
            $seoArrName . '.*.string' => 'Поле :attribute должно быть строкой.',
            $seoArrName . '.*.integer' => 'Поле :attribute должно быть целым числом.',
            $seoArrName . '.*.max:255' => 'Поле :attribute не может быть длиннее 255 символов.',
            $seoArrName . '.*.min:1' => 'Поле :attribute не может быть меньше 1.',
            $seoArrName . '.*.min:2' => 'Поле :attribute не может быть больше 2.',
        ];
    }
}
