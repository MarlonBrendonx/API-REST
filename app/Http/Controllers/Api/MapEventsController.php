<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;   
use App\Models\Events;
use App\Api\ApiError;
use App\Models\User;
use App\Http\Controllers\Api\UsersController;
use Illuminate\Support\Facades\DB;

class MapEventsController extends Controller
{

    private $event;
    private $repository;

    public function __construct(Events $event){

        $this->event=$event;
 
    }

    

    public function index(Request $request){
        

        try{

            $json=app('App\Http\Controllers\Api\UsersController')->checkToken($request);

            $value=json_decode ($json->content(), true);
            
            if( $value['status'] ){

                $events=app('App\Repositories\EventsRepository')->getEvents();
                return response()->json(ApiError::errorMessage([ 'data' => $events ],201,true));

            }else{

                return response()->json(ApiError::errorMessage('Permissão negada!',1010,false));
            }

        }catch( \Exception $e){

                return response()->json(ApiError::errorMessage($e->getMessage(),1010,false));
        }

    }

    public function register(Request $request){
        

        try{

            $event = $request->all();
            
            $this->event->create($event);
    
            return response()->json(ApiError::errorMessage('Evento adicionado!',201,true));


        } catch(\Exception $e){

            if( config('app.debug') ){
                return response()->json(ApiError::errorMessage($e->getMessage(), 1010,false));
            }

            return response()->json(ApiError::errorMessage('Não conseguimos cadastrar o evento :(', 1010,false));

        }
   

    }
    
    public function uploadImage(Request $request){

        try{   

            $images=$request->file('image');
            $images->store('images/'.$request->get('id_user'),'public');

            
            return response()->json(ApiError::errorMessage("ok",201,true));

        }catch(\Exception $e){

            return response()->json(ApiError::errorMessage("Error",1010,false));

        }


    }


    public function getEventOptions(Request $request){
        
        $events=app('App\Repositories\EventsRepository')->getEventsOptions($request);
        return response()->json(ApiError::errorMessage($events->all(),205,true));

    }
    

}
