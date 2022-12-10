<?php

use App\Http\Controllers\GamesController;
use App\Http\Controllers\SessionsController;
use Illuminate\Support\Facades\Route;

/*
{
    "name": "ma nouvelle session"
}
 */
Route::post("/sessions", [SessionsController::class, "create"]);

/*
{
	"text": "La bonne blague",
	"goodAnswer": "oui oui",
	"badAnswer1": "mauvaise réponse 1",
	"badAnswer2": "mauvaise réponse 2",
	"badAnswer3": "mauvaise réponse 3"
}
 */
Route::post("/sessions/{id}/questions", [SessionsController::class, "addQuestion"]);
Route::get("/sessions", [SessionsController::class, "list"]);
Route::get("/sessions/{id}", [SessionsController::class, "show"]);

/*
 {
	"session": "9b6368bd-3c58-438c-8057-134ecff013a0",
	"player": "un joueur"
}
 */
Route::post("/games", [GamesController::class, "start"]);
Route::get("/games", [GamesController::class, "list"]);
Route::get("/games/{id}", [GamesController::class, "get"]);
Route::get("/games/{id}/current-question", [GamesController::class, "currentQuestion"]);
Route::get("/games/{id}/jokers", [GamesController::class, "jokers"]);
Route::get("/games/{id}/fifty-fifty", [GamesController::class, "fiftyFifty"]);

/*
{
	"answer": "oui"
}
 */
Route::post("/games/{id}/guess", [GamesController::class, "guess"]);
