<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Utilisateur extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;

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
        'remember_token',
    ];

    // Relationships
    public function manager()
    {
        return $this->belongsTo(Utilisateur::class, 'manager_id');
    }

    public function notesDeFrais()
    {
        return $this->hasMany(NoteDeFrais::class, 'utilisateur_id');
    }

    public function deplacements()
    {
        return $this->hasMany(Deplacement::class, 'utilisateur_id');
    }

    // Password mutator (optional but good)
    public function setMotDePasseAttribute($value)
    {
        $this->attributes['mot_de_passe'] = bcrypt($value);
    }

    // Needed for auth
    public function getAuthPassword()
    {
        return $this->mot_de_passe;
    }
}
