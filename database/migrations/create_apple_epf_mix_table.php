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
        Schema::connection(config('apple-epf.database_connection'))->create('mix', function (Blueprint $table) {
            $table->timestamp('export_date');
            $table->unsignedBigInteger('mix_id')->primary();
            $table->unsignedBigInteger('mix_collection_id');
            $table->string('name');
            $table->text('description');
            $table->unsignedInteger('rank');
            $table->string('view_url');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection(config('apple-epf.database_connection'))->dropIfExists('mix');
    }
}
