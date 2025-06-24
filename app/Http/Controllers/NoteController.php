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


}