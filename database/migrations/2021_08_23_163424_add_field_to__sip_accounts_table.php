<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldToSipAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sip_accounts', function (Blueprint $table) {
            $table->integer('channel_id')->unsigned()->after('id');
            $table->string('host', 128)->after('channel_id');
            $table->string('username', 128)->after('host');
            $table->string('pwd', 255)->after('username');
            $table->integer('port')->unsigned()->after('pwd');
            $table->string('name', 128)->after('port');
            $table->tinyInteger('priority')->unsigned()->comment("priority:\n1:low\n2:normal\n3:high")->after('name');
            $table->index('channel_id', 'sip_channel_id_idx');
            $table->foreign('channel_id', 'sip_channel_id')->references('id')->on('channels');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sip_accounts', function (Blueprint $table) {
            $table->dropColumn('channel_id');
            $table->dropColumn('host');
            $table->dropColumn('username');
            $table->dropColumn('pwd');
            $table->dropColumn('port');
            $table->dropColumn('name');
            $table->dropColumn('priority');
        });
    }
}
