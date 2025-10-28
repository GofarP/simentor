<?php

namespace App\Http\Controllers;

use App\Enums\MessageType;
use Illuminate\Http\Request;
use App\Models\FollowupInstruction;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\FollowupInstructionScore;
use App\Http\Requests\FollowupInstructionScoreRequest;
use App\Services\FollowupInstruction\FollowupInstructionServiceInterface;
use App\Services\FollowupInstructionScore\FollowupInstructionScoreServiceInterface;


class FollowupInstructionScoreController extends Controller
{
    private FollowupInstructionServiceInterface $followupInstructionService;
    private FollowupInstructionScoreServiceInterface $followupInstructionScoreService;


    public function __construct(
        FollowupInstructionServiceInterface $followupInstructionService,
        FollowupInstructionScoreServiceInterface $followupInstructionScoreService,
    ) {
        $this->followupInstructionService = $followupInstructionService;
        $this->followupInstructionScoreService = $followupInstructionScoreService;

        $this->middleware('permission:view.followup-instruction-score')->only('index');
        $this->middleware('permission:create.followup-instruction-score')->only(['create', 'store']);
        $this->middleware('permission:show.followup-instruction-score')->only('show');
        $this->middleware('permission:edit.followup-instruction-score')->only(['edit', 'update']);
        $this->middleware('permission:delete.followup-instruction-score')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('followupinstructionscore.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $followupInstructionId = session('selectedFollowupInstructionId');

        $followupInstruction = FollowupInstruction::with('instruction')
            ->find($followupInstructionId);
        return view('followupinstructionscore.create', compact('followupInstruction'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(FollowupInstructionScoreRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();
        $this->followupInstructionScoreService->storeFollowupInstructionScore($data);

        return redirect()->route('followupinstructionscore.index')->with('success', 'Sukses menambahkan penilaian tindak lanjut instruksi');
    }

    /**
     * Display the specified resource.
     */
    public function show(FollowupInstructionScore $followupinstructionscore)
    {
        return view('followupinstructionscore.show', compact('followupinstructionscore'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FollowupInstructionScore $followupinstructionscore)
    {
        $followupInstruction = $followupinstructionscore->followupInstruction;
        $instructionId = $followupInstruction->instruction_id;

        $followupInstructions = $this->followupInstructionService->getAll(
            $instructionId,
            null,
            MessageType::All,
            10,
            true
        );

        return view('followupinstructionscore.edit', compact('followupinstructionscore', 'followupInstructions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FollowupInstructionScoreRequest $request, FollowupInstructionScore $followupinstructionscore)
    {
        $validated = $request->validated();

        $this->authorize('update', $followupinstructionscore);

        $validated['user_id'] = Auth::id();

        $this->followupInstructionScoreService->editFollowupInstructionScore($followupinstructionscore, $validated);

        return redirect()
            ->route('followupinstructionscore.index')
            ->with('success', 'Penilaian tindak lanjut instruksi berhasil diubah.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FollowupInstructionScore $followupinstructionscore)
    {
        $this->followupInstructionScoreService->deleteFollowupInstructionScore($followupinstructionscore);
        return redirect()->route('followupinstructionscore.index')->with('success', 'Sukses menghapus penilaian tindak lanjut instruksi');
    }
}
