<?php

use App\Http\Controllers\ApiAuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\SearchRecordController;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


// Route::apiResource('contact', ContactController::class)->middleware('auth:sanctum');


// Route::post("register", [ApiAuthController::class, 'register']);
// Route::post("login", [ApiAuthController::class, 'login']);
// Route::post("logout", [ApiAuthController::class, 'logout'])->middleware('auth:sanctum');
// Route::post("logout-all", [ApiAuthController::class, 'logoutAll'])->middleware('auth:sanctum');


Route::prefix("v1")->group(function () {

    Route::middleware('auth:sanctum')->group(function () {

        Route::apiResource('contact', ContactController::class);
        Route::get('contact/restore/{id}', [ContactController::class, 'restore'])->name('contacts.restore');
        Route::get('contact/restore-all', [ContactController::class, 'restoreAll'])->name('contacts.restore.all');
        Route::delete('force-delete/{id}', [ContactController::class, 'forceDelete']);

        // Route::delete('multiple-delete', [ContactController::class, 'multipleDestory']);

        Route::apiResource('favorite', FavoriteController::class);
        Route::apiResource('search-record', SearchRecordController::class);

        Route::post("logout", [ApiAuthController::class, 'logout']);
        Route::post("logout-all", [ApiAuthController::class, 'logoutAll']);
        Route::get("devices", [ApiAuthController::class, 'devices']);
    });


    Route::post("register", [ApiAuthController::class, 'register']);
    Route::post("login", [ApiAuthController::class, 'login']);
});
