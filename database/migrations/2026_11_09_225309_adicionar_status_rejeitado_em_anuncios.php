<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            ALTER TABLE anuncios
            MODIFY status ENUM(
                'ativo',
                'inativo',
                'pendente',
                'rejeitado'
            ) NOT NULL DEFAULT 'pendente'
        ");
    }

    public function down(): void
    {
        DB::statement("
            UPDATE anuncios
            SET status = 'pendente'
            WHERE status = 'rejeitado'
        ");

        DB::statement("
            ALTER TABLE anuncios
            MODIFY status ENUM(
                'ativo',
                'inativo',
                'pendente'
            ) NOT NULL DEFAULT 'pendente'
        ");
    }
};