<?php

namespace App\Http\Controllers;

use App\Enums\MessageType;
use App\Models\Coordination;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Http\Requests\ForwardRequest;
use App\Http\Requests\CoordinationRequest;
use App\Services\User\UserServiceInterface;
use App\Services\Coordination\CoordinationServiceInterface;
use App\Services\ForwardCoordination\ForwardCoordinationService;
use Illuminate\Support\Facades\Auth;

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

        $this->middleware('permission:view.coordination')->only('index');
        $this->middleware('permission:create.coordination')->only(['create', 'store']);
        $this->middleware('permission:edit.coordination')->only(['edit', 'update']);
        $this->middleware('permission:delete.coordination')->only('destroy');
        $this->middleware('permission:fetch.coordination')->only('fetchCoordination');
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
        $messageType = $request->query('messageType', 'received');

        $this->coordinationService->storeCoordination($request->all());
        return redirect()->route('coordination.index', ['messageType' => $messageType])
            ->with('success', 'Sukses menambah koordinasi');
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
        return view('coordination.edit', compact('coordination', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CoordinationRequest $request, Coordination $coordination)
    {
        $this->authorize('update', $coordination);
        $messageType = $request->query('messageType', 'received');
        $this->coordinationService->editCoordination($coordination, $request->all());
        return redirect()->route('coordination.index', ['messageType' => $messageType])->with('success', 'Sukses Mengubah Koordinasi');
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


    public function fetchCoordination(Request $request)
    {
        $search = $request->input('search', '');
        $messageType = MessageType::All;
        $userId = Auth::id();


        $coordinations = $this->coordinationService->getAllCoordination(
            $search,
            10,
            $messageType,
            false
        )->filter(function ($coordination) use ($userId) {
            return $coordination->sender_id == $userId
                || $coordination->receiver_id == $userId
                || $coordination->forwardedUsers->contains('id', $userId);
        });

        $results = $coordinations->map(function ($instruction) {
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
