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
                ->select('notifications.user_id_event','notifications.user_id as id',
                 'notifications.type','notifications.message','users.name','users.phone','notifications.created_at','notifications.id_event','notifications.id as id_notification')
                ->where('notifications.user_id_event','=',$request->get('user_id'))
                ->get();

        return  $notifications;
     
    }

}
