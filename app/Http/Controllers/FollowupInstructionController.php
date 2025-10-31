<?php

namespace App\Http\Controllers;

use App\Enums\MessageType;
use App\Models\FollowupInstruction;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use App\Http\Requests\FollowupInstructionRequest;
use App\Services\Instruction\InstructionServiceInterface;
use App\Services\FollowupInstruction\FollowupInstructionServiceInterface;
use App\Services\FollowupCoordination\FollowupCoordinationServiceInterface;

class FollowupInstructionController extends Controller
{
    private FollowupInstructionServiceInterface $followupInstructionService;
    private InstructionServiceInterface $InstructionService;


    public function __construct(FollowupInstructionServiceInterface $FollowupInstructionService, InstructionServiceInterface $InstructionServiceInterface)
    {
        $this->followupInstructionService = $FollowupInstructionService;
        $this->InstructionService = $InstructionServiceInterface;

        $this->middleware('permission:view.followup-instruction')->only('index');
        $this->middleware('permission:create.followup-instruction')->only(['create', 'store']);
        $this->middleware('permission:show.followup-instruction')->only('show');
        $this->middleware('permission:edit.followup-instruction')->only(['edit', 'update']);
        $this->middleware('permission:delete.followup-instruction')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('followupinstruction.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $instructionId = session('selectedInstructionId');
        $instructions = $this->InstructionService->getAllInstructions(null, 10, MessageType::All, true);
        return view('followupinstruction.create', compact('instructions', 'instructionId'));
    }

    /**
     * Store a newly pcreated resource in storage.
     */
    public function store(FollowupInstructionRequest $request)
    {
        $data = $request->validated();
        $data['sender_id'] = Auth::id();
        if ($request->hasFile('attachment')) {
            $data['attachment'] = $request->file('attachment')->store('attachment', 'public');
        }
        if ($request->hasFile('proof')) {
            $data['proof'] = $request->file('proof')->store('proof', 'public');
        }

        try {
            $this->followupInstructionService->storeFollowupInstruction($data);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        session()->forget('selectedInstructionId');
        return redirect()
            ->route('followupinstruction.index')
            ->with('success', 'Sukses menambah tindak lanjut instruksi');
    }



    /**
     * Display the specified resource.
     */
    public function show(FollowupInstruction $followupinstruction)
    {
        return view('followupinstruction.show', compact('followupinstruction'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FollowupInstruction $followupinstruction)
    {
        $this->authorize('update', $followupinstruction);
        $instructions = $this->InstructionService->getAllInstructions(null, 10, MessageType::All, true);
        return view('followupinstruction.edit', compact('followupinstruction', 'instructions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FollowupInstructionRequest $request, FollowupInstruction $followupinstruction)
    {
        $this->authorize('update', $followupinstruction);
        $data = $request->validated();
        $this->followupInstructionService->editFollowupInstruction($followupinstruction, $data);

        return redirect()
            ->route('followupinstruction.index')
            ->with('success', 'Tindak lanjut berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FollowupInstruction $followupinstruction)
    {
        $this->authorize('delete', $followupinstruction);
        $this->followupInstructionService->deleteFollowupInstruction($followupinstruction);
        return redirect()->route('instruction.index')->with('success', 'Sukses menghapus instruction');
    }
}
