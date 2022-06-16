<?php

namespace Modules\Client\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Modules\Client\Database\factories\ClientFactory;
use Modules\Client\Traits\Bannable;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Client extends Authenticatable
{
    use HasFactory, SoftDeletes, LogsActivity, Bannable;

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

    protected static function newFactory()
    {
        return ClientFactory::new();
    }
}
