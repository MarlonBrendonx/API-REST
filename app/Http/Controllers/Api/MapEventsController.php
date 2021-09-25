<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;   
use App\Models\Events;
use App\Api\ApiError;
use App\Models\User;
use App\Http\Controllers\Api\UsersController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Filesystem\Filesystem;

class MapEventsController extends Controller
{

    private $event;
    private $repository;

    public function __construct(Events $event){

        $this->event=$event;
 
    }

    public function encoder64Image($files){

        var_dump($files);


    }
    

    public function index(Request $request){
        
        try{

            $json=app('App\Http\Controllers\Api\UsersController')->checkToken($request);

            $value=json_decode ($json->content(), true);
            
            if( $value['status'] ){

                
                $events=app('App\Repositories\EventsRepository')->getEvents();
       

                foreach ($events as $event) {

                    $files=Storage::disk('public')->allFiles($event->photos.'/'.$event->id_event);

                    foreach( $files as $file ){

                        $path = storage_path('app/public/' . $file);
                        $file=file_get_contents($path);
                        $event->{"images"}[]=base64_encode($file);

                    }
                
                    
                    
                }

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
            $obj=DB::table('events')->latest()->first();
    
            return response()->json(ApiError::errorMessage($obj->id,201,true));


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
            $images->store('images/'.$request->get('id_user').'/'.$request->get('id_event'),'public');

            
            return response()->json(ApiError::errorMessage("ok",201,true));

        }catch(\Exception $e){

            return response()->json(ApiError::errorMessage("Error",1010,false));

        }


    }


    public function getEventOptions(Request $request){
        
        $events=app('App\Repositories\EventsRepository')->getEventsOptions($request);

        return response()->json(ApiError::errorMessage($events->all(),205,true));

    }

    public function removeEvent(Request $request){

        

        try{

            $json=app('App\Http\Controllers\Api\UsersController')->checkToken($request);

            $value=json_decode ($json->content(), true);
            
            if( $value['status'] ){

                 
                $response = Storage::deleteDirectory('public/images/'.$request->get('user_id').'/'.$request->get('id_event'));
                
                $event=DB::table('events')->where('id', $request->get('id_event'))->delete();

                return response()->json(ApiError::errorMessage("Evento removido!",205,true));    

            }else{

                return response()->json(ApiError::errorMessage('Permissão negada!',1010,false));
            }

        }catch( \Exception $e){

                return response()->json(ApiError::errorMessage($e->getMessage(),1010,false));
        }
        
       
    }
    

}
