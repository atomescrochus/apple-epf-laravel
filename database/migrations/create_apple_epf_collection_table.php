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
            $table->unsignedInteger('export_date');
            $table->unsignedBigInteger('collection_id')->primary();
            $table->string('name', 1000);
            $table->string('title_version', 1000)->nullable();
            $table->string('search_terms', 1000)->nullable();
            $table->unsignedBigInteger('parental_advisory_id');
            $table->string('artist_display_name', 1000)->nullable();
            $table->string('view_url', 1000);
            $table->string('artwork_url', 1000);
            $table->dateTime('original_release_date');
            $table->dateTime('itunes_release_date');
            $table->string('label_studio', 1000);
            $table->string('content_provider', 1000);
            $table->string('copyright', 1000)->nullable();
            $table->string('pline', 1000)->nullable();
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