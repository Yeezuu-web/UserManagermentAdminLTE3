<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDayFilePivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('day_file', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('day_id');
            $table->foreign('day_id', 'day_id_fk_4110361')->references('id')->on('days')->onDelete('cascade');
            $table->unsignedBigInteger('file_id');
            $table->foreign('file_id', 'file_id_fk_4110361')->references('id')->on('files')->onDelete('cascade');
            $table->integer('position_order');
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
        Schema::dropIfExists('day_file_pivot');
    }
}
