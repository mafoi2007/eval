<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('eleve_id')->constrained()->cascadeOnDelete();
            $table->foreignId('evaluation_id')->constrained()->cascadeOnDelete();
            $table->text('contenu')->nullable();
            $table->float('valeur')->nullable();
            $table->timestamps();
            $table->unique(['eleve_id', 'evaluation_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};
