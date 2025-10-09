<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Enums\MessageType;
use App\Models\Instruction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\InstructionRequest;
use App\Services\User\UserServiceInterface;
use App\Services\Instruction\InstructionServiceInterface;
use App\Services\ForwardInstruction\ForwardInstructionServiceInterface;


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

        // $this->middleware('permission:view.instruction')->only('index');
        // $this->middleware('permission:create.instruction')->only(['create', 'store']);
        // $this->middleware('permission:edit.instruction')->only(['edit', 'update']);
        // $this->middleware('permission:show.instruction')->only('show');
        // $this->middleware('permission:delete.instruction')->only('destroy');
        // $this->middleware('permission:fetch.instruction')->only('fetchInstruction');

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
        $this->authorize('delete', $instruction);
        $this->instructionService->deleteInstruction($instruction);
        $this->forwardInstructionService->deleteForwardInstruction($instruction);
        return redirect()->route('instruction.index')->with('success', 'Sukses menghapus instruction');
    }


    public function fetchInstruction(Request $request)
    {
        $search = $request->input('search', '');
        $messageType = MessageType::All;
        $userId = Auth::id();

        $instructions = $this->instructionService->getAllInstruction(
            $search,
            10,
            $messageType,
            false
        )->filter(function ($instruction) use ($userId) {
            return $instruction->sender_id == $userId
                || $instruction->receiver_id == $userId
                || $instruction->forwardedUsers->contains('id', $userId);
        });

        $results = $instructions->map(function ($instruction) {
            $isExpired = false;
            if ($instruction->end_time) {
                try {
                    $isExpired = Carbon::parse($instruction->end_time)->isPast();
                } catch (\Exception $e) {
                }
            }

            return [
                'id' => $instruction->id,
                'title' => $instruction->title,
                'end_time' => $instruction->end_time,
                'is_expired' => $isExpired,
            ];
        });

        return response()->json(['results' => $results]);
    }
}
