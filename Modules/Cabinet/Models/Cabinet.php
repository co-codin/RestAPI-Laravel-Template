<?php

namespace Modules\Cabinet\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Cabinet\Database\factories\CabinetFactory;

class Cabinet extends Model
{
    use HasFactory, Sluggable;

    protected $guarded = ['id'];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
            ]
        ];
    }

    protected static function newFactory()
    {
        return CabinetFactory::new();
    }
}
