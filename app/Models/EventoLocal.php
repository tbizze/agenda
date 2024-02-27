<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventoLocal extends Model
{
    use HasFactory;

    /**
     * Habilita o recurso de apagar para Lixeira.
     */
    use SoftDeletes;

    /**
     * Define o nome da tabela no BD.
     */
    protected $table = 'evento_locais';

    /**
     * Lista des campos em que é permitido a persistência no BD.. 
     */
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
