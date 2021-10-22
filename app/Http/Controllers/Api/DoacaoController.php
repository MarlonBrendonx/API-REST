<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Doacao;
use App\Api\ApiError;

class DoacaoController extends Controller{


    private $doacao;
    private $repository;

    public function __construct(Doacao $doacao){

        $this->doacao=$doacao;
       
    }


    public function index(Request $request){
        try{
            $json=app('App\Http\Controllers\Api\UsersController')->checkToken($request);

            $value=json_decode ($json->content(), true);
            
            if( $value['status'] ){

                
                $donation=app('App\Repositories\DonationRepository')->getDonation($request);
       
                /*
                foreach ($animals as $animals) {

                    //$files=Storage::disk('public')->allFiles($animals->photos.'/'.$animals->id_animals);

                    foreach( $files as $file ){

                        $path = storage_path('app/public/' . $file);
                        $file=file_get_contents($path);
                        $animals->{"images"}[]=base64_encode($file);

                    }
                
                    
                    
                }*/

                return response()->json(ApiError::errorMessage([ 'data' => $donation ],201,true));

            }else{

                return response()->json(ApiError::errorMessage('Permissão negada!',1010,false));
            }

        }catch( \Exception $e){

                return response()->json(ApiError::errorMessage($e->getMessage(),1010,false));
        }
    }

    public function register(Request $request){
        
        try{

            
            $doacao = $request->all();                                  
           
            $this->doacao->create($doacao);
    
            return response()->json(ApiError::errorMessage('Doação adicionada!',201,true));

        } catch(\Exception $e){

            if( config('app.debug') ){
                return response()->json(ApiError::errorMessage($e->getMessage(), 1010,false));
            }

            return response()->json(ApiError::errorMessage('Não conseguimos cadastrar a doação :(', 1010,false));

        }

    }




}
