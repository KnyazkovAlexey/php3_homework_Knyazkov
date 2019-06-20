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
 * @property string surname
 * @property string patronymic
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
        'name', 'surname', 'patronymic', 'email', 'password',
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
     * Отображаемое имя пользователя
     *
     * @return string|null
     */
    public function getFullName()
    {
        if (! empty($this->name) && ! empty($this->patronymic) && ! empty($this->surname)) {
            return implode(' ', [$this->name, $this->patronymic, $this->surname]);
        } elseif (! empty($this->name) && ! empty($this->surname)) {
            return implode(' ', [$this->name, $this->surname]);
        } else {
            return $this->email;
        }
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
