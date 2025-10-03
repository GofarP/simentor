<?php

use App\Http\Controllers\CoordinationController;
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
    Route::get('/teruskaninstruksi/{instruction}', [ForwardInstructionController::class, 'forward'])->name('forwardinstruction.forward');
    Route::get('/teruskankoordinasi/{coordination}', [CoordinationController::class, 'forward'])->name('coordination.forward');

    Route::post('/teruskaninstruksi/{instruction}',[InstructionController::class,'forwardInstruction'])->name('forwardinstruction.forwardinstruction');
    Route::post('/teruskankoordinasi/{coordination}',[CoordinationController::class,'forwardCoordination'])->name('coordination.forwardcoordination');

    Route::resource('permission',PermissionController::class);
    Route::resource('role',RoleController::class);
    Route::resource('user',UserController::class);
    Route::resource('instruction',InstructionController::class);
    Route::resource('coordination',CoordinationController::class);

});
