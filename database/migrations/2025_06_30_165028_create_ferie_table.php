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
        Schema::create('ferie', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dipendente_id')->constrained('dipendenti')->onDelete('cascade');
            $table->date('data_inizio');
            $table->date('data_fine');
            $table->enum('stato', ['in attesa', 'approvato', 'rifiutato'])->default('in attesa');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ferie');
    }
};
