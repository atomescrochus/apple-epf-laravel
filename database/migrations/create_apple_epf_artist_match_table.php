<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppleEpfArtistMatchTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(config('apple-epf.database_connection'))->create('artist_match', function (Blueprint $table) {
            $table->unsignedInteger('export_date');
            $table->unsignedBigInteger('artist_id')->primary();
            $table->unsignedBigInteger('amg_artist_id');
            $table->unsignedBigInteger('amg_video_artist_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection(config('apple-epf.database_connection'))->dropIfExists('artist_match');
    }
}
