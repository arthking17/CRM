<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notes', function (Blueprint $table) {
            $table->integer('id', true, true);
            $table->tinyInteger('class')->unsigned()->comment("Type of note : Description, note, task ...");
            $table->tinyInteger('visibility')->unsigned()->comment("1 : Visible for all\n0 : Visible only for admin");
            $table->text('content');
            $table->tinyInteger('element')->unsigned();
            $table->integer('element_id')->unsigned();
        });

        DB::statement("ALTER TABLE `notes` comment 'Table to store all kinf of notes'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notes');
    }
}
