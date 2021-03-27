<?php


namespace App\Traits;


use App\Enums\Status;
use Illuminate\Database\Eloquent\Builder;

trait IsActive
{
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', '=', Status::ACTIVE);
    }
}
