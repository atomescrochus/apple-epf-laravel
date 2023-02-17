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
            $table->timestamp('export_date');
            $table->unsignedBigInteger('video_id')->primary();
            $table->string('name');
            $table->string('title_version');
            $table->string('search_terms')->nullable();
            $table->unsignedBigInteger('parental_advisory_id');
            $table->string('artist_display_name')->nullable();
            $table->string('collection_display_name')->nullable();
            $table->string('media_type');
            $table->string('view_url');
            $table->string('artwork_url');
            $table->dateTime('original_release_date');
            $table->dateTime('itunes_release_date');
            $table->string('studio_name');
            $table->string('network_name');
            $table->string('content_provider');
            $table->unsignedBigInteger('track_length');
            $table->string('copyright')->nullable();
            $table->string('p_line')->nullable();
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
