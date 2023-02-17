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
            $table->primary(['storefron_id', 'genre_id', 'song_id']);
            $table->unsignedInteger('export_date');
            $table->unsignedBigInteger('storefront_id');
            $table->unsignedBigInteger('genre_id');
            $table->unsignedBigInteger('song_id');
            $table->unsignedBigInteger('song_rank');
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
