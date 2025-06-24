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

}
