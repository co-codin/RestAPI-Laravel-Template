<?php

namespace Modules\Redirect\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Redirect\Database\factories\RedirectFactory;

class Redirect extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected static function newFactory()
    {
        return RedirectFactory::new();
    }
}
