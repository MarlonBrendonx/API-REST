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
    
    public function getEventsOptions(Request $request){

        $events_1=DB::table('events')
                ->join('animals', 'events.animal_id', '=', 'animals.id')
                ->join('users','animals.users_id','=','users.id')
                ->select('events.id as id_event','events.type','events.latitude','events.longitude','events.status',
                'events.photos','events.information','animals.name','animals.sex','animals.personality','users.name as username',
                'users.phone')
                ->where('events.type','=',$request->get('option'))
                ->get();

        $events=DB::table('events')
                ->select('events.id as id_event','events.type','events.latitude','events.longitude','events.status',
                'events.photos','events.information')
                ->whereNull('events.animal_id')
                ->where('events.type','=',$request->get('option'))
                ->get();

        return $events->merge($events_1);

    }

}
