<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Utilisateur extends Authenticatable
{
    use HasFactory;

    protected $table = 'utilisateurs';

    protected $fillable = [
        'nom',
        'email',
        'mot_de_passe',
        'role',
        'manager_id',
    ];

    protected $hidden = [
        'mot_de_passe',
    ];

    public function notesDeFrais(): HasMany
    {
        return $this->hasMany(NoteDeFrais::class, 'utilisateur_id');
    }

    public function deplacements(): HasMany
    {
        return $this->hasMany(Deplacement::class, 'utilisateur_id');
    }

    public function manager(): BelongsTo
    {
        return $this->belongsTo(Utilisateur::class, 'manager_id');
    }
}
