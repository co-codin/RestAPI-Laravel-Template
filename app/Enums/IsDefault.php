<?php


namespace App\Enums;

/**
 * @method static static InAll()
 * @method static static NoneInAll()
 */
final class IsDefault extends Enum
{
    const Default = 1;
    const NoDefault = 2;
}
