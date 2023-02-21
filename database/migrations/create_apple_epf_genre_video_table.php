<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppleEpfGenreVideoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(config('apple-epf.database_connection'))->create('genre_video', function (Blueprint $table) {
            $table->primary(['genre_id', 'collection_id'], 'genre_video_primary');
            $table->unsignedInteger('export_date');
            $table->unsignedBigInteger('genre_id');
            $table->unsignedBigInteger('collection_id');
            $table->boolean('is_primary_genre');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection(config('apple-epf.database_connection'))->dropIfExists('genre_video');
    }
}
