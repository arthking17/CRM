<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateEmailAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_accounts', function (Blueprint $table) {
            $table->integer('id', true, true);
            $table->tinyInteger('status')->unsigned();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->integer('account_id')->unsigned();
            $table->index('account_id', 'mail_account_id_idx');
            $table->foreign('account_id', 'mail_account_id')->references('id')->on('accounts');
        });

        DB::statement("ALTER TABLE `email_accounts` comment 'Emails senders'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('email_accounts');
    }
}
