<?php

use App\Http\Controllers\GamesController;
use App\Http\Controllers\SessionsController;
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

Route::post("/sessions", [SessionsController::class, "create"]);
Route::post("/sessions/{id}/questions", [SessionsController::class, "addQuestion"]);
Route::get("/sessions", [SessionsController::class, "list"]);
Route::get("/sessions/{id}", [SessionsController::class, "show"]);

Route::post("/games", [GamesController::class, "start"]);
Route::get("/games", [GamesController::class, "list"]);
Route::get("/games/{id}/current-question", [GamesController::class, "currentQuestion"]);
Route::get("/games/{id}/jokers", [GamesController::class, "jokers"]);
Route::get("/games/{id}/fifty-fifty", [GamesController::class, "fiftyFifty"]);
Route::post("/games/{id}/guess", [GamesController::class, "guess"]);
