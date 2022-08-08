<?php

use App\Http\Controllers\API\V1\AuthController;
use App\Http\Controllers\API\V1\ProjectController;
use App\Http\Controllers\API\V1\ProjectStatusController;
use App\Http\Controllers\API\V1\TaskController;
use App\Http\Controllers\API\V1\TestController;
use App\Http\Controllers\API\V1\UserController;
use App\Models\Enums\UserPermission;
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
    Route::post('register', [AuthController::class, 'register'])
        ->name('register');
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('admin/login', [AuthController::class, 'adminLogin'])->name('admin.login');

    Route::get('logout', [AuthController::class, 'logout'])
        ->name('logout')->middleware('auth:sanctum');
});

Route::group(['middleware' => 'auth:sanctum'], static function () {
    Route::get('auth/check', [AuthController::class, 'check'])->name('check');

    /**
     * Project routes.
     */
    Route::group(['as' => 'projects.', 'prefix' => 'projects'], static function () {
        Route::get('statuses', [ProjectController::class, 'getStatuses'])
            ->name('statuses')
            ->middleware(setPermissions([UserPermission::PROJECT_STATUSES]));
        Route::get('/', [ProjectController::class, 'all'])->name('all')
            ->middleware(setPermissions([UserPermission::PROJECT_ALL]));
        Route::get('/{id}', [ProjectController::class, 'getById'])
            ->name('get-by-id')
            ->where(['id' => '[0-9]+'])
            ->middleware(setPermissions([UserPermission::PROJECT_SHOW]));
        Route::post('/', [ProjectController::class, 'store'])
            ->name('store')
            ->middleware(setPermissions([UserPermission::PROJECT_CREATE]));
        Route::put('/{id}', [ProjectController::class, 'update'])
            ->name('update')
            ->middleware(setPermissions([UserPermission::PROJECT_EDIT]));
        Route::delete('/{id}', [ProjectController::class, 'delete'])
            ->name('delete')
            ->middleware(setPermissions([UserPermission::PROJECT_DELETE]));
    });

    /**
     * Task routes.
     */
    Route::group(['as' => 'tasks.', 'prefix' => 'tasks'], static function () {
        Route::get('statuses', [TaskController::class, 'getStatuses'])
            ->name('statuses')
            ->middleware(setPermissions([UserPermission::TASK_STATUSES]));
        Route::get('/', [TaskController::class, 'all'])
            ->name('all')
            ->middleware(setPermissions([UserPermission::TASK_ALL]));
        Route::get('/{id}', [TaskController::class, 'getById'])
            ->name('get-by-id')
            ->where(['id' => '[0-9]+'])
            ->middleware(setPermissions([UserPermission::TASK_SHOW]));
        Route::post('/', [TaskController::class, 'store'])
            ->name('store')
            ->middleware(setPermissions([UserPermission::TASK_CREATE]));
        Route::put('/{id}', [TaskController::class, 'update'])->name('update')
            ->middleware(setPermissions([UserPermission::TASK_EDIT]));
        Route::delete('/{id}', [TaskController::class, 'delete'])->name('delete')
            ->middleware(setPermissions([UserPermission::TASK_DELETE]));
    });

    /**
     * User routes.
     */
    Route::group(['as' => 'users.', 'prefix' => 'users'], static function () {
        Route::get('/', [UserController::class, 'all'])->name('all')
            ->middleware(setPermissions([UserPermission::USER_ALL]));
        Route::get('employees', [UserController::class, 'employees'])->name('employees')
            ->middleware(setPermissions([UserPermission::EMPLOYEE_ALL]));
        Route::post('data', [UserController::class, 'getUserData'])->name('all');
    });
});
