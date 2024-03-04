<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\BlockController;


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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResources([
    'login' => LoginController::class
]);

Route::middleware(['LoginToken'])->group(function () {
    Route::apiResources([
         'company' => CompanyController::class,
         'logout' => LogoutController::class
    ]);

    Route::middleware(['DatabaseConnection'])->group(function(){
        Route::apiResources([
            'block' => BlockController::class
        ]);
    });
});


