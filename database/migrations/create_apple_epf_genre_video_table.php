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
            $table->timestamp('export_date');
            $table->unsignedBigInteger('genre_id')->primary();
            $table->unsignedBigInteger('collection_id')->primary();
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
