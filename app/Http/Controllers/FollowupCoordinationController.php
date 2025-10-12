<?php

namespace App\Http\Controllers;

use App\Enums\MessageType;
use App\Http\Requests\FollowupCoordinationRequest;
use App\Models\FollowupCoordination;
use App\Models\FollowupInstruction;
use App\Services\Coordination\CoordinationServiceInterface;
use App\Services\FollowupCoordination\FollowupCoordinationService;
use App\Services\FollowupCoordination\FollowupCoordinationServiceInterface;
use Illuminate\Http\Request;

class FollowupCoordinationController extends Controller
{
    private FollowupCoordinationServiceInterface $followupCoordinationService;
    private CoordinationServiceInterface $coordinationService;

    public function __construct(FollowupCoordinationServiceInterface $followupCoordinationService, CoordinationServiceInterface $coordinationService)
    {
        $this->followupCoordinationService = $followupCoordinationService;
        $this->coordinationService = $coordinationService;

        // $this->middleware('permission:view.followupcoordination')->only('index');
        // $this->middleware('permission:create.followupcoordination')->only(['create', 'store']);
        // $this->middleware('permission:show.followupcoordination')->only('show');
        // $this->middleware('permission:edit.followupcoordination')->only(['edit', 'update']);
        // $this->middleware('permission:delete.followupcoordination')->only('destroy');

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('followupcoordination.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $coordinationId = session('selectedCoordinationId');
        $coordinations = $this->coordinationService->getAllCoordination(null, 10, MessageType::All, false);
        return view('followupcoordination.create', compact('coordinations', 'coordinationId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FollowupCoordinationRequest $request)
    {
        $data = $request->validated();
        $data['receiver_id'] = $this->coordinationService->getSenderIdByCoordination($data['coordination_id']);

        $this->followupCoordinationService->storeFollowupCoordination($data);
        session()->forget('selectedCoordinationId');
        return redirect()
            ->route('followupcoordination.index')
            ->with('success', 'Sukses menambah tindak lanjut koordinasi');
    }

    /**
     * Display the specified resource.
     */
    public function show(FollowupCoordination $followupcoordination)
    {
        return view('followupcoordination.show', compact('followupcoordination'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FollowupCoordination $followupcoordination)
    {
        $coordinations = $this->coordinationService->getAllCoordination(null, 10, MessageType::All, true);

        return view('followupcoordination.edit', compact('followupcoordination', 'coordinations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FollowupCoordination $followupcoordination)
    {
        $this->followupCoordinationService->editFollowupCoordination($followupcoordination, $request->all());
        return redirect()->route('followupcoordination.index')->with('success', 'Sukses mengubah tindak lanjut koordinasi');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FollowupCoordination $followupcoordination)
    {
        $this->followupCoordinationService->deleteFollowupCoordination($followupcoordination);
        return redirect()->route('followupcoordination.index')->with('success', 'Sukses menghapus tindak lanjut koordinasi');
    }
}
