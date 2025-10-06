<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForwardRequest;
use App\Models\Coordination;
use App\Models\ForwardCoordination;
use App\Services\ForwardCoordination\ForwardCoordinationServiceInterface;
use App\Services\User\UserServiceInterface;
use Illuminate\Http\Request;

class ForwardCoordinationController extends Controller
{
    private ForwardCoordinationServiceInterface $forwardCoordinationService;
    private UserServiceInterface $userService;


    public function __construct(
        UserServiceInterface $userService,
        ForwardCoordinationServiceInterface $forwardCoordinationService
    ) {
        $this->userService = $userService;
        $this->forwardCoordinationService = $forwardCoordinationService;
    }


    public function showForm(Coordination $coordination)
    {
        $this->authorize('forward',$coordination);
        $users=$this->userService->getReceiver();
        $forwardCoordination=$this->forwardCoordinationService
        ->getForwardCoordination($coordination)
        ->pluck('forwarded_to')
        ->toArray();

        return view('coordination.index',compact('coordination','users','forwardCoordination'));
    }

    public function submit(ForwardRequest $request, Coordination $coordination)
    {
        $this->authorize('forward', $coordination);
        $this->forwardCoordinationService->forwardCoordination($coordination, $request->all());
        return redirect()->route('coordination.index')->with('success', 'Sukses meneruskan instruksi');

    }
}
