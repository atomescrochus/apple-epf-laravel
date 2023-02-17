<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppleEpfApplicationPriceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(config('apple-epf.database_connection'))->create('application_price', function (Blueprint $table) {
            $table->primary(['application_id', 'storefront_id']);
            $table->timestamp('export_date');
            $table->unsignedBigInteger('application_id');
            $table->unsignedDecimal('retail_price')->nullable();
            $table->string('currency_code')->nullable();
            $table->unsignedBigInteger('storefront_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection(config('apple-epf.database_connection'))->dropIfExists('application_price');
    }
}
