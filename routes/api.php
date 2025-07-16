<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DeplacementController;
use App\Http\Controllers\Api\FichierController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\UtilisateurController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DashboardController;




/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');



Route::middleware('auth:sanctum')->group(function () {
    
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);


    Route::get('/notes', [NoteController::class, 'index']);
    Route::post('/notes', [NoteController::class, 'store']);
    Route::put('/notes/{id}', [NoteController::class, 'update']);
    Route::delete('/notes/{id}', [NoteController::class, 'destroy']);

    Route::post('/notes/{id}/soumettre', [NoteController::class, 'submit']);
    Route::post('/notes/{id}/valider', [NoteController::class, 'validateNote']);
    Route::post('/notes/{id}/rejeter', [NoteController::class, 'reject']);
    Route::post('/notes/{id}/remboursement', [NoteController::class, 'markAsReimbursed']);

    //deplacements 
    Route::get('/deplacements', [DeplacementController::class, 'index']);
    Route::post('/deplacements', [DeplacementController::class, 'store']);
    Route::put('/deplacements/{id}', [DeplacementController::class, 'update']);
    Route::delete('/deplacements/{id}', [DeplacementController::class, 'destroy']);
    
    Route::post('/deplacements/{id}/valider', [DeplacementController::class, 'accepter']);
    Route::post('/deplacements/{id}/rejeter', [DeplacementController::class, 'rejeter']);

    // notifications
    Route::get('/notifications', [UtilisateurController::class, 'notifications']);
    Route::post('/notifications/{id}/mark-as-read', [UtilisateurController::class, 'markAsRead']);

    //handling files
    Route::get('/justificatif/{filename}', [FichierController::class, 'download']);

    Route::get('/dashboard', [DashboardController::class, 'index']);
});





