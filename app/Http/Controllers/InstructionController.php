<?php

namespace App\Http\Controllers;

use App\Http\Requests\InstructionRequest;
use App\Models\Instruction;
use App\Services\ForwardInstruction\ForwardInstructionServiceInterface;
use App\Services\Instruction\InstructionServiceInterface;
use App\Services\User\UserServiceInterface;
use App\Enums\MessageType;
use Illuminate\Http\Request;


class InstructionController extends Controller
{

    private InstructionServiceInterface $instructionService;
    private UserServiceInterface $userService;
    private ForwardInstructionServiceInterface $forwardInstructionService;


    public function __construct(
        InstructionServiceInterface $instructionService,
        UserServiceInterface $userService,
        ForwardInstructionServiceInterface $forwardInstructionService
    ) {
        $this->instructionService = $instructionService;
        $this->userService = $userService;
        $this->forwardInstructionService = $forwardInstructionService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('instruction.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('instruction.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InstructionRequest $request)
    {
        $this->instructionService->storeInstruction($request->all());
        return redirect()->route('instruction.index')->with('success', 'Sukses menambah instruction');
    }

    /**
     * Display the specified resource.
     */
    public function show(Instruction $instruction)
    {
        $this->authorize('view', $instruction);
        return view('instruction.show', compact('instruction'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Instruction $instruction)
    {
        $this->authorize('update', $instruction);

        $users = $this->userService->getReceiver();

        return view('instruction.edit', compact('instruction', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(InstructionRequest $request, Instruction $instruction)
    {
        $this->authorize('update', $instruction);
        $this->instructionService->editInstruction($instruction, $request->all());
        return redirect()->route('instruction.index')->with('success', 'Sukses mengubah instruction');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Instruction $instruction)
    {
        $this->authorize('delete', $instruction);
        $this->instructionService->deleteInstruction($instruction);
        $this->forwardInstructionService->deleteForwardInstruction($instruction);
        return redirect()->route('instruction.index')->with('success', 'Sukses menghapus instruction');
    }


    public function fetchInstruction(Request $request)
    {
        $search = $request->input('search', '');
        $messageType = MessageType::All;

        // Panggil service yang ujungnya akan pakai repository
        $instructions = $this->instructionService->getAllInstruction(
            $search,
            10,
            $messageType,
            false
        );

        // Format hasil untuk Select2
        $results = $instructions->map(function ($instruction) {
            return [
                'id' => $instruction->id,
                'title' => $instruction->title,
            ];
        });

        return response()->json(['results' => $results]);
    }


}
