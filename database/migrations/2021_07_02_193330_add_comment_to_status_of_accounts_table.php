<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCommentToStatusOfAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*Schema::table('accounts', function (Blueprint $table) {
            $table->tinyInteger('status')->comment("1: active 0:delete 2:legit 3:invoicing")->change();
        });*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /*Schema::table('accounts', function (Blueprint $table) {
            $table->tinyInteger('status')->comment("")->change();
        });*/
    }
}
