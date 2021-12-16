<?php

namespace App\Helpers;

use App\Enums\RateStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Collection as SupportCollection;

class RateHelper
{
    public static function rate(Request $request, SupportCollection $cookieData, int $entityId): void
    {
        $prevStatus = (int)($cookieData->get($entityId) ?? RateStatus::NONE);

        $status = RateStatus::fromValue($request->input('status'));

        if ($prevStatus === $status->value) {
            abort(403);
        }

        $request->offsetSet('prev_status', $prevStatus);
    }
}
