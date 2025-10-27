<?php

namespace App\Http\Controllers;

use App\Models\ForwardInstruction;
use App\Models\Instruction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ForwardRequest;
use App\Services\ForwardInstruction\ForwardInstructionServiceInterface;
use App\Services\User\UserServiceInterface;

class ForwardInstructionController extends Controller
{
    private ForwardInstructionServiceInterface $forwardInstructionService;
    private UserServiceInterface $userService;

    public function __construct(
        UserServiceInterface $userService,
        ForwardInstructionServiceInterface $forwardInstructionService
    ) {
        $this->userService = $userService;
        $this->forwardInstructionService = $forwardInstructionService;
        $this->middleware('permission:showform.forward-instruction')->only('showform');
        $this->middleware('permission:submit.forward-instruction')->only('submit');
    }

    public function showForm(Instruction $instruction)
    {
        $this->authorize('forward', $instruction);
        $users = $this->userService->getReceiver();
        $forwardInstruction = $this->forwardInstructionService
            ->getForwardInstruction($instruction)
            ->pluck('forwarded_to')
            ->toArray();
        return view('instruction.forward', compact('instruction', 'users', 'forwardInstruction'));
    }


    public function submit(ForwardRequest $request, Instruction $instruction)
    {
        $this->authorize('forward', $instruction);
        $this->forwardInstructionService->forwardInstruction($instruction, $request->all());
        return redirect()->route('instruction.index')->with('success', 'Sukses meneruskan instruksi');
    }
}
