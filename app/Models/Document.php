<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $guarded = ['id'];

    public function documentGroup()
    {
        return $this->belongsTo(DocumentGroup::class);
    }

    public function documentable()
    {
        return $this->morphTo();
    }
}
