<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;    
use App\Models\User;
use App\Api\ApiError;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Filesystem\Filesystem;

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

            $user=User::where('email',$request->get('email'))->first();
            $user_phone=User::where('phone',$request->get('phone'))->first();

            if( $user != null )
                return response()->json(ApiError::errorMessage('O email já está cadastrado !',1010,false));

            if( $user_phone != null )
                return response()->json(ApiError::errorMessage('O telefone já está cadastrado !',1010,false));
                
            $request->password=bcrypt($request->password);
            $userData = $request->all();
            $userData['password']=$request->password;
            $userData['remember_token']=\Str::random(60);
    
            $this->user->create($userData);
        
            return response()->json(ApiError::errorMessage('Usuário adicionado!',201,true));
            

        } catch(\Exception $e){

            return response()->json(ApiError::errorMessage('Não conseguimos cadastrar o usuário :(', 1010,false));

        }
    }


    public function getAvatar($user){


        try{

            $files=Storage::disk('public')->allFiles('images/'.$user->id.'/perfil/');
            
            if( $files ){

       
                foreach( $files as $file ){

                    $path = storage_path('app/public/' . $file);
                    $file_contents=file_get_contents($path);

                    $user->{"photo"}=base64_encode($file_contents);

                    
                }
                
            }else{

                $user->{"photo"}=null;
                
            }
            

            return $user;

        }catch(\Exception $e){

            return response()->json(ApiError::errorMessage('Get avatar error'.$e->getMessage(), 1010,false));


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

                $user=$this->getAvatar($user);

                return response()->json(ApiError::errorMessage($user, 201,true));

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
            $user=$this->getAvatar($user);

            return response()->json(ApiError::errorMessage($user, 201,true));
            
        }catch(\Exception $e){

            return response()->json(ApiError::errorMessage($e->getMessage(), 1010,false));

        }

    }
   
    //------------------------------------------------------------------------------------------------------------------//

    public function update(Request $request){

        $data=[

                'strfield' => $request->get('strfield'),
                'field'    => $request->get('field'),
                'token'    => $request->get('token')

        ];

        try{

            $user=User::where('remember_token', '=', $data['token'])->firstOrFail();
            
            switch( $data['field'] ){

                case 'name':
                    $user->name = $request->get('strfield');
                break;    
                case 'email':
                    $user->email = $request->get('strfield');
                break;

                case 'phone':
                    $user->phone = $request->get('strfield');
                break;

            }
            
            $user->save();

            return response()->json(ApiError::errorMessage("Dados alterados com sucesso!!", 201,true));

        }catch(\Exception $e){

            return response()->json(ApiError::errorMessage($e->getMessage(),1010,false));

        }
     

    }

    public function uploadImagePerfil(Request $request){

        try{   

            
            if( Storage::exists('public/images/'.$request->get('user_id').'/perfil/') )
                $response = Storage::deleteDirectory('public/images/'.$request->get('user_id').'/perfil');
               
            $images=$request->file('image');
            $images->store('images/'.$request->get('user_id').'/perfil/','public');

            return response()->json(ApiError::errorMessage("ok",201,true));

        
        }catch(\Exception $e){

            return response()->json(ApiError::errorMessage("Error",1010,false));

        }


        return response()->json(ApiError::errorMessage($request->all(),1010,false));


    }
    
    public function removeUser(Request $request){


        if( \Auth::attempt([ 'email' => $request->get('email'), 'password' => $request->get('passwd') ],true) ){
            
            if( $user=User::where('email',$request->get('email'))->first() ){


                if( Storage::exists('public/images/'.$user->id) )
                    Storage::deleteDirectory('public/images/'.$user->id);

                $user->delete();

                return response()->json(ApiError::errorMessage("Usuário deletado!",201,true));

            }else{

                return response()->json(ApiError::errorMessage("Não foi possível remover o usuário",1010,false));
            
            }
        
        }else{

            return response()->json(ApiError::errorMessage("Senha incorreta !",1010,false));

        }
        
    }


}
