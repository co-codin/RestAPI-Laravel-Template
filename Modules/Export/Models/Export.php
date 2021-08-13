<?php

namespace Modules\Export\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Export\Database\factories\ExportFactory;


/**
 * Class Export
 * @package Modules\Export\Models
 * @property int $id
 * @property string $name
 * @property int $type
 * @property string filename
 * @property int $frequency
 * @property array $parameters
 */
class Export extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    protected $casts = [
        'parameters' => 'array',
    ];

    protected static function newFactory()
    {
        return ExportFactory::new();
    }
}
