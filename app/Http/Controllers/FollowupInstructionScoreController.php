<?php

namespace App\Http\Controllers;

use App\Enums\MessageType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\FollowupInstructionScore;
use App\Services\FollowupInstruction\FollowupInstructionServiceInterface;
use App\Services\FollowupInstructionScore\FollowupInstructionScoreServiceInterface;


class FollowupInstructionScoreController extends Controller
{
    private FollowupInstructionServiceInterface $followupInstructionService;
    private FollowupInstructionScoreServiceInterface $followupInstructionScoreService;


    public function __construct(
        FollowupInstructionServiceInterface $followupInstructionService,
        FollowupInstructionScoreServiceInterface $followupInstructionScoreService,
    ) {
        $this->followupInstructionService = $followupInstructionService;
        $this->followupInstructionScoreService = $followupInstructionScoreService;

    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('followupinstructionscore.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $followupInstructionId = session('selectedFollowupInstructionId');
        $followupInstructions=$this->followupInstructionService->getAll(null, MessageType::All,10, false);
        return view('followupinstructionscore.create', compact('instructions', 'instructionId'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FollowupInstructionScoreRequest $request)
    {
        $data=$request->validated();
        $data['user_id']=Auth::id();
        $this->followupInstructionScoreService->storeFollowupInstructionScore($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FollowupInstructionScore $followupInstructionScore)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FollowupInstructionScoreRequest $request, FollowupInstructionScore $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
