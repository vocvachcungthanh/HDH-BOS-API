<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlockController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\AccountTypeController;
use App\Http\Controllers\PostionController;
use App\Models\Department;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', [AuthController::class, 'login']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('logout', [AuthController::class, 'logout']);
});


Route::middleware(['auth'])->group(function () {
    Route::apiResources([
        'company' => CompanyController::class,
    ]);

    Route::middleware(['DatabaseConnection'])->group(function () {
        Route::apiResources([
            'block' => BlockController::class

        ]);

        Route::get('field', [FieldController::class, 'index']);

        Route::get('department', [DepartmentController::class, 'index']);
        Route::get('trash-department-list', [DepartmentController::class, 'getTrashDepartment']);
        Route::get('create-code-department', [DepartmentController::class, 'createAutoCode']);
        Route::get('trash-department-count', [DepartmentController::class, 'trashDepartemntCount']);
        Route::get('department-list', [DepartmentController::class, 'getListDepartment']);
        Route::post('department-update', [DepartmentController::class, 'update']);
        Route::post('department-create', [DepartmentController::class, 'create']);
        Route::post('delete-department', [DepartmentController::class, 'deleteDepartment']);
        Route::post('empty-department', [DepartmentController::class, 'emptyTrashDepartment']);
        Route::post('restore-department', [DepartmentController::class, 'restoreTranshDepartment']);
        Route::get('search-department/{keySearch}', [DepartmentController::class, 'searchDepartment']);

        Route::post('postions/{page}', [PostionController::class, 'index']);
        Route::get('create-code-postion', [PostionController::class, 'createAutoCode']);
        Route::post('create-postion', [PostionController::class, 'create']);
        Route::post('delete-postion', [PostionController::class, 'deleteAll']);

        Route::get('account-type', [AccountTypeController::class, 'index']);
    });
});
