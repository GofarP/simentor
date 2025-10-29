<?php

namespace App\Http\Controllers;

use App\Enums\MessageType;
use App\Models\Instruction;
use Illuminate\Http\Request;
use App\Models\InstructionScore;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\InstructionRequest;
use App\Http\Requests\InstructionScoreRequest;
use App\Services\Instruction\InstructionServiceInterface;
use App\Services\InstructionScore\InstructionScoreServiceInterface;

class InstructionScoreController extends Controller
{
    private InstructionServiceInterface $instructionService;
    private InstructionScoreServiceInterface $instructionScoreService;


    public function __construct(
        InstructionServiceInterface $instructionService,
        InstructionScoreServiceInterface $instructionScoreService,
    ) {
        $this->instructionService = $instructionService;
        $this->instructionScoreService = $instructionScoreService;

        $this->middleware('permission:view.instruction-score')->only('index');
        $this->middleware('permission:create.instruction-score')->only(['create', 'store']);
        $this->middleware('permission:show.instruction-score')->only('show');
        $this->middleware('permission:edit.instruction-score')->only(['edit', 'update']);
        $this->middleware('permission:delete.instruction-score')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $instructionId = session('selectedInstructionId');
        $instructions = $this->instructionService->getAllInstruction(null, 10, MessageType::All, true);

        return view('instructionscore.create', compact('instructionId', 'instructions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InstructionScoreRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();
        $this->instructionScoreService->storeInstructionScore($data);

        return redirect()->route('followupinstructionscore.index')->with('success', 'Sukses menambahkan penilaian instruksi');
    }

    /**
     * Display the specified resource.
     */
    public function show(InstructionScore $instructionscore)
    {
        return view('instructionscore.show', compact('instructionscore'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InstructionScore $instructionscore)
    {
        $instructions = $this->instructionService->getAllInstruction(null, 10, MessageType::All, true);
        return view('instructionscore.edit', compact('instructions','instructionscore'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(InstructionScoreRequest $request, InstructionScore $instructionscore)
    {
        $validated = $request->validated();

        $validated['user_id'] = Auth::id();

        $this->instructionScoreService->editInstructionScore($instructionscore, $validated);

        return redirect()
            ->route('followupinstructionscore.index')
            ->with('success', 'Penilaian instruksi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InstructionScore $instructionscore)
    {
        $this->instructionScoreService->deleteInstructionScore($instructionscore);
        return redirect()->route('followupinstructionscore.index')->with('success', 'Sukses menghapus penilaian instruksi');
    }
}
