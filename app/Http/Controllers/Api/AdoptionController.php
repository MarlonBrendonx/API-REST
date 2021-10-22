<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Adocao;
use App\Api\ApiError;

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




}
