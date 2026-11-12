<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Disponibilidade extends Model
{
    protected $table = 'disponibilidades';

    protected $fillable = [
        'usuario_id',
        'dia_semana',
        'hora_inicio',
        'hora_fim',
        'ativo',
    ];

    protected function casts(): array
    {
        return [
            'dia_semana' => 'integer',
            'hora_inicio' => 'datetime:H:i',
            'hora_fim' => 'datetime:H:i',
            'ativo' => 'boolean',
        ];
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
