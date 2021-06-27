<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSomToFileSegmentPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('file_segment_pivot', function (Blueprint $table) {
            $table->time('som')->nullable()->after('segment_id');
            $table->time('eom')->nullable()->after('som');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('file_segment_pivot', function (Blueprint $table) {
            //
        });
    }
}
