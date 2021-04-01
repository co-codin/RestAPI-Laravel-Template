<?php


namespace Modules\Faq\Models\Traits;


use Illuminate\Database\Eloquent\Builder;

trait IsActive
{
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', '=', true);
    }
}
