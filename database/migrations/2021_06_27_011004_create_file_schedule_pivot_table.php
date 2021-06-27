<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFileSchedulePivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_schedule', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('file_id');
            $table->foreign('file_id', 'file_id_fk_4110361')->references('id')->on('files')->onDelete('cascade');
            $table->unsignedBigInteger('schedule_id');
            $table->foreign('schedule_id', 'schedule_id_fk_4110361')->references('id')->on('schedules')->onDelete('cascade');
            $table->integer('position');
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
        Schema::dropIfExists('file_schedule_pivot');
    }
}
