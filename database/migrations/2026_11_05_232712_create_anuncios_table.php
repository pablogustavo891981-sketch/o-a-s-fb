<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('anuncios', function (Blueprint $table) {
            $table->id();

            $table->foreignId('usuario_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('categoria_id')
                ->constrained('categorias')
                ->restrictOnDelete();

            $table->string('titulo');
            $table->text('descricao');
            $table->string('contato', 30);
            $table->text('informacoes_oferta')->nullable();
            $table->string('imagem')->nullable();

            $table->enum('status', [
                'ativo',
                'inativo',
                'pendente'
            ])->default('pendente');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('anuncios');
    }
};
