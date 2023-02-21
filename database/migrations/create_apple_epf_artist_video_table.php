<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppleEpfArtistVideoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(config('apple-epf.database_connection'))->create('artist_video', function (Blueprint $table) {
            $table->primary(['artist_id', 'video_id'], 'artist_video_primary');
            $table->unsignedInteger('export_date');
            $table->unsignedBigInteger('artist_id');
            $table->unsignedBigInteger('video_id');
            $table->boolean('is_primary_artist');
            $table->unsignedBigInteger('role_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection(config('apple-epf.database_connection'))->dropIfExists('artist_video');
    }
}
