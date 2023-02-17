<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppleEpfCollectionPriceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(config('apple-epf.database_connection'))->create('collection_price', function (Blueprint $table) {
            $table->primary(['collection_id', 'storefront_id']);
            $table->unsignedInteger('export_date');
            $table->unsignedBigInteger('collection_id');
            $table->unsignedDecimal('retail_price')->nullable();
            $table->unsignedBigInteger('storefront_id');
            $table->string('currency_code', 3);
            $table->dateTime('availability_date');
            $table->unsignedDecimal('hq_price')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection(config('apple-epf.database_connection'))->dropIfExists('collection_price');
    }
}
