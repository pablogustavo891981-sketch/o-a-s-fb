<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categoria extends Model
{
    protected $table = 'categorias';

    protected $fillable = [
        'nome',
        'descricao',
        'ativa',
    ];

    protected function casts(): array
    {
        return [
            'ativa' => 'boolean',
        ];
    }

    public function anuncios(): HasMany
    {
        return $this->hasMany(Anuncio::class, 'categoria_id');
    }

    public function servicos(): HasMany
    {
        return $this->hasMany(Servico::class, 'categoria_id');
    }
}
