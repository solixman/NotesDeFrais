<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NoteDeFrais extends Model
{
    use HasFactory;

    protected $table = 'notes_de_frais';

    protected $fillable = [
        'utilisateur_id',
        'date_depense',
        'categorie',
        'montant',
        'devise',
        'description',
        'fichier_justificatif',
        'statut',
        'commentaire_validation',
        'date_validation',
    ];

    public function utilisateur(): BelongsTo
    {
        return $this->belongsTo(Utilisateur::class);
    }
}
