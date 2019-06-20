<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Миграция выполняет следующие пдействия в таблице "Пользователи":
 *  - добавляет поля "Фамилия" и "Отчество";
 *  - делает необязательным поле "Имя".
 *
 * Class AddColumnsSurnameAndPatronymicToUsers
 */
class AddColumnsSurnameAndPatronymicToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('name')->nullable()->change();
            $table->string('surname')->nullable();
            $table->string('patronymic')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('name')->change();
            $table->dropColumn('surname');
            $table->dropColumn('patronymic');
        });
    }
}
