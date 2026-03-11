<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('evaluation_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('position');
            $table->enum('type', ['qcm', 'vrai_faux'])->default('qcm');
            $table->text('intitule');
            $table->string('choix_a');
            $table->string('choix_b');
            $table->string('choix_c');
            $table->string('choix_d');
            $table->enum('bonne_reponse', ['a', 'b', 'c', 'd']);
            $table->decimal('points', 5, 2);
            $table->timestamps();

            $table->unique(['evaluation_id', 'position']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
