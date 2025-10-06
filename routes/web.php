<?php

use App\Http\Controllers\CoordinationController;
use App\Http\Controllers\ForwardCoordinationController;
use App\Http\Controllers\ForwardFollowupInstructionController;
use App\Http\Controllers\ForwardInstructionController;
use App\Http\Controllers\InstructionController;
use App\Http\Controllers\InstruksiController;
use App\Http\Controllers\UserController;
use App\Models\ForwardInstruction;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataFeedController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\FollowupInstructionController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Models\FollowupInstruction;

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

    Route::post('/forward/instruction/{instruction}', [ForwardInstructionController::class, 'submit'])
        ->name('forward.instruction.submit');
    Route::post('/forward/coordination/{coordination}', [ForwardCoordinationController::class, 'submit'])
        ->name('forward.coordination.submit');
    Route::post('/forward/followup/{followupinstruction}', [ForwardFollowupInstructionController::class, 'submit'])
        ->name('forward.followupinstruction.submit');

    Route::resource('permission', PermissionController::class);
    Route::resource('role', RoleController::class);
    Route::resource('user', UserController::class);
    Route::resource('instruction', InstructionController::class);
    Route::resource('coordination', CoordinationController::class);
    Route::resource('followupinstruction', FollowupInstructionController::class);


});
