<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Deplacement;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeplacementController extends Controller
{
    public function index()
    {
        try{
        $user = Auth::user();

        if ($user->role === 'admin' || $user->role === 'comptable') {
            return Deplacement::all();
        }

        return $user->deplacements; 
          } catch (Exception $e) {
            return ['error'=>$e->getMessage()];
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

        Deplacement::create($data);
        return ['succes'=>'deplacement created succefully'] ;
             
        } catch (Exception $e) {
            return ['error'=>$e->getMessage()];
        }
    }


    
   

}
