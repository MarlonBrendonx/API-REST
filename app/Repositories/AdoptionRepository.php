<?php

namespace App\Repositories;
use Illuminate\Http\Request; 
use App\Models\Adocao;
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
