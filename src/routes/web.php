<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/test', [\App\Http\Controllers\API\V1\TestController::class, 'basicResponse']);

Route::any('/{any}', [DashboardController::class, 'index'])
    ->name('dashboard')->where('any', '.*');
//Route::any('/{any}', static fn () => redirect()->route('dashboard'));
