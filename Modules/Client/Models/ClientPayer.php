<?php

namespace Modules\Client\Models;

use Illuminate\Database\Eloquent\Model;

class ClientPayer extends Model
{
    protected $guarded = ['id'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
