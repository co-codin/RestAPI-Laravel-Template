<?php

namespace Modules\Case\Models;

use App\Concerns\IsActive;
use App\Models\Image;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Case\Database\factories\CaseModelFactory;
use Modules\Geo\Models\City;
use Modules\Product\Models\Product;
use Modules\Seo\Models\Seo;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string|null $summary
 * @property string|null $note
 * @property string|null $image
 * @property int $status
 * @property string $released_year
 * @property string $released_quarter
 * @property string|null $body
 * @property string|null $full_description
 * @property string|null $short_description
 */
class CaseModel extends Model
{
    use HasFactory, IsActive;

    protected $guarded = ['id'];

    protected $casts = [
        'status' => 'integer',
        'images' => 'array'
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

    public function seo()
    {
        return $this->morphOne(Seo::class, 'seoable');
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable')
            ->orderBy('position');
    }
}
