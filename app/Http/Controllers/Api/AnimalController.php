<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Animal;
use App\Api\ApiError;
use Illuminate\Support\Facades\DB;
class AnimalController extends Controller{


    private $animal;
    private $repository;

    public function __construct(Animal $animal){

        $this->animal=$animal;
       
    }


    public function index(Request $request){
    	//return response()->json(ApiError::errorMessage($request->all(),201,true));
		try{

            $json=app('App\Http\Controllers\Api\UsersController')->checkToken($request);

            $value=json_decode ($json->content(), true);
            
            if( $value['status'] ){

                
                $animals=app('App\Repositories\AnimalsRepository')->getAnimals($request);
       
                /*
                foreach ($animals as $animals) {

                    //$files=Storage::disk('public')->allFiles($animals->photos.'/'.$animals->id_animals);

                    foreach( $files as $file ){

                        $path = storage_path('app/public/' . $file);
                        $file=file_get_contents($path);
                        $animals->{"images"}[]=base64_encode($file);

                    }
                
                    
                    
                }*/

                return response()->json(ApiError::errorMessage([ 'data' => $animals ],201,true));

            }else{

                return response()->json(ApiError::errorMessage('Permissão negada!',1010,false));
            }

        }catch( \Exception $e){

                return response()->json(ApiError::errorMessage($e->getMessage(),1010,false));
        }

    }
    
    public function register(Request $request){
        
        try{

            
            $animals = $request->all();
           
            $this->animal->create($animals);
            //$obj=DB::table('animals')->latest()->first();
            return response()->json(ApiError::errorMessage('Animal adicionado!',201,true));
            //return response()->json(ApiError::errorMessage($obj->id,201,true));

        } catch(\Exception $e){
            if( config('app.debug') ){

                return response()->json(ApiError::errorMessage($e->getMessage(), 1010,false));
            }
            return response()->json(ApiError::errorMessage('Não conseguimos cadastrar o pet :(', 1010,false));

        }

    }
     public function remove(Request $request){

        

        try{

            $json=app('App\Http\Controllers\Api\UsersController')->checkToken($request);

            $value=json_decode ($json->content(), true);
            
            if( $value['status'] ){

                 
                //$response = Storage::deleteDirectory('public/images/'.$request->get('user_id').'/'.$request->get('id_event'));
                
                $event=DB::table('animals')->where('id', $request->get('id_animals'))->delete();

                return response()->json(ApiError::errorMessage("Animal removido!",205,true));    

            }else{

                return response()->json(ApiError::errorMessage('Permissão negada!',1010,false));
            }

        }catch( \Exception $e){

                return response()->json(ApiError::errorMessage($e->getMessage(),1010,false));
        }
        
       
    }
    public function uploadImage(Request $request){

        try{   

            $images=$request->file('image');
            $images->store('images/'.$request->get('id_user').'/'.$request->get('id_animals'),'public');

            
            return response()->json(ApiError::errorMessage("ok",201,true));

        }catch(\Exception $e){

            return response()->json(ApiError::errorMessage("Error",1010,false));

        }


    }




}
