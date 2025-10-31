<?php

namespace App\Http\Controllers;

use App\Enums\MessageType;
use Illuminate\Http\Request;
use App\Models\FollowupInstruction;
use App\Http\Controllers\Controller;
use App\Models\FollowupCoordination;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\FollowupCoordinationRequest;
use App\Services\Coordination\CoordinationServiceInterface;
use App\Services\FollowupCoordination\FollowupCoordinationService;
use App\Services\FollowupCoordination\FollowupCoordinationServiceInterface;

class FollowupCoordinationController extends Controller
{
    private FollowupCoordinationServiceInterface $followupCoordinationService;
    private CoordinationServiceInterface $coordinationService;

    public function __construct(FollowupCoordinationServiceInterface $followupCoordinationService, CoordinationServiceInterface $coordinationService)
    {
        $this->followupCoordinationService = $followupCoordinationService;
        $this->coordinationService = $coordinationService;

        $this->middleware('permission:view.followup-coordination')->only('index');
        $this->middleware('permission:create.followup-coordination')->only(['create', 'store']);
        $this->middleware('permission:show.followup-coordination')->only('show');
        $this->middleware('permission:edit.followup-coordination')->only(['edit', 'update']);
        $this->middleware('permission:delete.followup-coordination')->only('destroy');
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
        $coordinations = $this->coordinationService->getAllCoordinations(null, 10, MessageType::All, false);
        return view('followupcoordination.create', compact('coordinations', 'coordinationId'));
    }

    
    public function store(FollowupCoordinationRequest $request)
    {
        $data = $request->validated();
        $data['sender_id'] = Auth::id();
        if ($request->hasFile('attachment')) {
            $data['attachment'] = $request->file('attachment')->store('attachment', 'public');
        }
        if ($request->hasFile('proof')) {
            $data['proof'] = $request->file('proof')->store('proof', 'public');
        }

        try {
            $this->followupCoordinationService->storeFollowupCoordination($data);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        session()->forget('selectedCoordinationId');
        return redirect()
            ->route('followupinstruction.index')
            ->with('success', 'Sukses menambah tindak lanjut koordinasi');
    }

    
    public function show(FollowupCoordination $followupcoordination)
    {
        return view('followupcoordination.show', compact('followupcoordination'));
    }

    
    public function edit(FollowupCoordination $followupcoordination)
    {
        $this->authorize('update', $followupcoordination);
        $coordinations = $this->coordinationService->getAllCoordinations(null, 10, MessageType::All, true);
        return view('followupcoordination.edit', compact('followupinstruction', 'coordinations'));
    }

    
    public function update(Request $request, FollowupCoordination $followupcoordination)
    {
        $this->authorize('update', $followupcoordination);
        $data = $request->validated();
        $this->followupCoordinationService->editFollowupCoordination($followupcoordination, $data);

        return redirect()
            ->route('followupcoordination.index')
            ->with('success', 'Tindak lanjut koordinasi berhasil diperbarui.');
    }

    
    public function destroy(FollowupCoordination $followupcoordination)
    {
        $this->authorize('delete', $followupcoordination);

        $this->followupCoordinationService->deleteFollowupCoordination($followupcoordination);
        return redirect()->route('followupcoordination.index')->with('success', 'Sukses menghapus tindak lanjut koordinasi');
    }
}
