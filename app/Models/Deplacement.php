<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Deplacement extends Model
{
    use HasFactory;

    protected $table = 'deplacements';

    protected $fillable = [
        'utilisateur_id',
        'objet',
        'lieu',
        'date_depart',
        'date_retour',
        'moyen_transport',
        'cout_estime',
        'statut',
        'commentaire_validation',
        'date_validation',
    ];

    public function utilisateur(): BelongsTo
    {
        return $this->belongsTo(Utilisateur::class);
    }
}
