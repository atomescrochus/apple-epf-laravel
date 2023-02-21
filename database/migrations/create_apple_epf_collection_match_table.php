<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppleEpfCollectionMatchTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(config('apple-epf.database_connection'))->create('collection_match', function (Blueprint $table) {
            $table->unsignedInteger('export_date');
            $table->unsignedBigInteger('collection_id')->primary();
            $table->string('upc', 1000);
            $table->unsignedBigInteger('amg_album_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection(config('apple-epf.database_connection'))->dropIfExists('collection_match');
    }
}
