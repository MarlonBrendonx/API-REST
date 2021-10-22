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
class DonationRepository {


    public function getDonation(Request $request){

        $doacao=DB::table('doacaos')
                ->select('doacaos.id as id_donation','doacaos.sobre','doacaos.link','doacaos.title','doacaos.users_id as users_id')
                ->get();

        return $doacao;

    }
    

}
