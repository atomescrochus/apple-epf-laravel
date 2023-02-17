<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppleEpfCollectionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(config('apple-epf.database_connection'))->create('collection', function (Blueprint $table) {
            $table->timestamp('export_date');
            $table->unsignedBigInteger('collection_id')->primary();
            $table->string('name');
            $table->string('title_version')->nullable();
            $table->string('search_terms');
            $table->unsignedBigInteger('parental_advisory_id');
            $table->string('artist_display_name')->nullable();
            $table->string('view_url');
            $table->string('artwork_url');
            $table->dateTime('original_release_date');
            $table->dateTime('itunes_release_date');
            $table->string('label_studio');
            $table->string('content_provider');
            $table->string('copyright')->nullable();
            $table->string('pline')->nullable();
            $table->unsignedBigInteger('media_type_id');
            $table->boolean('is_compilation');
            $table->unsignedBigInteger('collection_type_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection(config('apple-epf.database_connection'))->dropIfExists('collection');
    }
}