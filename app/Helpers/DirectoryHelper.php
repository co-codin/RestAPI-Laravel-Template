<?php


namespace App\Helpers;


use App\Validators\EnumValidator;
use Illuminate\Support\Collection;
use Modules\Form\Forms\Form;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RecursiveRegexIterator;
use RegexIterator;

/**
 * Class DirectoryHelper
 * @package App\Helpers
 */
class DirectoryHelper
{
    public const FORMS_PATH = 'Modules/Form/Forms';
    public const FORMS_PATH_WITH_BACKSLASH = 'Modules\Form\Forms';

    /**
     * @param array $singleDirectories
     * @param array $multipleDirectories
     * @return array
     */
    public static function getDirectories(array $singleDirectories = [], array $multipleDirectories = []): array
    {
        $validator = new EnumValidator();
        $validator->validatePaths($singleDirectories, false);

        $correctMultiplePaths = [];

        if (!empty($multipleDirectories)) {
            $validator->validatePaths($multipleDirectories);

            foreach ($multipleDirectories as $directory) {
                $paths = glob(base_path($directory));
                preg_match('~[^//]+~', $directory, $wordBeforeSlash, PREG_OFFSET_CAPTURE, 0);

                foreach ($paths as $path) {
                    $strPos = stripos($path, $wordBeforeSlash[0][0]);
                    $correctMultiplePaths[] = $strPos ? substr($path, $strPos) : $path;
                }
            }
        }

        return array_merge(
            $singleDirectories,
            $correctMultiplePaths
        );
    }

    /**
     * @param array $enumDirectories
     * @return array
     */
    public static function getClassPaths(array $enumDirectories): array
    {
        $enumClassPaths = [];

        foreach ($enumDirectories as $directory) {
            $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(base_path($directory)));
            $regex = new RegexIterator($iterator, '/^.+\.php$/i', RecursiveRegexIterator::GET_MATCH);

            foreach ($regex as $file => $value) {
                $classPath = str_replace('/', '\\', $file);
                $classPath = str_replace('.php', '', $classPath);

                $strPos = stripos($classPath, 'modules') ?: stripos($classPath, 'app');
                $enumClassPaths[] =  $strPos ? substr($classPath, $strPos) : $classPath;
            }
        }

        return $enumClassPaths;
    }

    /**
     * @return Collection
     */
    public static function getFormClasses(): Collection
    {
        $classPaths = self::getClassPaths([self::FORMS_PATH]);

        return collect($classPaths)->filter(function (string $class) {
            return $class !== Form::class && is_a($class, Form::class, true);
        });
    }
}
