<?php


namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum as BenSampoEnum;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

/**
 * Class Enum
 * @package App\Enums
 */
abstract class BaseEnum extends BenSampoEnum implements LocalizedEnum
{
    /**
     * @var string|null
     */
    protected static $moduleName = null;

    /**
     * @throws \ReflectionException
     */
    protected static function setModuleName()
    {
        static::$moduleName = null;

        $namespaceName = static::class;
        $findme = "Modules";
        $pos = strpos($namespaceName, $findme);

        if ($pos !== false) {
            preg_match("~[\\\\]+\\w+[\\\\]~", $namespaceName, $matches);
            static::$moduleName = strtolower(stripslashes($matches[0]));
        }
    }

    /**
     * Get the default localization key.
     *
     * @return string
     * @throws \ReflectionException
     */
    public static function getLocalizationKey(): string
    {
        static::setModuleName();

        return !is_null(static::$moduleName)
            ? static::$moduleName . '::' . parent::getLocalizationKey()
            : parent::getLocalizationKey();
    }

    public static function getFilterItemDescription(string $key): ?string
    {
        $key = Str::ucfirst($key);
        $constant = Arr::get(self::getConstants(), $key);

        return self::getDescription($constant);
    }

    public static function getFilterItemValue(string $value): ?string
    {
        return $value;
    }

    public static function toJson($value): array
    {
        return [
            'value' => $value,
            'description' => static::getDescription($value),
        ];
    }
}
