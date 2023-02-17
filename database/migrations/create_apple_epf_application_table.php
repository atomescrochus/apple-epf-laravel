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
            $table->timestamp('export_date');
            $table->unsignedBigInteger('application_id')->primary();
            $table->string('title');
            $table->string('recommended_age', 3);
            $table->string('artist_name');
            $table->string('seller_name');
            $table->string('company_url');
            $table->string('support_url');
            $table->string('view_url');
            $table->string('artwork_url_large');
            $table->string('artwork_url_small');
            $table->dateTime('itunes_release_date');
            $table->string('copyright')->nullable();
            $table->text('description');
            $table->string('version');
            $table->string('itunes_version');
            $table->unsignedBigInteger('download_size');
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