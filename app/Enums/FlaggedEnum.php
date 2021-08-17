<?php


namespace App\Enums;


use BenSampo\Enum\FlaggedEnum as BenSampoFlaggedEnum;

abstract class FlaggedEnum extends BenSampoFlaggedEnum
{
    /** @var string */
    protected static $moduleName = null;

    /**
     * @throws \ReflectionException
     */
    protected static function setModuleName()
    {
        static::$moduleName = null;
        $r = new \ReflectionClass(static::class);

        $namespaceName = $r->getNamespaceName();
        $findme = "Modules";
        $pos = strpos($namespaceName, $findme);

        if ($pos !== false) {
            preg_match("~[\\\\]+\\w+[\\\\]~", $namespaceName,$matches);
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
}
