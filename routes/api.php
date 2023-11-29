<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('register',[AuthController::class,'register']);
// Route::post('register','Api\AuthController@register');
Route::post('login',[AuthController::class,'login'])->name('login');
// Route::post('login','Api\AuthController@login');
Route::get('user-profile',[AuthController::class,'userProfile']);

Route::group(['middleware'=>['auth:sanctum']], function(){
    
    Route::post('logout',[AuthController::class,'logout']);
});


