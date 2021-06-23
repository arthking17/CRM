<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->integer('id', true, true);
            $table->string('name');
            $table->string('url', 128);
            $table->tinyInteger('status')->unsigned();
            $table->date('start_date');
            $table->date('end_date')->nullable();
        });

        DB::statement("ALTER TABLE `accounts` comment 'Table to store accounts (Application customers)'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
}
