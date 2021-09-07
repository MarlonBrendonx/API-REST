<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;    
use App\Models\Events;
use App\Api\ApiError;


class EventsController extends Controller{

    private $event;
    private $repository;

    public function __construct(Event $event){

        $this->event=$event;
       
    }


    public function index(){

        $data= [ 'data' => $this->event->all() ]; 

        return  response()->json($data);

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




}
