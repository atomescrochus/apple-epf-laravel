<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppleEpfCollectionSongTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(config('apple-epf.database_connection'))->create('collection_song', function (Blueprint $table) {
            $table->timestamp('export_date');
            $table->unsignedBigInteger('collection_id')->primary();
            $table->unsignedBigInteger('song_id')->primary();
            $table->tinyInteger('track_number');
            $table->tinyInteger('volume_number');
            $table->boolean('preorder_only');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection(config('apple-epf.database_connection'))->dropIfExists('collection_song');
    }
}
