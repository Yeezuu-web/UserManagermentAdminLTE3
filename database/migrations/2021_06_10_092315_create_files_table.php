<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->string('fileId');
            $table->string('title_of_content');
            $table->json('channels');
            $table->string('segment')->nullable();
            $table->string('episode')->nullable();
            $table->string('file_extension')->nullable();
            $table->time('duration')->nullable();
            $table->string('resolution')->nullable();
            $table->string('file_size')->nullable();
            $table->string('size_type')->nullable();
            $table->string('path')->nullable();
            $table->string('storage')->nullable();
            $table->date('date_received')->nullable();
            $table->date('air_date')->nullable();
            $table->year('year')->nullable();
            $table->string('period')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->json('types')->nullable();
            $table->string('territory')->nullable();
            $table->json('genres')->nullable();
            $table->string('me')->nullable();
            $table->string('khmer_dub')->nullable();
            $table->string('poster')->nullable();
            $table->string('trailer_promo')->nullable();
            $table->text('synopsis')->nullable();
            $table->text('remark')->nullable();
            $table->boolean('file_available')->nullable();
            $table->bigInteger('content_id');
            $table->foreignId('series_id')->nullable()->constrained();
            $table->foreignId('user_id')->nullable()->constrained();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('files');
    }
}
