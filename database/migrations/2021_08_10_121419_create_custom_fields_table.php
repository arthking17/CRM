<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCustomFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_fields', function (Blueprint $table) {
            $table->integer('id', true, true);
            $table->integer('account_id')->unsigned();
            $table->string('name', 128);
            $table->string('tag', 64);
            $table->string('field_type', 32);
            $table->tinyInteger('status')->unsigned()->comment("1: active 0:disable")->default(1);
            $table->index('account_id', 'cust_account_id_idx');
            $table->foreign('account_id', 'cust_account_id')->references('id')->on('accounts');
        });

        DB::statement("ALTER TABLE `custom_fields` comment 'Custom Fields'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('custom_fields');
    }
}
