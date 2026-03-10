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
        Schema::create('itineraries', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('title');
            $table->timestamp('duration_from') ;
            $table->timestamp('duration_to') ;
            $table->string('image');
            $table->foreignId('category_id')->constrained('categories')->onDelete('set null') ;
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('itineraries');
    }
};
