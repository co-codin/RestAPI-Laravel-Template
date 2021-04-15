<?php

namespace Modules\Property\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Property\Database\factories\PropertyFactory;

class Property extends Model
{
    use HasFactory;

    protected $fillable = ['id'];

    protected static function newFactory()
    {
        return PropertyFactory::new();
    }
}
