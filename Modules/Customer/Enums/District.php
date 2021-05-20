<?php


namespace Modules\Customer\Enums;


use App\Enums\BaseEnum;

/**
 * @method static static Central()
 * @method static static NorthWest()
 * @method static static South()
 * @method static static NorthCaucasian()
 * @method static static Volga()
 * @method static static Ural()
 * @method static static Siberian()
 * @method static static FarEastern()
 */
final class District extends BaseEnum
{
    const Central = 1;
    const NorthWest = 2;
    const South = 3;
    const NorthCaucasian = 4;
    const Volga = 5;
    const Ural = 6;
    const Siberian = 7;
    const FarEastern = 8;
}
