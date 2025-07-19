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
        Schema::create('with_quotes_components', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->longText('before_quote')->nullable();
            $table->longText('quote')->nullable();
            $table->longText('after_quote')->nullable();
            $table->longText('with_hover')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('with_quotes_components');
    }
};
