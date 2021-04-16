<?php

namespace Modules\Property\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Property\Database\factories\PropertyValueFactory;

class PropertyValue extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $table = 'property_value';

    protected static function newFactory()
    {
        return PropertyValueFactory::new();
    }
}
