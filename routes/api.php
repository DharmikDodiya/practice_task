<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Routing\Route as RoutingRoute;
use Illuminate\Support\Facades\Route;
use Whoops\Run;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::controller(AuthController::class)->group(function(){
    Route::post('/login','login');
    Route::post('/register','register');
    Route::get('/verifyuser/{token}','verifyAccount');
    Route::post('/forget-password','forgetPassword');
    Route::get('resetPassword','forgetPasswordView');
    Route::post('reset-Password','resetPassword');
});

Route::middleware(['auth:api'])->group(function(){
    
    Route::controller(UserController::class)->prefix('user')->group(function(){
        Route::get('list','list');
        Route::get('/user-Profile',  'userProfile');
        Route::post('/change-Password',  'changePassword');
        Route::get('/logout','logout');
    });
   
});