<?php

namespace App\Http\Controllers;

use App\Http\Requests\InstruksiRequest;
use App\Models\instruksi;
use App\Services\Instruksi\InstruksiServiceInterface;
use App\Services\User\UserServiceInterface;
use Illuminate\Http\Request;

class InstruksiController extends Controller
{

    private InstruksiServiceInterface $instruksiService;
    private UserServiceInterface $userService;


    public function __construct(InstruksiServiceInterface $instruksiService, UserServiceInterface $userService)
    {
        $this->instruksiService = $instruksiService;
        $this->userService = $userService;
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
        $users = $this->userService->getPenerima();
        return view('instruksi.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InstruksiRequest $request)
    {
        $this->instruksiService->storeInstruksi($request->all());
        return redirect()->route('instruksi.index')->with('success', 'Sukses menambah instruksi');
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
        $users = $this->userService->getPenerima();

        return view('instruksi.edit', compact('instruksi', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(InstruksiRequest $request, instruksi $instruksi)
    {
        $this->instruksiService->editInstruksi($instruksi, $request->all());
        return redirect()->route('instruksi.index')->with('success', 'Sukses mengubah instruksi');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(instruksi $instruksi)
    {
        $this->instruksiService->deleteInstruksi($instruksi);
        return redirect()->route('instruksi.index')->with('success', 'Sukses menghapus instruksi');
    }
}
