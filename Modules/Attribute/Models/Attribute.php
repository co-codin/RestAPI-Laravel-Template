<?php

namespace Modules\Attribute\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Attribute\Database\factories\AttributeFactory;

class Attribute extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    protected static function newFactory()
    {
        return AttributeFactory::new();
    }
}
