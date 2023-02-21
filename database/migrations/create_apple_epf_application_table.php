<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppleEpfApplicationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(config('apple-epf.database_connection'))->create('application', function (Blueprint $table) {
            $table->unsignedInteger('export_date');
            $table->unsignedBigInteger('application_id')->primary();
            $table->string('title', 1000);
            $table->string('recommended_age', 3);
            $table->string('artist_name', 1000);
            $table->string('seller_name', 1000);
            $table->string('company_url', 1000)->nullable();
            $table->string('support_url', 1000)->nullable();
            $table->string('view_url', 1000);
            $table->string('artwork_url_large', 1000);
            $table->string('artwork_url_small', 1000);
            $table->dateTime('itunes_release_date');
            $table->string('copyright', 4000)->nullable();
            $table->longText('description');
            $table->string('version', 1000);
            $table->string('itunes_version', 1000);
            $table->unsignedBigInteger('download_size')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection(config('apple-epf.database_connection'))->dropIfExists('application');
    }
}