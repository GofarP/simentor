<?php

namespace App\Http\Controllers;

use App\Models\Coordination;
use App\Http\Controllers\Controller;
use App\Http\Requests\ForwardRequest;
use App\Http\Requests\CoordinationRequest;
use App\Services\User\UserServiceInterface;
use App\Services\Coordination\CoordinationServiceInterface;
use App\Services\ForwardCoordination\ForwardCoordinationService;
use Illuminate\Http\Request;
use App\Enums\MessageType;

class CoordinationController extends Controller
{
    private CoordinationServiceInterface $coordinationService;

    private UserServiceInterface $userService;

    private ForwardCoordinationService $forwardCoordinationService;


    public function __construct(
        CoordinationServiceInterface $coordinationService,
        UserServiceInterface $userService,
        ForwardCoordinationService $forwardCoordinationService
    ) {
        $this->coordinationService = $coordinationService;
        $this->userService = $userService;
        $this->forwardCoordinationService = $forwardCoordinationService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('coordination.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = $this->userService->getReceiver();
        return view('coordination.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CoordinationRequest $request)
    {
        $this->coordinationService->storeCoordination($request->all());
        return redirect()->route('coordination.index')->with('success', 'Sukses menambah koordinasi');
    }

    /**
     * Display the specified resource.
     */
    public function show(Coordination $coordination)
    {
        $this->authorize('view', $coordination);
        return view('coordination.show', compact('coordination'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Coordination $coordination)
    {
        $this->authorize('update', $coordination);
        $users = $this->userService->getReceiver();
        return view('coordination.edit', compact('coordination'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CoordinationRequest $request, Coordination $coordination)
    {
        $this->authorize('update', $coordination);
        $this->coordinationService->editCoordination($coordination, $request->all());
        return redirect()->route('coordination.index')->with('success', 'Sukses Mengubah Koordinasi');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Coordination $coordination)
    {
        $this->authorize('delete', $coordination);
        $this->coordinationService->deleteCoordination($coordination);
        $this->forwardCoordinationService->deleteForwardCoordination($coordination);
        return redirect()->route('coordination.index')->with('success', 'Sukses menghapus koordinasi');
    }


    public function fetchCoordination(Request $request){
        $search=$request->input('search','');
        $messageType=MessageType::All;
        
        $coordinations=$this->coordinationService->getAllCoordination(
            $search,
            10,
            $messageType,
            false
        );

        $results=$coordinations->map(function($coordination){
            return[
                'id'=>$coordination->id,
                'title'=>$coordination
            ];
        });

        return response()->json(['results'=>$results]);
    }

}
