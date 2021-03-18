<?php

namespace Modules\Brand\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Brand\Database\factories\BrandFactory;

class Brand extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected static function newFactory()
    {
        return BrandFactory::new();
    }
}
