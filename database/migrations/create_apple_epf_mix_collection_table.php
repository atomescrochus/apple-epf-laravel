<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppleEpfImixTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(config('apple-epf.database_connection'))->create('mix_collection', function (Blueprint $table) {
            $table->timestamp('export_date');
            $table->unsignedBigInteger('mix_collection_id')->primary();
            $table->string('title');
            $table->unsignedBigInteger('storefront_id');
            $table->unsignedBigInteger('parental_advisory_id');
            $table->string('mix_category_name');
            $table->unsignedBigInteger('mix_type_id');
            $table->dateTime('itunes_release_date');
            $table->string('view_url');
            $table->string('artwork_url_large');
            $table->string('artwork_url_small');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection(config('apple-epf.database_connection'))->dropIfExists('mix_collection');
    }
}
