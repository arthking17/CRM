<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateContactDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_data', function (Blueprint $table) {
            $table->integer('id', true, true);
            $table->tinyInteger('element')->unsigned()->comment("Origin\nBy default : 1 for contacts");
            $table->integer('element_id')->unsigned()->comment("Identifier of th origin \nIdentifier of contact");
            $table->tinyInteger('class')->unsigned()->comment("Type de field : email, phone, facebook...");
            $table->string('data', 255)->comment("Value of field");
            $table->tinyInteger('status')->unsigned()->default(1);
        });

        DB::statement("ALTER TABLE `contact_data` comment 'Table to store all types of contact data such email, phone number, social media account...'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contact_data');
    }
}
