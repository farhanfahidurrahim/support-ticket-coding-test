<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', [TicketController::class, 'index'])->name('dashboard');
    Route::get('/create', [TicketController::class, 'create'])->name('ticket.create');
    Route::post('/store', [TicketController::class, 'store'])->name('ticket.store');
    Route::get('/show/{id}', [TicketController::class, 'show'])->name('ticket.open');
    Route::patch('/issues', [TicketController::class, 'issues'])->name('ticket.issues');
    Route::patch('/ticket/issues-respond/{id}', [TicketController::class, 'issuesRespond'])->name('ticket.issuesRespond');
    Route::post('/ticket/status-change/{id}', [TicketController::class, 'statusChange'])->name('ticket.statusChange');
});

require __DIR__ . '/auth.php';
