<?php

namespace App\Http\Controllers;

use App\Models\UTILISATEURS;
use App\Http\Requests\StoreUTILISATEURSRequest;
use App\Http\Requests\UpdateUTILISATEURSRequest;
use Illuminate\Support\Facades\Auth;

class UtilisateurController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

public function notifications()
{
    $user = Auth::User();

    return response()->json([
        'unread' => $user->unreadNotifications,
        'read' => $user->readNotifications,
        'id' => $user->id,
        'all' => $user->notifications
    ]);
}


public function markAsRead($id)
{
    $notification = Auth::User()->notifications()->findOrFail($id);

    if (!$notification->read_at) {
        $notification->markAsRead();
    }

    return response()->json(['status' => 'read', 'id' => $id]);
}



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

}
