<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Notifications;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
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
             
                $notf->{'photo'}=app('App\Http\Controllers\Api\UsersController')->getAvatar($nt);
                
                
            }

            
            return response()->json(ApiError::errorMessage(['data' => $notf, 'count' => $notf->count() ],201,true));
     

        }catch(\Exception $e){

            return response()->json(ApiError::errorMessage('Erro ao buscar as notificações'.$e->getMessage(), 1010,false));
            
        }

        
    }

    public function register(Request $request){

        $message="";

        try{

           
            if( $request->get('type') == 0 )
                $message="Seu evento de animal perdido foi respondido !";
            else if( $request->get('type') == 2 )
                $message="Sua denúncia foi respondida !";

            $notf=[

                'user_id'         => $request->get('user_id'),
                'user_id_event'   => $request->get('user_id_event'),
                'message'         => $message,
                'type'            => $request->get('type'),
                'id_event'        => $request->get('event_id')

            ];


            $this->notifications->create($notf);

            return response()->json(ApiError::errorMessage('Notificação criada!',201,true));


        } catch(\Exception $e){

            if( config('app.debug') ){
                return response()->json(ApiError::errorMessage($e->getMessage(), 1010,false));
            }

            return response()->json(ApiError::errorMessage('Erro ao adicionar a notificação', 1010,false));

        }


    }

    public function removeNotification(Request $request){

        try{

            $json=app('App\Http\Controllers\Api\UsersController')->checkToken($request);

            $value=json_decode ($json->content(), true);
            
            if( $value['status'] ){

                $event=DB::table('notifications')->where('id', $request->get('id_notification'))->delete();

                return response()->json(ApiError::errorMessage("Notificação removida!",205,true));    

            }else{

                return response()->json(ApiError::errorMessage('Permissão negada!',1010,false));
            }

        }catch( \Exception $e){

                return response()->json(ApiError::errorMessage($e->getMessage(),1010,false));
        }



    }
    


}
