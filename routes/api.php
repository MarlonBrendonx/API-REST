<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MapEventsController;
use App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\Api\AnimalController;
use App\Http\Controllers\Api\ResolvedEvents;
use App\Http\Controllers\Api\AdoptionController;
use App\Http\Controllers\Api\DoacaoController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



Route::namespace('API')->name('api.')->group(function(){

    Route::prefix('users')->group(function(){

        Route::get('/',[UsersController::class, 'index']);
        Route::post('/',[UsersController::class, 'register']);
        Route::post('/login',[UsersController::class, 'login']);
        Route::post('/checkToken',[UsersController::class, 'checkToken']);
        Route::post('/update',[UsersController::class, 'update']);
    
    });

    Route::prefix('events')->group(function(){

        Route::post('/get',[MapEventsController::class, 'index']);
        Route::post('/getOptions',[MapEventsController::class, 'getEventOptions']);
        Route::post('/',[MapEventsController::class, 'register']);
        Route::post('/uploadImage',[MapEventsController::class, 'uploadImage']);
        Route::post('/remove',[MapEventsController::class, 'removeEvent']);
       
    });

    Route::prefix('resolvedevents')->group(function(){

        Route::post('/get',[ResolvedEvents::class, 'index']);
        Route::post('/',[ResolvedEvents::class, 'register']);
       
       
    });

    Route::prefix('animals')->group(function(){

        Route::post('/get',[AnimalController::class, 'index']);
        Route::post('/',[AnimalController::class, 'register']);
        Route::post('/remove',[AnimalController::class, 'remove']);
        Route::post('/uploadImage',[AnimalController::class, 'uploadImage']);
        
        
       
    });
    Route::prefix('adocaos')->group(function(){

        Route::post('/get',[AdoptionController::class, 'index']);
        Route::post('/',[AdoptionController::class, 'register']);
        Route::post('/getp',[AdoptionController::class, 'indexp']);
        Route::post('/getu',[AdoptionController::class, 'indexu']);
        Route::post('/remove',[AdoptionController::class, 'remove']);
        
        
       
    });
    Route::prefix('doacaos')->group(function(){

        Route::post('/get',[DoacaoController::class, 'index']);
        Route::post('/',[DoacaoController::class, 'register']);
        Route::post('/getu',[DoacaoController::class, 'indexu']);
        Route::post('/remove',[DoacaoController::class, 'remove']);
        
        
       
    });


});