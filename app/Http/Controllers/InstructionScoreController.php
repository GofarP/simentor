<?php

namespace App\Http\Controllers;

use App\Http\Requests\InstructionRequest;
use App\Http\Requests\InstructionScoreRequest;
use App\Models\InstructionScore;
use App\Services\InstructionScore\InstructionScoreServiceInterface;
use Illuminate\Http\Request;

class InstructionScoreController extends Controller
{
    private InstructionScoreServiceInterface $instructionScoreService;

    public function __construct(InstructionScoreServiceInterface $instructionScoreService) {
        $this->instructionScoreService = $instructionScoreService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("instructionscore.index");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('instructionscore.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InstructionScoreRequest $request)
    {
        $this->instructionScoreService->storeInstructionScore($request->validated());
        return redirect()->route('instructionscore.index')->with('success','Sukses menambah penilaian instruksi');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InstructionScore $instructionscore)
    {
        $instructionTitle=$instructionscore->instruction->title;
        return view('instructionscore.edit',compact('instructionscore','instructionTitle'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(InstructionScoreRequest $request, InstructionScore $instructionscore)
    {
        $this->instructionScoreService->editInstructionScore($instructionscore, $request->validated());

        return redirect()->route('instructionscore.index')->with('success','Sukses mengubah nilai instruksi');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InstructionScore $instructionScore)
    {
        $this->instructionScoreService->deleteInstructionScore($instructionScore);

        return redirect('instructionscore.index')->with('success','Sukses menghapus nilai instruksi');
    }
}
