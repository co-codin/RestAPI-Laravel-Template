<?php

namespace Modules\User\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;
use Modules\Role\Models\Role;
use Modules\User\Database\factories\UserFactory;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Casts\Attribute;

/**
 * Class User
 * @package Modules\User\Models
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property-read Role $role
 * @property-read Role[]|Collection $roles
 * @method static self create(array $attributes)
 */
class User extends Authenticatable
{
    use Notifiable, HasRoles, HasApiTokens, HasFactory;

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = [
        'role'
    ];

    protected function role(): Attribute
    {
        return new Attribute(
            get: fn($value) => $this->roles->first(),
        );
    }

    protected static function newFactory()
    {
        return UserFactory::new();
    }
}
