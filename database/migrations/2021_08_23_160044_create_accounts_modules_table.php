<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateAccountsModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts_modules', function (Blueprint $table) {
            $table->id();
            $table->integer('account_id')->unsigned();
            $table->tinyInteger('module')->unsigned()->comment("Application module : 1:GENERAL, 2:NURTURING");
            $table->tinyInteger('status')->unsigned()->comment("1: active\n0:disabled")->default(1);
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->index('account_id', 'acc_modules_account_id_idx');
            $table->foreign('account_id', 'acc_modules_account_id')->references('id')->on('accounts');
        });

        DB::statement("ALTER TABLE `sip_accounts` comment 'Accounts Modules'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts_modules');
    }
}
