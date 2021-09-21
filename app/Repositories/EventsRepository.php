<?php

namespace App\Repositories;
use Illuminate\Http\Request; 
use App\Models\Events;
use Illuminate\Support\Facades\DB;
/**
 * Class ConvenioRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class EventsRepository {


    public function getEvents(){

        $events_1=DB::table('events')
                ->join('animals', 'events.animal_id', '=', 'animals.id')
                ->join('users','animals.users_id','=','users.id')
                ->select('events.id as id_event','events.type','events.latitude','events.longitude','events.status',
                'events.photos','events.information','animals.name','animals.sex','animals.personality','users.name as username',
                'users.phone')
                ->get();

        $events=DB::table('events')
                ->select('events.id as id_event','events.type','events.latitude','events.longitude','events.status',
                'events.photos','events.information')
                ->whereNull('events.animal_id')
                ->get();

        return $events->merge($events_1);

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
