<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForwardRequest;
use App\Http\Requests\InstructionRequest;
use App\Models\Instruction;
use App\Services\Instruction\InstructionServiceInterface;
use App\Services\User\UserServiceInterface;
use Illuminate\Http\Request;

class InstructionController extends Controller
{

    private InstructionServiceInterface $instructionService;
    private UserServiceInterface $userService;


    public function __construct(InstructionServiceInterface $instructionService, UserServiceInterface $userService) {
        $this->instructionService=$instructionService;
        $this->userService=$userService;

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
        $users = $this->userService->getReceiver();
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
        $this->authorize('delete',$instruction);
        $this->instructionService->deleteInstruction($instruction);
        return redirect()->route('instruction.index')->with('success', 'Sukses menghapus instruction');
    }

    public function forward(Instruction $instruction){
        $this->authorize('forward',$instruction);
        $users=$this->userService->getReceiver();
        return view('instruction.forward',compact('instruction','users'));
    }


    public function forwardInstruction(ForwardRequest $request, Instruction $instruction){
        $this->instructionService->forwardInstruction($instruction)
    }
}
