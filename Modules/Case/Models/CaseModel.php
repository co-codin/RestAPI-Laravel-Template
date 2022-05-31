<?php

namespace Modules\Case\Models;

use App\Concerns\IsActive;
use Google\Service\AdExchangeBuyer\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Case\Database\factories\CaseFactory;
use Modules\Geo\Models\City;

class CaseModel extends Model
{
    use HasFactory, IsActive;

    protected $table = 'cases';

    protected $guarded = ['id'];

    protected $casts = [
        'published_at' => 'date:Y-m-d',
        'status' => 'integer',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'case_product');
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    protected static function newFactory()
    {
        return CaseFactory::new();
    }
}
