<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChannelFilePivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('channel_file_pivot', function (Blueprint $table) {
            $table->unsignedBigInteger('channel_id');
            $table->foreign('channel_id', 'channel_id_fk_4110360')->references('id')->on('channels')->onDelete('cascade');
            $table->unsignedBigInteger('file_id');
            $table->foreign('file_id', 'file_id_fk_4110360')->references('id')->on('files')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('channel_file_pivot');
    }
}
