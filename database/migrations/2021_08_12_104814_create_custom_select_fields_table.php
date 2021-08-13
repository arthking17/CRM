<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCustomSelectFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_select_fields', function (Blueprint $table) {
            $table->integer('id', true, true);
            $table->integer('field_id')->unsigned();
            $table->string('title', 128);
            $table->index('field_id', 'cust_select_field_id_idx');
            $table->foreign('field_id', 'cust_select_field_id')->references('id')->on('custom_fields');
        });

        DB::statement("ALTER TABLE `custom_select_fields` comment 'Custom select Fields Value'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('custom_select_fields');
    }
}
