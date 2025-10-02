<?php

namespace App\Http\Controllers;

use App\Http\Requests\CoordinationRequest;
use App\Models\Coordination;
use App\Services\Coordination\CoordinationServiceInterface;
use App\Services\User\UserServiceInterface;
use Illuminate\Http\Request;

class CoordinationController extends Controller
{
    private CoordinationServiceInterface $coordinationService;

    private UserServiceInterface $userService;

    public function __construct(CoordinationServiceInterface $coordinationService, UserServiceInterface $userService)
    {
        $this->coordinationService = $coordinationService;
        $this->userService = $userService;
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
        return redirect()->route('instruction.index')->with('success', 'Sukses menambah koordinasi');
    }

    /**
     * Display the specified resource.
     */
    public function show(Coordination $coordination)
    {
        $this->authorize('view', $coordination);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Coordination $coordination)
    {
        $this->authorize('update', $coordination);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CoordinationRequest $request, Coordination $coordination)
    {
        $this->authorize('update', $coordination);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Coordination $coordination)
    {
        $this->authorize('delete', $coordination);
        $this->coordinationService->deleteCoordination($coordination);
        return redirect()->route('instruction.index')->with('success', 'Sukses menghapus instruction');
    }
}
