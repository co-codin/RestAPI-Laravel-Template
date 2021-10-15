<?php


namespace App\Concerns;


use App\Enums\Status;
use Illuminate\Database\Eloquent\Builder;

trait IsActive
{
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', '=', Status::ACTIVE);
    }

    public function scopeVisible(Builder $query): Builder
    {
        return $query->whereIn('status', [Status::ACTIVE, Status::ONLY_URL]);
    }
}
