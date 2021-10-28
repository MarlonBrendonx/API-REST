<?php

namespace App\Repositories;
use Illuminate\Http\Request; 
use App\Models\Adocao;
use App\Models\Animal;
use App\Models\User;
use Illuminate\Support\Facades\DB;
/**
 * Class ConvenioRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class AdoptionRepository {


    public function getAdoption(Request $request){

        $adocoes=DB::table('adocaos')
                ->select('adocaos.id as id_adoption','adocaos.name','adocaos.sex','adocaos.age','adocaos.species',
                'adocaos.photos','adocaos.breed','adocaos.animals_id as adoption_id')
                ->get();

        return $adocoes;

    }
    
    public function getAnimalsp(Request $request){

        $animals=DB::table('animals')
                ->select('animals.id as id_animals','animals.users_id as user_id')
                //->join('users','animals.users_id','=','users.id')
                ->where('animals.id','=',$request->get('id_animals'))
                ->get();

        return $animals;

    }
    public function getUsers(Request $request){

        $users=DB::table('users')
                ->select('users.id as id_users','users.name','users.email','users.phone')
                //->join('users','users.users_id','=','users.id')
                ->where('users.id','=',$request->get('id_users'))
                ->get();

        return $users;

    }

}
