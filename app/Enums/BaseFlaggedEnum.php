<?php


namespace App\Enums;


use BenSampo\Enum\FlaggedEnum as BenSampoFlaggedEnum;
use JetBrains\PhpStorm\ArrayShape;

abstract class BaseFlaggedEnum extends BenSampoFlaggedEnum
{
    protected static ?string $moduleName = null;

    protected static function setModuleName(): void
    {
        static::$moduleName = null;
        $r = new \ReflectionClass(static::class);

        $namespaceName = $r->getNamespaceName();
        $findMe = "Modules";
        $pos = strpos($namespaceName, $findMe);

        if ($pos !== false) {
            preg_match("~[\\\\]+\\w+[\\\\]~", $namespaceName,$matches);
            static::$moduleName = strtolower(stripslashes($matches[0]));
        }
    }

    /**
     * Get the default localization key.
     *
     * @return string
     */
    public static function getLocalizationKey(): string
    {
        static::setModuleName();

        return !is_null(static::$moduleName)
            ? static::$moduleName . '::' . parent::getLocalizationKey()
            : parent::getLocalizationKey();
    }

    #[ArrayShape([
        'value' => "",
        'description' => "string"
    ])]
    public static function toJson($value): array
    {
        return [
            'value' => $value,
            'description' => static::getDescription($value),
        ];
    }
}
