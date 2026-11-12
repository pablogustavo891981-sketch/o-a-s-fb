<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Servico extends Model
{
    protected $table = 'servicos';

    protected $fillable = [
        'usuario_id',
        'categoria_id',
        'nome',
        'descricao',
        'preco',
        'duracao',
        'local_atendimento',
        'imagem',
        'ativo',
    ];

    /**
     * Conversões dos atributos.
     */
    protected function casts(): array
    {
        return [
            'preco' => 'decimal:2',
            'duracao' => 'integer',
            'ativo' => 'boolean',
        ];
    }

    /**
     * Prestador responsável pelo serviço.
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    /**
     * Categoria do serviço.
     */
    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    /**
     * Agendamentos realizados para este serviço.
     */
    public function agendamentos(): HasMany
    {
        return $this->hasMany(Agendamento::class, 'servico_id');
    }
}
