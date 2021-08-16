<?php


namespace Modules\Product\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Category\Models\Category;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class ProductCategory extends Model
{
    use LogsActivity;

    public $timestamps = false;

    protected $table = 'product_category';

    protected $fillable = [
        'product_id',
        'category_id',
        'is_main'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll();
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
