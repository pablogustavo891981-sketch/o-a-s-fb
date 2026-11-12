<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('avaliacoes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('agendamento_id')
                ->unique()
                ->constrained('agendamentos')
                ->cascadeOnDelete();

            $table->foreignId('cliente_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('prestador_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->unsignedTinyInteger('nota');
            $table->text('comentario')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('avaliacoes');
    }
};
