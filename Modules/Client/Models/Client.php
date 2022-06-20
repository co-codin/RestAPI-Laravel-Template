<?php

namespace Modules\Client\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Modules\Client\Traits\Bannable;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Client extends Authenticatable
{
    use SoftDeletes, LogsActivity, Bannable;

    protected $guarded = [
        'id',
        'phone_verified_at',
        'email_verified_at',
    ];

    protected $casts = [
        'banned_at' => 'datetime',
        'phone_verified_at' => 'datetime',
        'email_verified_at' => 'datetime',
        'settings' => 'array',
        'social_networks' => 'array',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'first_name',
                'last_name',
                'subject',
                'phone',
                'email',
            ])
            ->logOnlyDirty();
    }

    public function clientPayers()
    {
        return $this->hasMany(ClientPayer::class);
    }
}
