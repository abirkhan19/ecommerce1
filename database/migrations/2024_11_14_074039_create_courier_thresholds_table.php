<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('courier_thresholds', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('courier_id')->unsigned();
            $table->string('low_threshold');
            $table->string('high_threshold');
            $table->float('price');
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courier_thresholds');
    }
};
