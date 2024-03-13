<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlockController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\FieldController;

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
    });
});
