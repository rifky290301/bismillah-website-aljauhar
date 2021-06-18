<?php

use App\Http\Controllers\AlumniController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



// Route::prefix('alumni')->group(function () {
//     Route::post('create-new-alumni', [AlumniController::class, 'store']);
//     // allNotes
//     Route::get('index', [AlumniController::class, 'getAlumni']);
//     // show
//     // Route::get('{note:slug}', [NoteController::class, 'show'])->name('notes.show');
//     // edit
//     // Route::patch('{note:slug}/edit', [NoteController::class, 'update']);
//     // delete
//     // Route::delete('{note:slug}/delete', [NoteController::class, 'destroy']);
// });
