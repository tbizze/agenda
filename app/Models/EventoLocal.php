<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EventoLocal extends Model
{
    use HasFactory;

    protected $table = 'evento_locais';

    protected $fillable = [
        'nome','notas',
    ];

    /**
     * O Local 'tem muitos' (hasMany) Eventos.
     * Obtenha essa coleção de registros.
     */
    public function hasEventos(): HasMany
    {
        return $this->hasMany(Evento::class);
    }
}
