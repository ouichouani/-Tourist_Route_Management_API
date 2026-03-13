<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('itinerary_to_visit_list', function (Blueprint $table) {
            $table->id();
            $table->foreignId('to_visit_list_id')->constrained('to_visit_lists')->cascadeOnDelete();
            $table->foreignId('itinerary_id')->constrained('itineraries')->cascadeOnDelete();
            $table->unique(['to_visit_list_id', 'itinerary_id']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('itinerary_to_visit_list');
    }
};