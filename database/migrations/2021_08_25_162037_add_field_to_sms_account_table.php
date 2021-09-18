<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldToSmsAccountTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sms_accounts', function (Blueprint $table) {
            $table->string('username', 128);
            $table->string('pwd', 255);
            $table->string('name', 128);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sms_accounts', function (Blueprint $table) {
            $table->dropColumn('username');
            $table->dropColumn('pwd');
            $table->dropColumn('name');
        });
    }
}
