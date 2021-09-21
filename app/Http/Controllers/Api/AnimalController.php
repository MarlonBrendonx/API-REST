<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Animal;
use App\Api\ApiError;

class AnimalController extends Controller{


    private $animal;
    private $repository;

    public function __construct(Animal $animal){

        $this->animal=$animal;
       
    }


    public function index(){

        $data= [ 'data' => $this->animal->all() ]; 

        return  response()->json($data);

    }

    public function register(Request $request){
        
        try{

            
            $animal = $request->all();
           
            $this->animal->create($animal);
    
            return response()->json(ApiError::errorMessage('Animal adicionado',201,true));

        } catch(\Exception $e){

            if( config('app.debug') ){
                return response()->json(ApiError::errorMessage($e->getMessage(), 1010,false));
            }

            return response()->json(ApiError::errorMessage('Não conseguimos cadastrar o animal :(', 1010,false));

        }

    }




}
