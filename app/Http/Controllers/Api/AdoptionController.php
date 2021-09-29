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


    public function index(){

        $data= [ 'data' => $this->adocao->all() ]; 

        return  response()->json($data);

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
