<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EscapeRoomController;
use App\Http\Controllers\RallyController; // Tambahkan ini
use App\Http\Controllers\ScoreController;

// --- ROUTE UNTUK FRONTEND ---
Route::get('/', [RallyController::class, 'index'])->name('rally.index');

Route::get('/escape-room', [EscapeRoomController::class, 'index'])->name('escape.index');
Route::get('/rally', [RallyController::class, 'index'])->name('rally.index');

// Route Scoreboard yang benar (menerima parameter team)//GANTI POST, agar paramter tidak dibaca
Route::get('/scoreboard', function (Illuminate\Http\Request $request) {
    $teamName = $request->query('team', 'GUEST'); 
    return view('scoreboard', ['teamName' => $teamName]);
})->name('score.index');

// --- ROUTE UNTUK API ---
// API Rally (Gunakan ini di halaman Rally)
Route::get('/api/rally-teams', [RallyController::class, 'getTeamNames']);
Route::post('/api/rally-validate', [RallyController::class, 'checkCode'])->middleware('throttle:60,1');

// API Escape Room (Jika masih digunakan)
Route::get('/api/team-names', [EscapeRoomController::class, 'getTeamNames']);
Route::post('/api/validate-code', [EscapeRoomController::class, 'checkCode'])->middleware('throttle:60,1');