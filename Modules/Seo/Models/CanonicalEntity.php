<?php

namespace Modules\Seo\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * This is the model class for table "canonicals".
 *
 * Modules\Seo\Models\CanonicalEntity
 *
 * @property int $id
 * @property string $url
 * @property string $canonical
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @mixin \Eloquent
 * @method static Builder|CanonicalEntity newModelQuery()
 * @method static Builder|CanonicalEntity newQuery()
 * @method static Builder|CanonicalEntity query()
 */
class CanonicalEntity extends Model
{
    protected $table = 'canonicals';

    protected $fillable = [
        'url',
        'canonical',
    ];
}
