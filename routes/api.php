<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlockController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\AccountTypeController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\SlicerController;



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

        Route::get('unit', [UnitController::class, 'index']);
        Route::get('trash-unit-list', [UnitController::class, 'getTrashUnit']);
        Route::get('create-code-unit', [UnitController::class, 'createAutoCode']);
        Route::get('trash-unit-count', [UnitController::class, 'trashUnitCount']);
        Route::get('unit-list', [UnitController::class, 'getListUnit']);
        Route::post('unit-update', [UnitController::class, 'update']);
        Route::post('unit-create', [UnitController::class, 'create']);
        Route::post('delete-unit', [UnitController::class, 'deleteUnit']);
        Route::post('empty-unit', [UnitController::class, 'emptyTrashUnit']);
        Route::post('restore-Unit', [UnitController::class, 'restoreTranshUnit']);
        Route::get('search-unit/{keySearch}', [UnitController::class, 'searchUnit']);
        Route::post('search-slicer-unit', [UnitController::class, 'getSearchSlicerUnit']);
        Route::get('org-chart', [UnitController::class, 'getOrgChart']);

        Route::post('positions/{page}', [PositionController::class, 'index']);
        Route::get('create-code-position', [PositionController::class, 'createAutoCode']);
        Route::post('create-position', [PositionController::class, 'create']);
        Route::post('delete-position', [PositionController::class, 'deleteAll']);
        Route::post('search-slicer-position/{page}', [PositionController::class, 'getSearchSlicerPosition']);
        Route::post('search-position/{keySearch}/{page}', [PositionController::class, 'searchPosition']);

        Route::get('account-type', [AccountTypeController::class, 'index']);

        Route::get('slicer-list/{type}', [SlicerController::class, 'getSlicerType']);
        Route::get('slicer-setting/{type}', [SlicerController::class, 'getSlicerSettingType']);
        Route::post('slicer-setting-update', [SlicerController::class, 'updateSlider']);
    });
});
