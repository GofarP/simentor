<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForwardRequest;
use App\Models\FollowupInstruction;
use App\Models\ForwardFollowupInstruction;
use App\Models\ForwardInstruction;
use App\Services\ForwardFollowupInstruction\ForwardFollowupInstructionServiceInterface;
use App\Services\User\UserServiceInterface;
use Illuminate\Http\Request;

class ForwardFollowupInstructionController extends Controller
{
    private ForwardFollowupInstructionServiceInterface $forwardFollowupInstructionService;
    private UserServiceInterface $userService;

    public function __construct(
        ForwardFollowupInstructionServiceInterface $forwardFollowupInstructionService,
        UserServiceInterface $userService
    ) {
        $this->forwardFollowupInstructionService = $forwardFollowupInstructionService;
        $this->userService = $userService;

        $this->middleware('permission:showform.forwardfollowupcoordination')->only('showform');
        $this->middleware('permission:submit.forwardfollowupcoordination')->only('submit');
    }

    public function showForm(FollowupInstruction $followupinstruction)
    {
        $this->authorize('forward', $followupinstruction);
        $users = $this->userService->getReceiver();
        $forwardFollowupInstruction = $this->forwardFollowupInstructionService
            ->getForwardFollowupInstruction($followupinstruction)
            ->pluck('forwarded_to')
            ->toArray();

        return view('followupinstruction.forward', compact("followupinstruction",'forwardFollowupInstruction', 'users'));
    }


    public function submit(ForwardRequest $request, FollowupInstruction $followupinstruction)
    {
        $this->authorize('forward', $followupinstruction);
        $this->forwardFollowupInstructionService->forwardFollowupInstruction($followupinstruction, $request->all());
        return redirect()->route('followupinstruction.index')->with('success', 'Sukses meneruskan tindak lanjut instruksi');
    }
}
