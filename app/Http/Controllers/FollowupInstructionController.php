<?php

namespace App\Http\Controllers;

use App\Enums\MessageType;
use App\Models\FollowupInstruction;
use App\Http\Controllers\Controller;
use App\Http\Requests\FollowupInstructionRequest;
use App\Services\Instruction\InstructionServiceInterface;
use App\Services\FollowupCoordination\FollowupCoordinationServiceInterface;
use App\Services\FollowupInstruction\FollowupInstructionServiceInterface;
use Illuminate\Support\Facades\Request;

class FollowupInstructionController extends Controller
{
    private FollowupInstructionServiceInterface $followupInstructionServiceInterface;
    private InstructionServiceInterface $InstructionServiceInterface;


    public function __construct(FollowupInstructionServiceInterface $FollowupInstructionServiceInterfaceInterface, InstructionServiceInterface $InstructionServiceInterface)
    {
        $this->followupInstructionServiceInterface = $FollowupInstructionServiceInterfaceInterface;
        $this->InstructionServiceInterface = $InstructionServiceInterface;

        // $this->middleware('permission:view.followupinstruction')->only('index');
        // $this->middleware('permission:create.followupinstruction')->only(['create', 'store']);
        // $this->middleware('permission:show.followupinstruction')->only('show');
        // $this->middleware('permission:edit.followupinstruction')->only(['edit', 'update']);
        // $this->middleware('permission:delete.followupinstruction')->only('destroy');
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
        $instructions = $this->InstructionServiceInterface->getAllInstruction(null, 10, MessageType::All, true);
        return view('followupinstruction.create', compact('instructions', 'instructionId'));
    }

    /**
     * Store a newly pcreated resource in storage.
     */
    public function store(FollowupInstructionRequest $request)
    {
        $data = $request->validated();

        $data['receiver_id'] = $this->InstructionServiceInterface->getSenderIdByInstruction($data['instruction_id']);

        $this->followupInstructionServiceInterface->storeFollowupInstruction($data);

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
        $instructions = $this->InstructionServiceInterface->getAllInstruction(null, 10, MessageType::All, true);
        return view('followupinstruction.edit', compact('followupinstruction', 'instructions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FollowupInstructionRequest $request, FollowupInstruction $followupinstruction)
    {
        $this->followupInstructionServiceInterface->editFollowupInstruction($followupinstruction, $request->all());
        return redirect()->route('followupinstruction.index')->with('success', 'Sukses mengubah tindak lanjut instruksi');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FollowupInstruction $followupinstruction)
    {
        $this->followupInstructionServiceInterface->deleteFollowupInstruction($followupinstruction);
        return redirect()->route('instruction.index')->with('success', 'Sukses menghapus instruction');
    }
}
