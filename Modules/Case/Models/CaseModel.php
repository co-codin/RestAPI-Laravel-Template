<?php

namespace Modules\Case\Models;

use App\Concerns\IsActive;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Case\Database\factories\CaseModelFactory;
use Modules\Geo\Models\City;
use Modules\Product\Models\Product;

class CaseModel extends Model
{
    use HasFactory, IsActive;

    protected $guarded = ['id'];

    protected $casts = [
        'status' => 'integer',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'case_model_product');
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    protected static function newFactory()
    {
        return CaseModelFactory::new();
    }
}
