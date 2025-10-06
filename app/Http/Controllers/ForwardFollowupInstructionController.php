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
    ){
        $this->forwardFollowupInstructionService = $forwardFollowupInstructionService;
        $this->userService=$userService;
    }

    public function showForm(FollowupInstruction $followupInstruction)
    {
        $this->authorize('forward',$followupInstruction);
        $users=$this->userService->getReceiver();
        $forwardFollowupInstruction=$this->forwardFollowupInstructionService
        ->getForwardFollowupInstruction($followupInstruction)
        ->pluck('forwarded_to')
        ->toArray();

        return view('followupinstruction.forward',compact('forwardFollowupInstruction','users'));
    }


    public function submit(ForwardRequest $request, FollowupInstruction $followupInstruction){
        $this->authorize('forward',$followupInstruction);
        $this->forwardFollowupInstructionService->forwardFollowupInstruction($followupInstruction, $request->all());
        return redirect()->route('followupinstruction.index')->with('success','Sukses meneruskan tindak lanjut instruksi');
    }


}
