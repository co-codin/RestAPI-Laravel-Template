<?php


namespace Modules\Customer\Enums;


use App\Enums\BaseFlaggedEnum;
use BenSampo\Enum\Contracts\LocalizedEnum;

/**
 * @method static static State()
 * @method static static PrivatePerson()
 * @method static static PrivateCenter()
 * @method static static Dealer()
 * @method static static DealerAndState()
 * @method static static DealerAndCenter()
 */
final class CustomerGeographyType extends BaseFlaggedEnum implements LocalizedEnum
{
    const State = 1 << 1;
    const PrivatePerson = 1 << 2;
    const PrivateCenter = 1 << 3;
    const Dealer = 1 << 4;

    const DealerAndState = self::Dealer | self::State;
    const DealerAndCenter = self::Dealer | self::PrivateCenter;
}
