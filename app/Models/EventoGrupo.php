<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EventoGrupo extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome','notas',
    ];

    /**
     * O Grupo 'tem muitos' (hasMany) Eventos.
     * Obtenha essa coleção de registros.
     */
    public function hasEventos(): HasMany
    {
        return $this->hasMany(Evento::class);
    }
}
