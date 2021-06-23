<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->integer('id', true, true);
            $table->integer('user_id')->unsigned();
            $table->dateTime('log_date');
            $table->string('action', 255);
            $table->tinyInteger('element')->unsigned();
            $table->integer('element_id')->unsigned();
            $table->string('source', 255);
            $table->index('user_id', 'user_id_idx');
            $table->index('log_date');
            $table->foreign('user_id')->references('id')->on('users');
        });

        DB::statement("ALTER TABLE `logs` comment 'Table to store all actions'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logs');
    }
}
