<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->integer('id', true, true);
            $table->integer('account_id')->unsigned()->default(1);
            $table->string('name', 255);
            $table->index('account_id', 'account_id_idx');
            $table->foreign('account_id')->references('id')->on('accounts');
        });

        DB::statement("ALTER TABLE `groups` comment 'Table of contacts groups'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('groups');
    }
}
