<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Сущность "Роль"
 *
 * Class Role
 * @package App
 *
 * @property int id
 * @property string name
 *
 * @property-read User[] $users
 */
class Role extends Model
{
    /**
     * Роль: Пользователь
     */
    const ROLE_USER  = 'user';
    /**
     * Роль: Админ
     */
    const ROLE_ADMIN = 'admin';

    public $timestamps = false;

    protected $fillable = [
        'name',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'role_user');
    }

    /**
     * @param string $name
     * @return Role|null
     */
    public static function findByName($name)
    {
        return self::where('name', $name)->first();
    }
}
