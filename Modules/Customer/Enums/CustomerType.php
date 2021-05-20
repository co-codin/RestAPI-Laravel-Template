<?php


namespace Modules\Customer\Enums;


use App\Enums\BaseEnum;

/**
 * @method static static State()
 * @method static static PrivatePerson()
 * @method static static PrivateCenter()
 */
final class CustomerType extends BaseEnum
{
    const State = 1;
    const PrivatePerson = 2;
    const PrivateCenter = 3;
}
