<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->integer('id', true, true);
            $table->string('username', 128);
            $table->string('login', 128);
            $table->string('pwd', 255);
            $table->tinyInteger('role')->unsigned();
            $table->char('language', 2);
            $table->string('photo')->nullable();
            $table->string('timezone', 128)->nullable();
            $table->string('browser', 255)->nullable();
            $table->string('ip_address', 64)->nullable();
            $table->dateTime('last_auth')->nullable();
            $table->integer('account_id')->unsigned();
            $table->tinyInteger('status')->unsigned();
            $table->index('account_id', 'users_account_id_idx');
            $table->foreign('account_id', 'users_account_id')->references('id')->on('accounts');
            $table->rememberToken();
        });

        DB::statement("ALTER TABLE `users` comment 'Application users table'");
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
}
