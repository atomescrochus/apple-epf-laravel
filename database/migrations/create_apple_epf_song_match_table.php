<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppleEpfSongMatchTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(config('apple-epf.database_connection'))->create('song_match', function (Blueprint $table) {
            $table->unsignedInteger('export_date');
            $table->unsignedBigInteger('song_id')->primary();
            $table->string('isrc', 1000);
            $table->unsignedBigInteger('amg_track_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection(config('apple-epf.database_connection'))->dropIfExists('song_match');
    }
}
