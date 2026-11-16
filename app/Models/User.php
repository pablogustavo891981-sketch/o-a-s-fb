<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable([
    'name',
    'email',
    'password',
    'tipo_usuario',
    'telefone',
])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Conversões dos atributos.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Anúncios publicados pelo usuário.
     */
    public function anuncios(): HasMany
    {
        return $this->hasMany(Anuncio::class, 'usuario_id');
    }

    /**
     * Serviços oferecidos pelo prestador.
     */
    public function servicos(): HasMany
    {
        return $this->hasMany(Servico::class, 'usuario_id');
    }

    /**
     * Horários disponíveis do prestador.
     */
    public function disponibilidades(): HasMany
    {
        return $this->hasMany(Disponibilidade::class, 'usuario_id');
    }

    /**
     * Agendamentos realizados como cliente.
     */
    public function agendamentosComoCliente(): HasMany
    {
        return $this->hasMany(Agendamento::class, 'cliente_id');
    }

    /**
     * Agendamentos recebidos como prestador.
     */
    public function agendamentosComoPrestador(): HasMany
    {
        return $this->hasMany(Agendamento::class, 'prestador_id');
    }

    /**
     * Avaliações recebidas pelo prestador.
     */
    public function avaliacoesRecebidas(): HasMany
    {
        return $this->hasMany(Avaliacao::class, 'prestador_id');
    }
}
