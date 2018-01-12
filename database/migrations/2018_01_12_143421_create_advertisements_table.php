<?php

use Illuminate\Support\Facades\Schema;
use Jenssegers\Mongodb\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdvertisementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advertisements', function (Blueprint $collection) {
            $collection->increments('id');
            $collection->string('name')->unique();
            $collection->string('sequence')->unique();
            $collection->string('path');
            $collection->integer('round_time');
            $collection->boolean('status');
            $collection->json('weeks');
            $collection->json('format');
            $collection->timestamp('published_at');
            $collection->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('advertisements');
    }
}
