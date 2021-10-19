<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Resolved_Events;
use App\Http\Controllers\Controller;
use App\Api\ApiError;


class ResolvedEvents extends Controller
{


    private $resolved;
    private $repository;

    public function __construct(Resolved_Events $resolved){

        $this->resolved=$resolved;
       

    }

    public function index(){

        $data= [ 'data' => $this->resolved->all() ]; 

        return  response()->json($data);
    }

    public function register(Request $request){


        try{

            $json=app('App\Http\Controllers\Api\UsersController')->checkToken($request);

            $value=json_decode ($json->content(), true);
            
            if( $value['status'] ){
                

                /* Mudando o status */
                $sts=app('App\Repositories\EventsRepository')->changeStatusevent($request);

                /* Enviando notificação */
                $res=app('App\Http\Controllers\Api\NotificationsController')->register($request);


                $data=[

                    'event_id' => $request->get('event_id'),
                    'user_id'  => $request->get('user_id'),
                    

                ];

                $res_json=json_decode ($res->content(), true);
                

                $this->resolved->create($data);
   

                    return response()->json(ApiError::errorMessage('Evento adicionado!',205,true));

               
            }else{

                return response()->json(ApiError::errorMessage('Permissão negada !',1010,false));

            }

        }catch(\Exception $e){

            if( config('app.debug') ){
                return response()->json(ApiError::errorMessage($e->getMessage(), 1010,false));
            }

        }


    }


}
