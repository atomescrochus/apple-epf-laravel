<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppleEpfArtistTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(config('apple-epf.database_connection'))->create('artist_type', function (Blueprint $table) {
            $table->unsignedInteger('export_date');
            $table->unsignedBigInteger('artist_type_id')->primary();
            $table->string('name', 1000);
            $table->unsignedBigInteger('primary_media_type_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection(config('apple-epf.database_connection'))->dropIfExists('artist_type');
    }
}
