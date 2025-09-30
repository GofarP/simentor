<?php

namespace App\Http\Controllers;

use App\Models\instruksi;
use App\Services\Instruksi\InstruksiServiceInterface;
use Illuminate\Http\Request;

class InstruksiController extends Controller
{

    private InstruksiServiceInterface $instruksiServiceInterface;

    public function __construct(InstruksiServiceInterface $instruksiServiceInterface) {
        $this->instruksiServiceInterface=$instruksiServiceInterface;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('instruksi.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('instruksi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(instruksi $instruksi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(instruksi $instruksi)
    {
        return view('instruksi.edit',compact('instruksi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, instruksi $instruksi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(instruksi $instruksi)
    {
        //
    }
}
