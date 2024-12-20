<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\BoardListController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\RoleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResources([
        'role' => RoleController::class,
        'board' => BoardController::class,
        'board-list' => BoardListController::class,
        'card' => CardController::class,
        'comment' => CommentController::class,
    ]);

    Route::post('logout', [AuthenticationController::class, 'logout']);
});

Route::prefix('auth')->controller(AuthenticationController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
});
