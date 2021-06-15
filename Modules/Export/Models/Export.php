<?php

namespace Modules\Export\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Export\Database\factories\ExportFactory;

class Export extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function newFactory()
    {
        return ExportFactory::new();
    }
}
