<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppleEpfGenreArtistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(config('apple-epf.database_connection'))->create('genre_artist', function (Blueprint $table) {
            $table->primary(['genre_id', 'artist_id']);
            $table->unsignedInteger('export_date');
            $table->unsignedBigInteger('genre_id');
            $table->unsignedBigInteger('artist_id');
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
        Schema::connection(config('apple-epf.database_connection'))->dropIfExists('genre_artist');
    }
}
