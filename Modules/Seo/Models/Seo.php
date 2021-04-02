<?php

namespace Modules\Seo\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Seo\Database\factories\SeoFactory;

/**
 * Class Seo
 * @package Modules\Seo\Models
 * @property boolean $is_enabled
 * @property integer $type
 * @property string $h1
 * @property string $title
 * @property string $description
 * @property array $meta_tags
 */
class Seo extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $table = 'seo';

    protected $casts = [
        'is_enabled' => 'boolean',
        'type' => 'integer',
        'meta_tags' => 'array',
    ];

    protected static function newFactory()
    {
        return SeoFactory::new();
    }
}
