<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\User;
use App\Models\Role;

/**
 * Миграция выполняет следующие действия:
 *  - создаёт таблицу "Роли";
 *  - заполняет ее ролями "Пользователь", "Админ";
 *  - создаёт связующую таблицу для ролей и пользователей;
 *  - связывает первого пользователя с ролью "Админ".
 *
 * Class CreateRolesTable
 */
class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::transaction(function () {
            $this->createTableRoles();
            $this->fillTableRoles();
            $this->createTableRoleUser();
            $this->assignAdminRoleToFirstUser();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::transaction(function () {
            Schema::dropIfExists('role_user');
            Schema::dropIfExists('roles');
        });
    }

    /**
     * Создаём таблицу "Роли"
     */
    protected function createTableRoles()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
        });
    }

    /**
     * Создаём роли "Пользователь" и "Админ"
     */
    protected function fillTableRoles()
    {
        foreach ([Role::ROLE_USER, Role::ROLE_ADMIN] as $roleName) {
            Role::create(['name' => $roleName]);
        }
    }

    /**
     * Создаём связующую таблицу для ролей и пользователей
     */
    protected function createTableRoleUser()
    {
        Schema::create('role_user', function (Blueprint $table) {
            $table->integer('role_id')->unsigned();
            $table->foreign('role_id')->references('id')->on('roles')
                ->onDelete('cascade');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade');

            $table->primary(['role_id', 'user_id']);
        });
    }

    /**
     * Связываем первого пользователя с ролью "Админ"
     */
    protected function assignAdminRoleToFirstUser()
    {
        $user = User::findByEmail(config('app_custom.admin.email'));

        if (null === $user) {
            return;
        }

        $role = Role::findByName(Role::ROLE_ADMIN);

        $user->roles()->attach($role);
    }
}
