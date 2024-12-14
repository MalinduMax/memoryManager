<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('memory_blocks', function (Blueprint $table) {
            $table->id();
            $table->integer('size');
            $table->boolean('allocated')->default(false);
            $table->string('allocated_to')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('memory_blocks');
    }
};
