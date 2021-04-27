<?php


namespace Modules\Product\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Category\Models\Category;

class ProductCategory extends Model
{
    public $timestamps = false;

    protected $table = 'product_category';

    protected $fillable = [
        'product_id',
        'category_id',
        'is_main'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
