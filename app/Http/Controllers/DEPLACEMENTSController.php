<?php

namespace App\Http\Controllers;

use App\Models\DEPLACEMENTS;
use App\Http\Requests\StoreDEPLACEMENTSRequest;
use App\Http\Requests\UpdateDEPLACEMENTSRequest;

class DEPLACEMENTSController extends Controller
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDEPLACEMENTSRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDEPLACEMENTSRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DEPLACEMENTS  $dEPLACEMENTS
     * @return \Illuminate\Http\Response
     */
    public function show(DEPLACEMENTS $dEPLACEMENTS)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DEPLACEMENTS  $dEPLACEMENTS
     * @return \Illuminate\Http\Response
     */
    public function edit(DEPLACEMENTS $dEPLACEMENTS)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDEPLACEMENTSRequest  $request
     * @param  \App\Models\DEPLACEMENTS  $dEPLACEMENTS
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDEPLACEMENTSRequest $request, DEPLACEMENTS $dEPLACEMENTS)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DEPLACEMENTS  $dEPLACEMENTS
     * @return \Illuminate\Http\Response
     */
    public function destroy(DEPLACEMENTS $dEPLACEMENTS)
    {
        //
    }
}
