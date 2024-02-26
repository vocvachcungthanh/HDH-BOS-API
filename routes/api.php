<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;

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

// Route::middleware(['LoginToken'])->group(function () {
//     Route::apiResources([
//         'admin/auth'                    => AuthController::class,
//         'admin/sliders'                 => SliderController::class,
//         'admin/albums'                  => AlbumController::class,
//         'admin/menus'                   => MenuController::class,
//         'admin/couples'                 => CoupldeController::class,
//         'admin/bgs'                     => BgsController::class,
//         'admin/events'                  => EventController::class,
//         'admin/countdowns'              => CountDownController::class,
//         'admin/music'                   => MusicController::class,
//         'admin/love-story'              => LoveStoryController::class,
//         'admin/dashboard'               => DashboardController::class,
//         'admin/guestkbooks'             => GuestkbookController::class,
//         'admin/bridesmaids-groomsmen'   => BridesmaidsGroomsmenController::class

//     ]);
// });
