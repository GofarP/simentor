<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForwardRequest;
use App\Models\FollowupCoordination;
use App\Services\ForwardFollowupCoordination\ForwardFollowupCoordinationServiceInterface;
use App\Services\User\UserServiceInterface;

class ForwardFollowupCoordinationController extends Controller
{
    private ForwardFollowupCoordinationServiceInterface $forwardFollowupCoordinationService;
    private UserServiceInterface $userService;

    public function __construct(
        ForwardFollowupCoordinationServiceInterface $forwardFollowupCoordinationService,
        UserServiceInterface $userService
    ) {
        $this->forwardFollowupCoordinationService = $forwardFollowupCoordinationService;
        $this->userService = $userService;

        // $this->middleware('permission:showform.forwardfollowupcoordination')->only('showform');
        // $this->middleware('permission:submit.forwardfollowupcoordination')->only('submit');
    }

    public function showForm(FollowupCoordination $followupcoordination)
    {
        $this->authorize('forward', $followupcoordination);
        $users = $this->userService->getReceiver();
        $forwardFollowupCoordination = $this->forwardFollowupCoordinationService
            ->getForwardFollowupCoordination($followupcoordination)
            ->pluck('forwarded_to')
            ->toArray();

        return view('followupcoordination.forward', compact('forwardFollowupCoordination', 'users','followupcoordination'));
    }


    public function submit(ForwardRequest $request, FollowupCoordination $followupcoordination)
    {
        $this->authorize('forward', $followupcoordination);
        $this->forwardFollowupCoordinationService->forwardFollowupCoordination($followupcoordination, $request->all());
        return redirect()->route('followupcoordination.index')->with('success', 'Sukses meneruskan tindak lanjut koordinasi');
    }
}
