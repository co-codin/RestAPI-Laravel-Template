<?php


namespace Modules\Customer\Enums;


use App\Enums\BaseEnum;
use BenSampo\Enum\Contracts\LocalizedEnum;

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
final class District extends BaseEnum implements LocalizedEnum
{
    const Central = 1;
    const NorthWest = 2;
    const South = 3;
    const NorthCaucasian = 4;
    const Volga = 5;
    const Ural = 6;
    const Siberian = 7;
    const FarEastern = 8;

    public static function shortNames()
    {
        return [
            District::Central => 'Центральный',
            District::NorthWest => 'Северо-Западный',
            District::South => 'Южный',
            District::NorthCaucasian => 'Северо-Кавказский',
            District::Volga => 'Приволжский',
            District::Ural => 'Уральский',
            District::Siberian => 'Сибирский',
            District::FarEastern => 'Дальневосточный',
        ];
    }
}
