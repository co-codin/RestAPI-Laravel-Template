<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentGroup extends Model
{
    protected $guarded = ['id'];

    public function documents()
    {
        return $this->hasMany(Document::class);
    }
}
