<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppleEpfVideoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(config('apple-epf.database_connection'))->create('video', function (Blueprint $table) {
            $table->unsignedInteger('export_date');
            $table->unsignedBigInteger('video_id')->primary();
            $table->string('name', 1000);
            $table->string('title_version', 1000);
            $table->string('search_terms', 1000)->nullable();
            $table->unsignedBigInteger('parental_advisory_id');
            $table->string('artist_display_name', 1000)->nullable();
            $table->string('collection_display_name', 1000)->nullable();
            $table->string('media_type', 1000);
            $table->string('view_url', 1000);
            $table->string('artwork_url', 1000);
            $table->dateTime('original_release_date');
            $table->dateTime('itunes_release_date');
            $table->string('studio_name', 1000);
            $table->string('network_name', 1000);
            $table->string('content_provider', 1000);
            $table->unsignedBigInteger('track_length');
            $table->string('copyright', 1000)->nullable();
            $table->string('p_line', 1000)->nullable();
            $table->text('short_description');
            $table->text('long_description');
            $table->unsignedInteger('episode_production_number');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection(config('apple-epf.database_connection'))->dropIfExists('video');
    }
}
