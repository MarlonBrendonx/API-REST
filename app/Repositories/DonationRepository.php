<?php

namespace App\Repositories;
use Illuminate\Http\Request; 
use App\Models\Adocao;
use App\Models\User;
use Illuminate\Support\Facades\DB;
/**
 * Class ConvenioRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class DonationRepository {


    public function getDonation(Request $request){

        $doacao=DB::table('doacaos')
                ->select('doacaos.id as id_donation','doacaos.sobre','doacaos.link','doacaos.title','doacaos.users_id as users_id')
                ->get();

        return $doacao;

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
