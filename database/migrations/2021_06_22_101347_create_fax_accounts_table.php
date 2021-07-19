<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateFaxAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fax_accounts', function (Blueprint $table) {
            $table->integer('id', true, true);
            $table->tinyInteger('status')->unsigned()->default(1);
            $table->date('start_date')->default(date("Y-m-d"));
            $table->date('end_date')->nullable();
            $table->integer('account_id')->unsigned();
            $table->index('account_id', 'account_id_idx');
            $table->foreign('account_id', 'fax_account_id')->references('id')->on('accounts');
        });

        DB::statement("ALTER TABLE `fax_accounts` comment 'FAX senders'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fax_accounts');
    }
}
