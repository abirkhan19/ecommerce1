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
        Schema::create('page_section_components', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->bigInteger('atribuitable_id')->nullable();
            $table->string('atribuitable_type')->nullable();
            $table->tinyInteger('has_galery')->default(0);
            $table->tinyInteger('has_links')->default(0);
            $table->longText('content')->nullable();    
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_section_components');
    }
};
