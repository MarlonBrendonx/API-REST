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
                'users.phone','users.id as user_id')
                ->get();

        $events=DB::table('events')
                ->select('events.id as id_event','events.type','events.latitude','events.longitude','events.status',
                'events.photos','events.information','users.id as user_id')
                ->join('users','events.user_id','=','users.id')
                ->whereNull('events.animal_id')
                ->get();

        return $events->merge($events_1);

    }

    public function getEventsbyToken(Request $request){

        $events_1=DB::table('events')
                ->join('animals', 'events.animal_id', '=', 'animals.id')
                ->join('users','animals.users_id','=','users.id')
                ->select('events.id as id_event','events.type','events.latitude','events.longitude','events.status',
                'events.photos','events.information','animals.name','animals.sex','animals.personality','users.name as username',
                'users.phone','users.id as user_id')
                ->where('users.remember_token','=',$request->get('token'))
                ->get();

        $events=DB::table('events')
                ->select('events.id as id_event','events.type','events.latitude','events.longitude','events.status',
                'events.photos','events.information','users.id as user_id')
                ->join('users','events.user_id','=','users.id')
                ->whereNull('events.animal_id')
                ->where('users.remember_token','=',$request->get('token'))
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

    public function changeStatusevent(Request $request){

        $status=DB::table('events')
              ->where('id', $request->get('event_id'))
              ->update(['status' => 'Em andamento']);

        return $status; 

    }

    public function searchEvent(Request $request){


        $events_1=DB::table('events')
                ->join('animals', 'events.animal_id', '=', 'animals.id')
                ->join('users','animals.users_id','=','users.id')
                ->select('events.id as id_event','events.type','events.latitude','events.longitude','events.status',
                'events.photos','events.information','animals.name','animals.sex','animals.personality','users.name as username',
                'users.phone','users.id as user_id')
                ->where('users.remember_token','=',$request->get('token'))
                ->where('animals.name', 'like', '%'.$request->get('search').'%')
                ->get();

        return $events_1;



    }




}
