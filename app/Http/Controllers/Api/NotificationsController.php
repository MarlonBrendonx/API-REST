<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Notifications;
use App\Http\Controllers\Controller;
use App\Api\ApiError;


class NotificationsController extends Controller
{


    private $notifications;
    private $repository;

    public function __construct(Notifications $notifications){

        $this->notifications=$notifications;
       

    }

    public function getNotificationsById(Request $request){

        try{

            $notf=app('App\Repositories\NotificationsRepository')->getNotificationsById($request);


            foreach($notf as $nt ){

                $notf=app('App\Http\Controllers\Api\UsersController')->getAvatar($nt);
                
            }

        
            return response()->json(ApiError::errorMessage($notf,201,true));

        }catch(\Exception $e){

            return response()->json(ApiError::errorMessage('Erro ao buscar as notificações'.$e->getMessage(), 1010,false));
            
        }

        
        
        
    }

    public function register(Request $request){
    
        $message="";

        try{

            $notf = $request->all();

            if( $request->get('type') == 0 )
                $message="Seu evento de animal perdido foi respondido !";
            else if( $request->get('type') == 2 )
                $message="Sua denúncia foi respondida !";

            $notf['message']=$message;

            $this->notifications->create($notf);

            return response()->json(ApiError::errorMessage('Notificação criada!',201,true));


        } catch(\Exception $e){

            if( config('app.debug') ){
                return response()->json(ApiError::errorMessage($e->getMessage(), 1010,false));
            }

            return response()->json(ApiError::errorMessage('Erro ao adicionar a notificação', 1010,false));

        }


    }
    


}
