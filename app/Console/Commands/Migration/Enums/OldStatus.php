<?php


namespace App\Console\Commands\Migration\Enums;

use App\Enums\BaseEnum;

/**
 * @method static static Active()
 * @method static static NoneActive()
 * @method static static OnlyUrl()
 * @method static static Deleted()
 */
final class OldStatus extends BaseEnum
{
    const Active = 1;
    const NoneActive = 2;
    const OnlyUrl = 3;
    const Deleted = 4;
}
