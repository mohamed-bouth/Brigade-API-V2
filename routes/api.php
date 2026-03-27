<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\PlatController;
use App\Http\Controllers\PreferenceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RecommendationController;
use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use  App\Services\GeminiService;


Route::post('register' , [AuthController::class , 'register']);
Route::post('login' , [AuthController::class , 'login']);

Route::middleware('auth:sanctum')->group(function(){
    Route::post('logout' , [AuthController::class , 'logout']);
    

    Route::middleware('admin')->group(function () {
        Route::get('users' , [UserController::class , 'users']);

        Route::post('plats' ,[PlatController::class , 'store']);
        Route::put('plats/{id}' ,[PlatController::class , 'update']);
        Route::delete('plats/{id}' ,[PlatController::class , 'destroy']);

        Route::post('categories' ,[CategoryController::class , 'store']);
        
        Route::put('categories/{id}' ,[CategoryController::class , 'update']);
        Route::delete('categories/{id}' ,[CategoryController::class , 'destroy']);
        Route::post('categories/{id}/plats' ,[CategoryController::class , 'add']);

        Route::get('ingredients' ,[IngredientController::class , 'index']);
        Route::post('ingredients' ,[IngredientController::class , 'store']);
        Route::put('ingredients/{id}' ,[IngredientController::class , 'update']);
        Route::delete('ingredients/{id}' ,[IngredientController::class , 'destroy']);

        Route::get('dashboard',[DashboardController::class , 'index']);
    });

    Route::get('categories' ,[CategoryController::class , 'index']);
    Route::get('categories/{id}' ,[CategoryController::class , 'show']);

    Route::get('plats' ,[PlatController::class , 'index']);
    Route::get('plats/{id}' ,[PlatController::class , 'show']);

    Route::get('profile' , [UserController::class , 'show']);
    Route::post('profile' , [PreferenceController::class , 'store']);
    Route::put('profile/{id}' , [PreferenceController::class , 'update']);
    Route::get('profile/preferences', [PreferenceController::class, 'index']);


    Route::post('/recommendations/analyze/{id}' , [RecommendationController::class , 'analyze']);
    Route::get('/recommendations' , [RecommendationController::class , 'history']);
    Route::get('/recommendations/{id}' , [RecommendationController::class , 'show']);

});

// Route::get('/gemini-test', function (GeminiService $gemini) {
//     return response()->json(
//         $gemini->generate('just say: success 200')
//     );
// });




