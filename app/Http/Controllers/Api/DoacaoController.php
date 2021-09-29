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


    public function index(){

        $data= [ 'data' => $this->doacao->all() ]; 

        return  response()->json($data);

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
