<?php

use App\Http\Controllers\CoordinationController;
use App\Http\Controllers\FollowupCoordinationController;
use App\Http\Controllers\ForwardCoordinationController;
use App\Http\Controllers\ForwardFollowupCoordinationController;
use App\Http\Controllers\ForwardFollowupInstructionController;
use App\Http\Controllers\ForwardInstructionController;
use App\Http\Controllers\InstructionController;
use App\Http\Controllers\InstructionScoreController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FollowupInstructionController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::redirect('/', 'login');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Forward Instruction
    Route::get('/forward/instruction/{instruction}', [ForwardInstructionController::class, 'showForm'])
        ->name('forward.instruction.form');
    Route::get('/forward/coordination/{coordination}', [ForwardCoordinationController::class, 'showForm'])
        ->name('forward.coordination.form');
    Route::get('/forward/followupinstruction/{followupinstruction}', [ForwardFollowupInstructionController::class, 'showForm'])
        ->name('forward.followupinstruction.form');
    Route::get('/forward/followupcoordination/{coordination}', [ForwardFollowupCoordinationController::class, 'showForm'])
        ->name('forward.followupcoordination.form');
    Route::get('/instructions/search', [InstructionController::class, 'fetchInstruction'])
        ->name('instructions.search');
    Route::get('/coordinations/search', [CoordinationController::class, 'fetchCoordination'])
        ->name('coordinations.search');

    Route::post('/forward/instruction/{instruction}', [ForwardInstructionController::class, 'submit'])
        ->name('forward.instruction.submit');
    Route::post('/forward/coordination/{coordination}', [ForwardCoordinationController::class, 'submit'])
        ->name('forward.coordination.submit');
    Route::post('/forward/followup/{followupinstruction}', [ForwardFollowupInstructionController::class, 'submit'])
        ->name('forward.followupinstruction.submit');
    Route::post('/forward/followup/{followupcoordination}', [ForwardFollowupCoordinationController::class, 'submit'])
        ->name('forward.followupcoordination.submit');

    Route::resource('permission', PermissionController::class);
    Route::resource('role', RoleController::class);
    Route::resource('user', UserController::class);
    Route::resource('instruction', InstructionController::class);
    Route::resource('coordination', CoordinationController::class);
    Route::resource('followupinstruction', FollowupInstructionController::class);
    Route::resource('instructionscore', InstructionScoreController::class);

});
