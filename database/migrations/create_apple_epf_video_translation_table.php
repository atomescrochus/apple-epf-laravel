<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppleEpfVideoTranslationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(config('apple-epf.database_connection'))->create('video_translation', function (Blueprint $table) {
            $table->primary(['video_id', 'language_code', 'is_pronunciation', 'translation_type_id']);
            $table->timestamp('export_date');
            $table->unsignedBigInteger('video_id');
            $table->string('language_code', 2);
            $table->boolean('is_pronunciation');
            $table->string('translation');
            $table->unsignedBigInteger('translation_type_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection(config('apple-epf.database_connection'))->dropIfExists('video_translation');
    }
}
