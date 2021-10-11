<?php

namespace App\Repositories;
use Illuminate\Http\Request; 
use App\Models\Notifications;
use Illuminate\Support\Facades\DB;
/**
 * Class ConvenioRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class NotificationsRepository {


    public function getNotificationsById(Request $request){


        $notifications=DB::table('users')
                ->join('notifications', 'notifications.user_id', '=', 'users.id')
                ->select('notifications.user_id_event as id','notifications.user_id','notifications.type','notifications.message','users.name')
                ->where('users.id','=',$request->get('user_id'))
                ->get();

    
        return  $notifications;
     
    }

}
