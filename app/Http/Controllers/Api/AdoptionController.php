<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Adocao;
use App\Api\ApiError;
use Illuminate\Support\Facades\DB;
class AdoptionController extends Controller{


    private $adocao;
    private $repository;

    public function __construct(Adocao $adocao){

        $this->adocao=$adocao;
       
    }


   public function index(Request $request){
        //return response()->json(ApiError::errorMessage($request->all(),201,true));
        try{

            $json=app('App\Http\Controllers\Api\UsersController')->checkToken($request);

            $value=json_decode ($json->content(), true);
            
            if( $value['status'] ){

                
                $adoption=app('App\Repositories\AdoptionRepository')->getAdoption($request);
       
                /*
                foreach ($animals as $animals) {

                    //$files=Storage::disk('public')->allFiles($animals->photos.'/'.$animals->id_animals);

                    foreach( $files as $file ){

                        $path = storage_path('app/public/' . $file);
                        $file=file_get_contents($path);
                        $animals->{"images"}[]=base64_encode($file);

                    }
                
                    
                    
                }*/

                return response()->json(ApiError::errorMessage([ 'data' => $adoption ],201,true));

            }else{

                return response()->json(ApiError::errorMessage('Permissão negada!',1010,false));
            }

        }catch( \Exception $e){

                return response()->json(ApiError::errorMessage($e->getMessage(),1010,false));
        }

    }
    public function indexp(Request $request){
        //return response()->json(ApiError::errorMessage($request->all(),201,true));
        try{

            //$json=app('App\Http\Controllers\Api\UsersController')->checkToken($request);

            //$value=json_decode ($json->content(), true);
            
            if( true ){

                
                $animals=app('App\Repositories\AdoptionRepository')->getAnimalsp($request);
       
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
    public function indexu(Request $request){
        //return response()->json(ApiError::errorMessage($request->all(),201,true));
        try{

            //$json=app('App\Http\Controllers\Api\UsersController')->checkToken($request);

            //$value=json_decode ($json->content(), true);
            
            if(true ){

                
                $adoption=app('App\Repositories\AdoptionRepository')->getUsers($request);
       
                /*
                foreach ($animals as $animals) {

                    //$files=Storage::disk('public')->allFiles($animals->photos.'/'.$animals->id_animals);

                    foreach( $files as $file ){

                        $path = storage_path('app/public/' . $file);
                        $file=file_get_contents($path);
                        $animals->{"images"}[]=base64_encode($file);

                    }
                
                    
                    
                }*/

                return response()->json(ApiError::errorMessage([ 'data' => $adoption ],201,true));

            }else{

                return response()->json(ApiError::errorMessage('Permissão negada!',1010,false));
            }

        }catch( \Exception $e){

                return response()->json(ApiError::errorMessage($e->getMessage(),1010,false));
        }

    }
    public function register(Request $request){
        
        try{

            
            $adocao = $request->all();
           
            $this->adocao->create($adocao);
    
            return response()->json(ApiError::errorMessage('Adoção adicionada!',201,true));

        } catch(\Exception $e){

            if( config('app.debug') ){
                return response()->json(ApiError::errorMessage($e->getMessage(), 1010,false));
            }

            return response()->json(ApiError::errorMessage('Não conseguimos cadastrar a adoção :(', 1010,false));

        }

    }
     public function remove(Request $request){

        

        try{

            $json=app('App\Http\Controllers\Api\UsersController')->checkToken($request);

            $value=json_decode ($json->content(), true);
            
            if( $value['status'] ){

                 
                //$response = Storage::deleteDirectory('public/images/'.$request->get('user_id').'/'.$request->get('id_event'));
                
                $event=DB::table('adocaos')->where('animals_id', $request->get('id_adoption'))->delete();

                return response()->json(ApiError::errorMessage("Adoção removida!",205,true));    

            }else{

                return response()->json(ApiError::errorMessage('Permissão negada!',1010,false));
            }

        }catch( \Exception $e){

                return response()->json(ApiError::errorMessage($e->getMessage(),1010,false));
        }
        
       
    }



}
