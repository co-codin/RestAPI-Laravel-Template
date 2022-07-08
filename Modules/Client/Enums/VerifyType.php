<?php


namespace Modules\Client\Enums;

use App\Enums\BaseEnum;

/**
 * @method static static SMS()
 * @method static static VOICE()
 * @method static static CALL()
 * @method static static EMAIL()
 */
final class VerifyType extends BaseEnum
{
    const SMS = 1;
    const VOICE = 2;
    const CALL = 3;
    const EMAIL = 4;
}
