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
    Route::get('/user/add', [App\Http\Controllers\UserAccountController::class, 'store']);
    
    Route::prefix('ib')->group(function () {
        Route::get('/updateTotalBalance', function () {
            return 'Hello World ';
        });
    
        Route::get('/listNAB', function () {
            return 'Hello World ';
        });
    
        Route::get('/topup', function () {
            return 'Hello World ';
        });
    
        Route::get('/withdraw', function () {
            return 'Hello World ';
        });
    
        Route::get('/member', function () {
            return 'Hello World ';
        });
    });
});
