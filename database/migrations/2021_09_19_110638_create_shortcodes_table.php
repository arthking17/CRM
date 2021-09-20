<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateShortcodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shortcodes', function (Blueprint $table) {
            $table->id();
            $table->integer('account_id')->unsigned();
            $table->string('name', 128);
            $table->string('country', 128);
            $table->tinyInteger('status')->unsigned()->comment("1: active\n0:disabled")->default(1);
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->foreign('account_id', 'shortcodes_account_id')->references('id')->on('accounts');

            $table->removeColumn('timestamps');
        });

        DB::statement("ALTER TABLE `shortcodes` comment 'ShortCodes for messaging'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shortcodes');
    }
}
