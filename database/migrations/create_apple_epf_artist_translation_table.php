<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppleEpfArtistTranslationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(config('apple-epf.database_connection'))->create('artist_translation', function (Blueprint $table) {
            $table->timestamp('export_date');
            $table->unsignedBigInteger('artist_id')->primary();
            $table->string('language_code', 2)->primary();
            $table->boolean('is_pronunciation')->primary();
            $table->string('translation');
            $table->unsignedBigInteger('translation_type_id')->primary();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection(config('apple-epf.database_connection'))->dropIfExists('artist_translation');
    }
}
