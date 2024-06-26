<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlockController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\AccountTypeController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\SliderController;
use PharIo\Manifest\Author;

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
    Route::delete('logout', [AuthController::class, 'logout']);
    Route::post('email-forgot-password', [AuthController::class, 'sendOtpEmailForgotPassword']);

    Route::middleware(['checkToken.email'])->group(function () {
        Route::post('verify-otp', [AuthController::class, 'verifyOtp']);
    });

    Route::post('new-pass', [AuthController::class, 'createNewPass']);
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
        Route::post('search-slicer-unit', [DepartmentController::class, 'getSearchSlicerUnit']);
        Route::get('org-chart', [DepartmentController::class, 'getOrgChart']);

        Route::post('positions/{page}', [PositionController::class, 'index']);
        Route::get('create-code-position', [PositionController::class, 'createAutoCode']);
        Route::post('create-position', [PositionController::class, 'create']);
        Route::post('delete-position', [PositionController::class, 'deleteAll']);
        Route::post('search-slicer-position/{page}', [PositionController::class, 'getSearchSlicerPosition']);
        Route::post('search-position/{keySearch}/{page}', [PositionController::class, 'searchPosition']);

        Route::get('account-type', [AccountTypeController::class, 'index']);

        Route::get('slider-list', [SliderController::class, 'getSlider']);
        Route::post('slicer-setting-update', [SliderController::class, 'updateSlider']);
    });
});
