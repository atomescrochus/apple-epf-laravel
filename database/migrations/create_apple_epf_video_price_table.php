<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppleEpfVideoPriceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(config('apple-epf.database_connection'))->create('video_price', function (Blueprint $table) {
            $table->primary(['video_id', 'storefront_id'], 'video_price_primary');
            $table->unsignedInteger('export_date');
            $table->unsignedBigInteger('video_id');
            $table->decimal('retail_price')->nullable();
            $table->unsignedBigInteger('storefront_id');
            $table->string('currency_code', 3);
            $table->dateTime('availability_date');
            $table->decimal('sd_price')->nullable();
            $table->decimal('hq_price')->nullable();
            $table->decimal('lc_rental_price')->nullable();
            $table->decimal('sd_rental_price')->nullable();
            $table->decimal('hd_rental_price')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection(config('apple-epf.database_connection'))->dropIfExists('video_price');
    }
}
