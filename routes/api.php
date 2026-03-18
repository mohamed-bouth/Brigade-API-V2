<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PlatController;
use App\Http\Controllers\UserController;
use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('register' , [AuthController::class , 'register']);
Route::post('login' , [AuthController::class , 'login']);

Route::middleware('auth:sanctum')->group(function(){
    Route::post('logout' , [AuthController::class , 'logout']);
    Route::get('users' , [UserController::class , 'users']);

    Route::get('profile' , [UserController::class , 'show']);
    Route::post('profile' , [UserController::class , 'store']);

    Route::post('plats' ,[PlatController::class , 'store']);
    Route::get('plats' ,[PlatController::class , 'index']);
    Route::get('plats/{id}' ,[PlatController::class , 'show']);
    Route::put('plats/{id}' ,[PlatController::class , 'update']);
    Route::delete('plats/{id}' ,[PlatController::class , 'destroy']);


    Route::post('categories' ,[CategoryController::class , 'store']);
    Route::get('categories' ,[CategoryController::class , 'index']);
    Route::get('categories/{id}' ,[CategoryController::class , 'show']);
    Route::put('categories/{id}' ,[CategoryController::class , 'update']);
    Route::delete('categories/{id}' ,[CategoryController::class , 'destroy']);
    Route::post('categories/{id}/plats' ,[CategoryController::class , 'add']);
});





