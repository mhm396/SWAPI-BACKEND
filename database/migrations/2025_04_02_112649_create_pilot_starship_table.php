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
        Schema::create('pilot_starship', function (Blueprint $table) {
            $table->foreignId('pilot_id')->constrained('pilots', 'pilot_id')->onDelete('cascade');
            $table->foreignId('starship_id')->constrained('starships', 'starship_id')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pilot_starship');
    }
};
