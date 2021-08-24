<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateUsersSipAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_sip__accounts', function (Blueprint $table) {
            $table->id();
            $table->integer('sipaccount_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->tinyInteger('status')->unsigned()->comment("1: active\n0:disabled")->default(1);
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->index('sipaccount_id', 'users_sip_sipaccount_id_idx');
            $table->foreign('sipaccount_id', 'users_sip_sipaccount_id')->references('id')->on('sip_accounts');
            $table->index('user_id', 'users_sip_user_id_idx');
            $table->foreign('user_id', 'users_sip_user_id')->references('id')->on('users');

            $table->removeColumn('timestamps');
        });

        DB::statement("ALTER TABLE `sip_accounts` comment 'Users SIP Accounts'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_sip__accounts');
    }
}
