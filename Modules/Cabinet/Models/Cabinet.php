<?php

namespace Modules\Cabinet\Models;

use App\Models\Document;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Cabinet\Database\factories\CabinetFactory;
use Modules\Category\Models\Category;
use Modules\Seo\Models\Seo;

class Cabinet extends Model
{
    use HasFactory, Sluggable, SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'requirements' => 'array',
        'documents' => 'array',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
            ]
        ];
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'cabinet_category')
            ->withPivot([
                'name',
                'count',
                'price',
                'position',
            ]);
    }

    public function seo()
    {
        return $this->morphOne(Seo::class, 'seoable');
    }

    protected static function newFactory()
    {
        return CabinetFactory::new();
    }
}
