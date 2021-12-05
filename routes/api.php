<?php
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    Route::post('/user/add', [App\Http\Controllers\UserAccountController::class, 'store']);
    
    Route::prefix('ib')->group(function () {
        Route::post('/updateTotalBalance', [App\Http\Controllers\AssetValuesController::class, 'store']);
    
        Route::get('/listNAB', [App\Http\Controllers\AssetValuesController::class, 'show']);
    
        Route::POST('/topup', [App\Http\Controllers\TopUpController::class, 'store']);
    
        Route::POST('/withdraw', [App\Http\Controllers\WithdrawController::class, 'store']);
    
        Route::get('/member', [App\Http\Controllers\UserAccountController::class, 'index']);
    });
});

Route::fallback(function () {
    return response()->json(["errors" => true, "message" => "Not Found",]);
});