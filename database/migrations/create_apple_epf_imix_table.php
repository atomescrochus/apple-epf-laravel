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
        Schema::connection(config('apple-epf.database_connection'))->create('imix', function (Blueprint $table) {
            $table->timestamp('export_date');
            $table->unsignedBigInteger('imix_id')->primary();
            $table->string('title');
            $table->text('description');
            $table->unsignedBigInteger('storefront_id');
            $table->decimal('rating_average');
            $table->unsignedInteger('rating_count');
            $table->dateTime('itunes_release_date');
            $table->unsignedBigInteger('imix_type_id');
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
        Schema::connection(config('apple-epf.database_connection'))->dropIfExists('imix');
    }
}
