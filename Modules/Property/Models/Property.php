<?php

namespace Modules\Property\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Category\Models\Category;
use Modules\Property\Database\factories\PropertyFactory;

class Property extends Model
{
    use HasFactory;

    protected $fillable = ['id'];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'property_categories', 'property_id', 'category_id');
    }

    protected static function newFactory()
    {
        return PropertyFactory::new();
    }
}
