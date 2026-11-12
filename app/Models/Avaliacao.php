<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Avaliacao extends Model
{
    protected $table = 'avaliacoes';

    protected $fillable = [
        'agendamento_id',
        'cliente_id',
        'prestador_id',
        'nota',
        'comentario',
    ];

    /**
     * Conversões dos atributos.
     */
    protected function casts(): array
    {
        return [
            'nota' => 'integer',
        ];
    }

    /**
     * Agendamento avaliado.
     */
    public function agendamento(): BelongsTo
    {
        return $this->belongsTo(Agendamento::class, 'agendamento_id');
    }

    /**
     * Cliente que realizou a avaliação.
     */
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(User::class, 'cliente_id');
    }

    /**
     * Prestador que recebeu a avaliação.
     */
    public function prestador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'prestador_id');
    }
}
