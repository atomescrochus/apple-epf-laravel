<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppleEpfArtistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(config('apple-epf.database_connection'))->create('artist', function (Blueprint $table) {
            $table->unsignedInteger('export_date');
            $table->unsignedInteger('artist_id')->primary();
            $table->string('name', 1000);
            $table->string('search_terms', 1000)->nullable();
            $table->boolean('is_actual_artist');
            $table->string('view_url', 1000);
            $table->unsignedInteger('artist_type_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection(config('apple-epf.database_connection'))->dropIfExists('artist');
    }
}
