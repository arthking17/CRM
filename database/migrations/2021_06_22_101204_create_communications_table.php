<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCommunicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('communications', function (Blueprint $table) {
            $table->integer('id', true, true);
            $table->integer('contact_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->tinyInteger('class')->unsigned()->comment("Type of communication : Call , email, sms ...");
            $table->integer('channel')->unsigned()->comment("Identifier of chanel : Sip account, email sender ...");
            $table->dateTime('start_date');
            $table->tinyInteger('status')->unsigned()->default(1);
            $table->tinyInteger('qualification')->unsigned()->nullable();
            $table->index('contact_id', 'comm_contact_id_idx');
            $table->index('user_id', 'comm_user_id_idx');
            $table->foreign('contact_id', 'comm_contact_id')->references('id')->on('contacts');
            $table->foreign('user_id', 'comm_user_id')->references('id')->on('users');
        });

        DB::statement("ALTER TABLE `communications` comment 'Table to store all types of communication with contacts such call, email, sms message ...'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('communications');
    }
}
