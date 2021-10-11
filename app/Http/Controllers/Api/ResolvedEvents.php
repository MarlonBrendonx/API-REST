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
                
                $this->resolved->create($data);

                /* Mudando o status */
                $sts=app('App\Repositories\EventsRepository')->changeStatusevent($request);

                /* Enviando notificação */
                $res=app('App\Http\Controllers\Api\NotificationsController')->register($request);

                if( $sts && $res ){

                    return response()->json(ApiError::errorMessage('Evento adicionado!',205,true));

                }else{
                    return response()->json(ApiError::errorMessage('Erro ao adicionar o evento!',1010,false));
                }

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
