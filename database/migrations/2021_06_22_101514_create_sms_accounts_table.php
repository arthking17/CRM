<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateSmsAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_accounts', function (Blueprint $table) {
            $table->integer('id', true, true);
            $table->tinyInteger('status')->unsigned();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->integer('account_id')->unsigned();
            $table->index('account_id', 'sms_account_id_idx');
            $table->foreign('account_id', 'sms_account_id')->references('id')->on('accounts');
        });

        DB::statement("ALTER TABLE `sms_accounts` comment 'SMS senders for messaging'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sms_accounts');
    }
}
