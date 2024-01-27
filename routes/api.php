<?php

use App\Http\Controllers\Auth\UserAuthenticationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::resource('/user-resource', UserAuthenticationController::class);
Route::post('/sign-in',[ UserAuthenticationController::class , 'login']);

Route::middleware('auth:sanctum')->group(function(){

    Route::get('/user',function (Request $request){
        return $request->user();
    });

});
