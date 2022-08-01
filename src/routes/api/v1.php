<?php

use App\Http\Controllers\API\V1\AuthController;
use App\Http\Controllers\API\V1\ProjectController;
use App\Http\Controllers\API\V1\TaskController;
use App\Http\Controllers\API\V1\TestController;
use App\Models\UserRole;
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

Route::group(['as' => 'auth.'], static function () {
    Route::post('register/{type}', [AuthController::class, 'register'])
        ->name('register');
//        ->where('type', implode('|', array_column(UserRole::cases(), 'values')));
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::get('logout', [AuthController::class, 'logout'])
        ->name('logout')->middleware('auth:sanctum');
});

Route::group(['middleware' => 'auth:sanctum'], static function () {
    Route::group(['as' => 'projects.', 'prefix' => 'projects'], static function () {
        Route::get('statuses', [ProjectController::class, 'getStatuses'])->name('statuses');
        Route::get('/', [ProjectController::class, 'all'])->name('all');
        Route::get('/{id}', [ProjectController::class, 'getById'])->name('get-by-id')->where(['id' => '[0-9]+']);
        Route::post('/', [ProjectController::class, 'store'])->name('store');
        Route::put('/{id}', [ProjectController::class, 'update'])->name('update');
    });
    Route::group(['as' => 'tasks.', 'prefix' => 'tasks'], static function () {
        Route::get('/', [TaskController::class, 'all'])->name('all');
        Route::get('/{id}', [TaskController::class, 'getById'])->name('get-by-id')->where(['id' => '[0-9]+']);
        Route::post('/', [TaskController::class, 'store'])->name('store');
        Route::put('/{id}', [TaskController::class, 'update'])->name('update');
    });
});
