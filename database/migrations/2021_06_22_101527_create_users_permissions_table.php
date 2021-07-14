<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateUsersPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_permissions', function (Blueprint $table) {
            $table->integer('user_id', false, true);
            $table->string('code', 128);
            $table->tinyInteger('dependency')->unsigned()->comment("1 : action need admin validation\n0 : Default ");
            $table->tinyInteger('status')->unsigned()->default(1);
            $table->primary(['user_id', 'code']);
            $table->foreign('user_id')->references('id')->on('users');
        });

        DB::statement("ALTER TABLE `users_permissions` comment 'Users permissions'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_permissions');
    }
}
