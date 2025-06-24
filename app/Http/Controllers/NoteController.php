<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\NoteDeFrais;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\TryCatch;

class NoteController extends Controller
{


    public function index()
    {
        try{

            
            $user = Auth::user();
            
            if ($user->role === 'comptable' || $user->role === 'admin') {
                return NoteDeFrais::where('utilisateur_id' , $user->id)->all();
            }
            
            return NoteDeFrais::all();
        }catch(Exception $e){
         return ['error'=>$e->getMessage()];
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
            return ['message'=>$e->getMessage()];
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
        $data['description']= $data['description'] ." (Mis à jour)";
        
        $note->update($data);
        return $note;
    } catch (Exception $e) {
        return ['error' => $e->getMessage()];
    }
    }


}