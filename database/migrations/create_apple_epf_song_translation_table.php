<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppleEpfSongTranslationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(config('apple-epf.database_connection'))->create('song_translation', function (Blueprint $table) {
            $table->primary(['song_id', 'language_code', 'is_pronunciation', 'translation_type_id']);
            $table->unsignedInteger('export_date');
            $table->unsignedBigInteger('song_id');
            $table->string('language_code', 2);
            $table->boolean('is_pronunciation');
            $table->string('translation', 1000);
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
        Schema::connection(config('apple-epf.database_connection'))->dropIfExists('song_translation');
    }
}
