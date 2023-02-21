<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppleEpfVideoMatchTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(config('apple-epf.database_connection'))->create('video_match', function (Blueprint $table) {
            $table->unsignedInteger('export_date');
            $table->unsignedBigInteger('video_id')->primary();
            $table->string('upc', 1000);
            $table->string('isrc', 1000);
            $table->unsignedBigInteger('amg_video_id');
            $table->string('isan', 1000);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection(config('apple-epf.database_connection'))->dropIfExists('video_match');
    }
}
