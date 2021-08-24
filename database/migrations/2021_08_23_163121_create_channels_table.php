<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateChannelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('channels', function (Blueprint $table) {
            $table->id();
            $table->string('name', 128);
            $table->tinyInteger('class')->unsigned()->comment("1: GoCall\n2:Twilio\n3:GoMailer\n4:Plivo\n5:Gmail");
            $table->tinyInteger('status')->unsigned()->comment("1: active\n0:disabled")->default(1);
            $table->date('start_date');
            $table->date('end_date')->nullable();
        });

        DB::statement("ALTER TABLE `sip_accounts` comment 'Channels'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('channels');
    }
}
