<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Anuncio extends Model
{
    protected $table = 'anuncios';

    protected $fillable = [
        'usuario_id',
        'categoria_id',
        'titulo',
        'descricao',
        'contato',
        'informacoes_oferta',
        'imagem',
        'status',
    ];

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }
}
