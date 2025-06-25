<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Deplacement;
use App\Notifications\DeplacementSubmitted;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeplacementController extends Controller
{
    public function index()
    {
        try {
            $user = Auth::user();

            if ($user->role === 'admin' || $user->role === 'comptable') {
                return Deplacement::all();
            }

            return $user->deplacements;
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }


    public function store(Request $request)
    {

        try {

            $data = $request->validate([
                'objet' => 'required|string|max:255',
                'lieu' => 'required|string|max:255',
                'date_depart' => 'required|date',
                'date_retour' => 'required|date|after_or_equal:date_depart',
                'moyen_transport' => 'required|string|max:100',
                'cout_estime' => 'required|numeric',
                'description' => 'nullable|string',
            ]);

            $data['utilisateur_id'] = Auth::id();
            $data['statut'] = 'en_attente';

            $deplacement = Deplacement::create($data);

            $manager = $deplacement->utilisateur->manager;

            if ($manager) {
                $manager->notify(new DeplacementSubmitted($deplacement));
            }
            return ['succes' => 'deplacement created succefully'];
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }



    public function update(Request $request, $id)
    {
        try {

            $deplacement = Deplacement::findOrFail($id);


            if ($deplacement->utilisateur_id !== Auth::id() || $deplacement->statut !== 'en_attente') {
                return response()->json(['error' => 'Not allowed'], 403);
            }

            $data = $request->validate([
                'objet' => 'string|max:255',
                'lieu' => 'string|max:255',
                'date_depart' => 'date',
                'date_retour' => 'date|after_or_equal:date_depart',
                'moyen_transport' => 'string|max:100',
                'cout_estime' => 'numeric',
                'description' => 'nullable|string',
            ]);

            $deplacement->update($data);
            return $deplacement;
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }


    public function destroy($id)
    {
        try {
            $deplacement = Deplacement::findOrFail($id);

            if ($deplacement->utilisateur_id !== Auth::id() || $deplacement->statut !== 'en_attente') {
                return response()->json(['error' => 'Not allowed'], 403);
            }

            $deplacement->delete();

            return response()->json(['message' => 'Déplacement supprimé']);
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }


    public function accepter(Request $request, $id)
    {

        try {
            $user = Auth::user();

            if ($user->role !== 'manager') {
                return response()->json(['error' => 'Only managers can validate'], 403);
            }

            $deplacement = Deplacement::findOrFail($id);

            $deplacement->statut = 'accepté';
            $deplacement->commentaire_validation = $request->input('commentaire');
            $deplacement->date_validation = now();
            $deplacement->save();

            return $deplacement;
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }


    public function rejeter(Request $request, $id)
    {
        try {

            $user = Auth::user();

            if ($user->role !== 'manager') {
                return response()->json(['error' => 'Only managers can reject'], 403);
            }


            $request->validate(['commentaire' => 'required|string']);

            $deplacement = Deplacement::findOrFail($id);
            $deplacement->statut = 'refusé';
            $deplacement->commentaire_validation = $request->input('commentaire');
            $deplacement->date_validation = now();
            $deplacement->save();

            return $deplacement;
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
