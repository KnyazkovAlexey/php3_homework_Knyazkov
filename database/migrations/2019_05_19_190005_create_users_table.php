<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\User;

/**
 * Миграция выполняет следующие действия:
 *  - создаёт таблицу "Пользователи";
 *  - создает первого пользователя.
 *
 * Class CreateUsersTable
 */
class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     * @throws Throwable
     */
    public function up()
    {
        DB::transaction(function () {
            $this->createTable();
            $this->createFirstUser();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }

    /**
     * Создаём таблицу "Пользователи"
     */
    protected function createTable()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
        });
    }
    /**
     * Создаём первого пользователя
     */
    protected function createFirstUser()
    {
        User::create([
            'name'     => config('app_custom.admin.name'),
            'email'    => config('app_custom.admin.email'),
            'password' => bcrypt(config('app_custom.admin.password')),
        ]);
    }
}
