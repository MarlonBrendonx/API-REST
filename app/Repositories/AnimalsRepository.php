<?php

namespace App\Repositories;
use Illuminate\Http\Request; 
use App\Models\Animal;
use Illuminate\Support\Facades\DB;
/**
 * Class ConvenioRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class AnimalsRepository {


    public function getAnimals(Request $request){

        $animals=DB::table('animals')
                ->select('animals.id as id_animals','animals.name','animals.sex','animals.age','animals.species',
                'animals.photos','animals.breed','animals.information','animals.users_id as user_id')
                ->join('users','animals.users_id','=','users.id')
                ->where('animals.users_id','=',$request->get('id_users'))
                ->get();

        return $animals;

    }
    
     public function getAnimalsp(Request $request){

        $animalsp=DB::table('animals')
                ->select('animals.id as id_animals','animals.users_id as user_id')
                //->join('users','animals.users_id','=','users.id')
                ->where('animals.id','=',$request->get('id_animals'))
                ->get();

        return $animalsp;

    }

}
