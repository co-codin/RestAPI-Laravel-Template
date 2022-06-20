<?php

namespace Modules\Client\Traits;

use Illuminate\Support\Carbon;

trait Bannable
{
    public function ban(): bool
    {
        return $this->update([
            'banned_at' => Carbon::now()->toDateTimeString()
        ]);
    }

    public function unban(): bool
    {
        return $this->update([
            'banned_at' => null
        ]);
    }
}
