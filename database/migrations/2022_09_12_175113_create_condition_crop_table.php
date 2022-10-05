<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('condition_crop', function (Blueprint $table) {
            $table->id();
            $table->float('min')->nullable();
            $table->float('max')->nullable();
            $table->float('regular')->nullable();
            $table->foreignId('crop_id');
            $table->foreignId('condition_id');
            $table->timestamps();
            $table->foreign('crop_id')->references('id')->on('crops');
            $table->foreign('condition_id')->references('id')->on('conditions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('condition_crop');
    }
};
