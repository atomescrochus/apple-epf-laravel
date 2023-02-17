<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppleEpfSongTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(config('apple-epf.database_connection'))->create('song', function (Blueprint $table) {
            $table->timestamp('export_date');
            $table->unsignedBigInteger('song_id')->primary();
            $table->string('name');
            $table->string('title_version');
            $table->string('search_terms');
            $table->unsignedBigInteger('parental_advisory_id');
            $table->string('artist_display_name')->nullable();
            $table->string('collection_display_name')->nullable();
            $table->string('view_url');
            $table->dateTime('original_release_date');
            $table->dateTime('itunes_release_date');
            $table->unsignedBigInteger('track_length');
            $table->string('copyright')->nullable();
            $table->string('p_line')->nullable();
            $table->string('preview_url');
            $table->unsignedBigInteger('preview_length');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection(config('apple-epf.database_connection'))->dropIfExists('song');
    }
}
