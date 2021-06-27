<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFileSegmentPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_segment_pivot', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('file_id');
            $table->foreign('file_id', 'file_id_fk_4110359')->references('id')->on('files')->onDelete('cascade');
            $table->unsignedBigInteger('segment_id');
            $table->foreign('segment_id', 'segment_id_fk_4110359')->references('id')->on('segments')->onDelete('cascade');
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
        Schema::dropIfExists('file_segment_pivot');
    }
}
