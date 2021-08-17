<?php


namespace App\Validators;


class EnumValidator
{
    /**
     * @param array $directories
     * @param bool $multiple
     */
    public function validatePaths(array $directories, bool $multiple = true)
    {
        $match = false;

        foreach ($directories as $directory) {
            preg_match('~[*]~', $directory, $matches, PREG_OFFSET_CAPTURE, 0);
            $match = empty($matches) ? $match : true;
        }

        if (empty($match) == $multiple) {
            $message = $multiple ? '(multiple)' : '(single)';
            throw new \LogicException('Folder paths entered incorrectly ' . $message);
        }
    }
}
