<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\NoteDeFrais;
use App\Notifications\NoteRejected;
use App\Notifications\NoteSubmitted;
use App\Notifications\NoteValidated;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{


    public function index()
    {
        try {


            $user = Auth::user();

            if ($user->role === 'comptable' || $user->role === 'admin') {
                return NoteDeFrais::where('utilisateur_id', $user->id)->all();
            }

            return NoteDeFrais::all();
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }


    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'date_depense' => 'required|date',
                'categorie' => 'required|in:repas,hôtel,transport',
                'montant' => 'required|numeric',
                'devise' => 'required|string|size:3',
                'description' => 'nullable|string',
                'fichier_justificatif' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
            ]);

            if ($request->hasFile('fichier_justificatif')) {
$data['fichier_justificatif'] = $request->file('fichier_justificatif')->store('justificatifs', 'public');
            }

            $data['utilisateur_id'] = Auth::id();
            $data['statut'] = 'brouillon';

            return NoteDeFrais::create($data);
        } catch (Exception $e) {
            return ['message' => $e->getMessage()];
        }
    }


    public function update(Request $request, $id)
    {
        try {

            $note = NoteDeFrais::findOrFail($id);

            if ($note->utilisateur_id !== Auth::id() || $note->statut !== 'brouillon') {
                return response()->json(['error' => 'Not allowed'], 403);
            }

            $data = $request->validate([
                'date_depense' => 'date',
                'categorie' => 'in:repas,hôtel,transport',
                'montant' => 'numeric',
                'devise' => 'string|size:3',
                'description' => 'nullable|string',
                'fichier_justificatif' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
            ]);

            if ($request->hasFile('fichier_justificatif')) {
                $data['fichier_justificatif'] = $request->file('fichier_justificatif')->store('justificatifs', 'public');
            }
            $data['description'] = $data['description'] . " (Mis à jour)";

            $note->update($data);
            return $note;
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }




    public function destroy($id)
    {
        try {


            $note = NoteDeFrais::findOrFail($id);

            if ($note->utilisateur_id !== Auth::id() || $note->statut !== 'brouillon') {
                return response()->json(['error' => 'Not allowed'], 403);
            }

            $note->delete();

            return response()->json(['message' => 'Note deleted']);
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }


    public function submit($id)
    {
        try {
            $note = NoteDeFrais::findOrFail($id);

            if ($note->utilisateur_id !== Auth::id() || $note->statut !== 'brouillon') {
                return response()->json(['error' => 'Cannot submit this note'], 403);
            }

            $note->statut = 'soumise';
            $note->save();

            //notifying the manager
            $manager = $note->utilisateur->manager;

            if ($manager) {
                $manager->notify(new NoteSubmitted($note));
            }


            if ($manager == null) {
                return ['message' => "the note has been submited but the user doen't have a manager"];
            }

            return $note;

        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }



    public function validateNote(Request $request, $id)
    {
        try {

            $user = Auth::user();
            $note = NoteDeFrais::findOrFail($id);

            if ($user->role !== 'manager') {
                return response()->json(['error' => 'Only managers can validate'], 403);
            }
     
            $note->statut = 'validée';
            $note->commentaire_validation = $request->input('commentaire');
            $note->date_validation = now();
            $note->save();
            $note->utilisateur->notify(new NoteValidated($note));

            return $note;
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function reject(Request $request, $id)
    {
        try {

            $user = Auth::user();
            $note = NoteDeFrais::findOrFail($id);

            // if ($user->role !== 'manager') {
            //     return response()->json(['error' => 'Only managers can reject'], 403);
            // }

            $request->validate(['commentaire' => 'required|string']);

            $note->statut = 'rejetée';
            $note->commentaire_validation = $request->input('commentaire');
            $note->date_validation = now();
            $note->save();
            $note->utilisateur->notify(new NoteRejected($note));

            return $note;
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }


    public function markAsReimbursed($id)
    {
        try {
            $user = Auth::user();
            $note = NoteDeFrais::findOrFail($id);

            if ($user->role !== 'comptable') {
                return response()->json(['error' => 'Only accountants can reimburse'], 403);
            }

            $note->statut = 'remboursée';
            $note->save();

            return $note;
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
