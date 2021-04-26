<?php

namespace Modules\Page\Models;

use App\Traits\IsActive;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kalnoy\Nestedset\NodeTrait;
use Modules\Page\Database\factories\PageFactory;
use Modules\Seo\Models\Seo;

/**
 * Class Page
 * @package Modules\Page\Models
 * @property int $id
 * @property string $slug
 * @property int $status
 * @property Seo|null $seo
 */
class Page extends Model
{
    use HasFactory, NodeTrait, SoftDeletes, IsActive;

    protected $guarded = ['id'];

    protected $casts = [
        'status' => 'integer',
    ];

    public function seo()
    {
        return $this->morphOne(Seo::class, 'seoable');
    }

    protected static function newFactory()
    {
        return PageFactory::new();
    }
}
