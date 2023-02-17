<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppleEpfSongPopularityPerGenreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(config('apple-epf.database_connection'))->create('song_popularity_per_genre', function (Blueprint $table) {
            $table->timestamp('export_date');
            $table->unsignedBigInteger('storefront_id')->primary();
            $table->unsignedBigInteger('genre_id')->primary();
            $table->unsignedBigInteger('song_id')->primary();
            $table->unsignedBigInteger('song_rank')->primary();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection(config('apple-epf.database_connection'))->dropIfExists('song_popularity_per_genre');
    }
}
