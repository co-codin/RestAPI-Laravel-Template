<?php

namespace Modules\Currency\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Currency\Database\factories\CurrencyFactory;

class Currency extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function getRateAttribute($value)
    {
        return $value / 100;
    }

    public function setRateAttribute($value)
    {
        $this->attributes['rate'] = $value * 100;
    }

    protected static function newFactory()
    {
        return CurrencyFactory::new();
    }
}
