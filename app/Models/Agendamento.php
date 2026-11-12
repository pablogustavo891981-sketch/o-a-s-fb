<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Agendamento extends Model
{
    protected $table = 'agendamentos';

    protected $fillable = [
        'cliente_id',
        'prestador_id',
        'servico_id',
        'telefone_cliente',
        'data',
        'horario',
        'status',
        'observacoes',
    ];

    /**
     * Conversões dos atributos.
     */
    protected function casts(): array
    {
        return [
            'data' => 'date',
        ];
    }

    /**
     * Cliente que solicitou o agendamento.
     */
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(User::class, 'cliente_id');
    }

    /**
     * Prestador que receberá o agendamento.
     */
    public function prestador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'prestador_id');
    }

    /**
     * Serviço solicitado.
     */
    public function servico(): BelongsTo
    {
        return $this->belongsTo(Servico::class, 'servico_id');
    }

    /**
     * Avaliação relacionada ao agendamento.
     */
    public function avaliacao(): HasOne
    {
        return $this->hasOne(Avaliacao::class, 'agendamento_id');
    }
}
