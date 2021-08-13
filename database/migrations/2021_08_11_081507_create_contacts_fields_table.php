<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateContactsFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts_fields', function (Blueprint $table) {
            $table->integer('id', true, true);
            $table->integer('contact_id')->unsigned();
            $table->integer('field_id')->unsigned();
            $table->string('field_value', 255);
            $table->index('contact_id', 'cont_fields_contact_id_idx');
            $table->foreign('contact_id', 'cont_fields_contact_id')->references('id')->on('contacts');
            $table->index('field_id', 'cont_fields_field_id_idx');
            $table->foreign('field_id', 'cont_fields_field_id')->references('id')->on('custom_fields');
        });

        DB::statement("ALTER TABLE `contacts_fields` comment 'Custom Fields Value'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contacts_fields');
    }
}
