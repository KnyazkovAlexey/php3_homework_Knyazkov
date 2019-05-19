<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Сущность "Пользователь"
 *
 * Class User
 * @package App
 *
 * @property int id
 * @property string name
 * @property string email
 * @property string password
 *
 * @property-read Role[] $roles
 */
class User extends Authenticatable
{
    use Notifiable;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    /**
     * @param string $email
     * @return User|null
     */
    public static function findByEmail($email)
    {
        return self::where('email', $email)->first();
    }
}
