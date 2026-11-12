<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('servicos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('usuario_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('categoria_id')
                ->constrained('categorias')
                ->restrictOnDelete();

            $table->string('nome');
            $table->text('descricao');
            $table->decimal('preco', 10, 2);
            $table->unsignedInteger('duracao');
            $table->string('imagem')->nullable();

            $table->boolean('ativo')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('servicos');
    }
};
