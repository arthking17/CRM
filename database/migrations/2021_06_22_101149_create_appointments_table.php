<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->integer('id', true, true);
            $table->integer('contact_id')->unsigned();
            $table->tinyInteger('class')->unsigned()->comment("Appointment type");
            $table->string('subject', 255)->comment("Appointment title");
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->integer('user_id')->unsigned()->comment("User assigned")->nullable();
            $table->tinyInteger('status')->unsigned();
            $table->index('contact_id', 'app_contact_id_idx');
            $table->index('user_id', 'app_user_id_idx');
            $table->foreign('contact_id', 'app_contact_id')->references('id')->on('contacts');
            $table->foreign('user_id', 'app_user_id')->references('id')->on('users');
        });

        DB::statement("ALTER TABLE `appointments` comment 'Table to store appointments with contacts'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointments');
    }
}
