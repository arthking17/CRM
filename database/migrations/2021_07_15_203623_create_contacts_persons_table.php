<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateContactsPersonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts_persons', function (Blueprint $table) {
            $table->integer('id', true, true);
            $table->tinyInteger('profile')->unsigned()->comment("Role of this person");
            $table->tinyInteger('gender')->unsigned();
            $table->string('first_name', 255);
            $table->string('last_name', 255);
            $table->string('nickname', 255)->nullable();
            $table->date('birthdate')->nullable();
            $table->char('country', 2)->nullable();
            $table->char('language', 2)->nullable();
        });

        DB::statement("ALTER TABLE `contacts_persons` comment 'People type contact table'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contacts_persons');
    }
}
