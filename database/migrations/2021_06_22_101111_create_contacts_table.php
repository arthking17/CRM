<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->integer('id', true, true);
            $table->integer('account_id')->unsigned();
            $table->integer('import_id')->unsigned()->nullable();
            $table->tinyInteger('class')->unsigned()->comment("Contact Type : Person, Company");
            $table->tinyInteger('source')->unsigned()->comment("Origin of contact : Telephone prospecting, Landing pages, affiliation, Database purchased");
            $table->integer('source_id')->unsigned()->comment("Identifier of th origin");
            $table->dateTime('creation_date')->default(date("Y-m-d H:i:s"));
            $table->tinyInteger('status')->comment("Status : Lead, Customer, Not interested");
            $table->index('account_id', 'cont_account_id_idx');
            $table->foreign('account_id', 'cont_account_id')->references('id')->on('accounts');
            $table->index('import_id', 'cont_import_id_idx');
            $table->foreign('import_id', 'cont_import_id')->references('id')->on('imports');
        });

        DB::statement("ALTER TABLE `contacts` comment 'Table of contacts'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contacts');
    }
}
