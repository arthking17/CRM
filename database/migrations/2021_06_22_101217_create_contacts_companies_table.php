<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateContactsCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts_companies', function (Blueprint $table) {
            $table->integer('id', true, true);
            $table->tinyInteger('class')->unsigned();
            $table->string('name', 255);
            $table->string('registered_number', 128)->nullable();
            $table->string('logo', 255)->nullable();
            $table->integer('activity')->unsigned()->nullable()->comment("Identifier of activity");
            $table->char('country', 2)->nullable();
            $table->char('language', 2)->nullable();
        });

        DB::statement("ALTER TABLE `contacts_companies` comment 'Companies type contact table'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contacts_companies');
    }
}
