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
            $table->timestamp('export_date');
            $table->unsignedBigInteger('application_id');
            $table->string('language_code', 2);
            $table->string('title');
            $table->text('description');
            $table->text('release_notes');
            $table->string('company_url');
            $table->string('suppport_url');
            $table->string('screenshot_url_1');
            $table->string('screenshot_url_2');
            $table->string('screenshot_url_3');
            $table->string('screenshot_url_4');
            $table->string('screenshot_width_height_1');
            $table->string('screenshot_width_height_2');
            $table->string('screenshot_width_height_3');
            $table->string('screenshot_width_height_4');
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
