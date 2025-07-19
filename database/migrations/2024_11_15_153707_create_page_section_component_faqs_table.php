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
        Schema::create('page_section_component_faqs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('attribuitable_id')->nullable();
            $table->string('attribuitable_type')->nullable();
            $table->string('title')->nullable();
            $table->longText('content')->nullable();
            $table->enum('type', ['faq', 'accordion'])->default('faq');
            $table->enum('view_position', ['left', 'right','full'])->default('left');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_section_component_faqs');
    }
};
