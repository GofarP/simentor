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

        $this->middleware('permission:showform.forwardfollowupcoordination')->only('showform');
        $this->middleware('permission:submit.forwardfollowupcoordination')->only('submit');
    }

    public function showForm(FollowupCoordination $followupCoordination)
    {
        $this->authorize('forward', $followupCoordination);
        $users = $this->userService->getReceiver();
        $forwardFollowupCoordination = $this->forwardFollowupCoordinationService
            ->getForwardFollowupCoordination($followupCoordination)
            ->pluck('forwarded_to')
            ->toArray();

        return view('followupcoordination.forward', compact('forwardFollowupCoordination', 'users'));
    }


    public function submit(ForwardRequest $request, FollowupCoordination $followupCoordination)
    {
        $this->authorize('forward', $followupCoordination);
        $this->forwardFollowupCoordinationService->forwardFollowupCoordination($followupCoordination, $request->all());
        return redirect()->route('followupcoordination.index')->with('success', 'Sukses meneruskan tindak lanjut koordinasi');
    }
}
