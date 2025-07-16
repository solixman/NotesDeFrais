<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\NoteDeFrais;
use App\Models\Deplacement;
use App\Models\Utilisateur;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        switch ($user->role) {

            case 'manager':
                return response()->json([
                    'notes_to_validate' => NoteDeFrais::where('statut', 'soumise')->count(),
                    'deplacements_to_validate' => Deplacement::where('statut', 'en attente')->count(),
                ]);

            case 'comptable':
                return response()->json([
                    'notes_to_reimburse' => NoteDeFrais::where('statut', 'validée')->count(),
                ]);

            case 'admin':
                return response()->json([
                    'total_users' => Utilisateur::count(),
                    'total_notes' => NoteDeFrais::count(),
                    'total_deplacements' => Deplacement::count(),
                ]);

            default:
               return response()->json([
                    'total_notes' =>  $user->notesDeFrais()->count(),
                    'drafts' => $user->notesDeFrais()->where('statut', 'brouillon')->count(),
                    'submitted' => $user->notesDeFrais()->where('statut', 'soumise')->count(),
                    'deplacements' => $user->deplacements()->count(),
                ]);
        }
        
    }
}
