<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppleEpfGenreCollectionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(config('apple-epf.database_connection'))->create('genre_collection', function (Blueprint $table) {
            $table->primary(['genre_id', 'collection_id'], 'genre_collection_primary');
            $table->unsignedInteger('export_date');
            $table->unsignedBigInteger('genre_id');
            $table->unsignedBigInteger('collection_id');
            $table->boolean('is_primary_collection');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection(config('apple-epf.database_connection'))->dropIfExists('genre_collection');
    }
}
