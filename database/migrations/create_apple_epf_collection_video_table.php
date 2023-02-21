<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppleEpfCollectionVideoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(config('apple-epf.database_connection'))->create('collection_video', function (Blueprint $table) {
            $table->primary(['collection_id', 'video_id'], 'collection_video_primary');
            $table->unsignedInteger('export_date');
            $table->unsignedBigInteger('collection_id');
            $table->unsignedBigInteger('video_id');
            $table->tinyInteger('track_number');
            $table->tinyInteger('volume_number');
            $table->boolean('preorder_only');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection(config('apple-epf.database_connection'))->dropIfExists('collection_video');
    }
}
