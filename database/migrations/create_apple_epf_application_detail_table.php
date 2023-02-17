<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppleEpfApplicationDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(config('apple-epf.database_connection'))->create('application_detail', function (Blueprint $table) {
            $table->primary(['application_id', 'language_code']);
            $table->unsignedInteger('export_date');
            $table->unsignedBigInteger('application_id');
            $table->string('language_code', 2);
            $table->string('title', 1000);
            $table->text('description');
            $table->text('release_notes');
            $table->string('company_url', 1000);
            $table->string('suppport_url', 1000);
            $table->string('screenshot_url_1', 1000);
            $table->string('screenshot_url_2', 1000);
            $table->string('screenshot_url_3', 1000);
            $table->string('screenshot_url_4', 1000);
            $table->string('screenshot_width_height_1', 1000);
            $table->string('screenshot_width_height_2', 1000);
            $table->string('screenshot_width_height_3', 1000);
            $table->string('screenshot_width_height_4', 1000);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection(config('apple-epf.database_connection'))->dropIfExists('application_detail');
    }
}
