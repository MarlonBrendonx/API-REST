<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MapEventsController;
use App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\Api\AnimalController;
use App\Http\Controllers\Api\ResolvedEvents;
use App\Http\Controllers\Api\NotificationsController;

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
        Route::post('/uploadImagePerfil',[UsersController::class, 'uploadImagePerfil']);
        Route::post('/remove',[UsersController::class, 'removeUser']);
    
    });

    Route::prefix('events')->group(function(){

        Route::post('/get',[MapEventsController::class, 'index']);
        Route::post('/getbyId',[MapEventsController::class, 'indexbyId']);
        Route::post('/getOptions',[MapEventsController::class, 'getEventOptions']);
        Route::post('/',[MapEventsController::class, 'register']);
        Route::post('/uploadImage',[MapEventsController::class, 'uploadImage']);
        Route::post('/remove',[MapEventsController::class, 'removeEvent']);
        Route::post('/update',[MapEventsController::class, 'updateEvent']);
        Route::post('/searchEvent',[MapEventsController::class, 'searchEvent']);
       
    });

    Route::prefix('resolvedevents')->group(function(){

        Route::post('/get',[ResolvedEvents::class, 'index']);
        Route::post('/',[ResolvedEvents::class, 'register']);
       
    });

    Route::prefix('notifications')->group(function(){

        Route::post('/get',[NotificationsController::class, 'getNotificationsById']);
        Route::post('/',[NotificationsController::class, 'register']);
        Route::post('/remove',[NotificationsController::class, 'removeNotification']);
      
    });

    Route::prefix('animal')->group(function(){

        Route::get('/',[AnimalController::class, 'index']);
        Route::post('/',[AnimalController::class, 'register']);
           
    });

});