<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NoteDeFrais;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class FichierController extends Controller
{
    public function download($filename){

        $note = NoteDeFrais::where('fichier_justificatif', 'justificatifs/' . $filename)->first();

if (!$note || $note->utilisateur_id !== Auth::id()) {
    return response()->json(['error' => 'Not authorized '], 403);
}
    $path = '/justificatifs/'.$filename; 


    if (!Storage::disk('public')->exists($path)) {
        return response()->json(['error' => 'Fichier non trouvé'], 404);
    }

    return Storage::disk('public')->download($path);
}
}
