<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;    
use App\Models\User;
use App\Api\ApiError;

class UsersController extends Controller
{
    
    private $user;
    private $repository;

    public function __construct(User $user){

        $this->user=$user;
       

    }


    public function index(){

        $data= [ 'data' => $this->user->all() ]; 

        return  response()->json($data);

    }

    public function register(Request $request){

       
        try{

            $request->password=bcrypt($request->password);
            $userData = $request->all();
            $userData['password']=$request->password;
            $userData['remember_token']=\Str::random(60);
 
            $this->user->create($userData);
    
            return response()->json(ApiError::errorMessage('Usuário adicionado!',201,true));

        } catch(\Exception $e){

            if( config('app.debug') ){
                return response()->json(ApiError::errorMessage($e->getMessage(), 1010,false));
            }

            return response()->json(ApiError::errorMessage('Não conseguimos cadastrar o usuário :(', 1010,false));

        }
    }
    
    public function login(Request $request){

        
        $data=[

            'email'             =>$request->get('email'),
            'password'          =>$request->get('password'),
            
    
        ];

        try {

            //trabalhando com criptografia
            if(env('PASSWORD_HASH')){

              if ( \Auth::attempt($data,true) ){
               
                $user=User::where('email',$request->get('email'))->first();
                return response()->json(ApiError::errorMessage($user->remember_token, 201,true));

              }

                return response()->json(ApiError::errorMessage('Email e/ou senhas incorretos!', 1010,false));  

            }else{

              //$user=  $this->repository->findWhere( ['email' => $request->get('email') ])->first();
              $user=User::where('email',$request->get('email'))->first();
              
              if(!$user){
                
                    return response()->json(ApiError::errorMessage('O usuário não está cadastrado!', 1010,false));    

              }else{

                if( $user->password != $request->get('password') ){

                    return response()->json(ApiError::errorMessage('Senha incorreta!', 1010,false));

                }

            }

              //Autenticando atraves do objeto
              \Auth::login($user);
              return response()->json(ApiError::errorMessage('Autorizado', 1010,true));


            }

        }catch (\Exception $e) {

            return $e->getMessage();

        }

    }
    
    public function checkToken(Request $request){

        try{

            $user=User::where('remember_token',$request->get('token'))->first();

            $userData=[

                'name'           =>$user->name,
                'email'          =>$user->email,
                'remember_token' =>$user->remember_token
                
            ];

            return response()->json(ApiError::errorMessage($userData, 201,true));

        }catch(\Exception $e){

            return response()->json(ApiError::errorMessage('Token inválido:'+$e->getMessage(), 1010,false));

        }

    }
   
}
