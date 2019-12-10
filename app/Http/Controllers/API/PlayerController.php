<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlayerController extends Controller
{
    /*
    *   Fetch All Player
    *   @param
    *   @response
    *       Array of Object
    */
    public function index(){
        return DB::table('players')->select('p_id as id', 'first_name', 'second_name')->get();
    }

    
    /*
    *   Fetch Single Player
    *   @param
    *       $id - player id
    *   @response
    *       Object
    */
    public function single($id){
        $player = DB::table('players')
            ->where('p_id', $id)
            ->first();
        return response()->json($player);
    }
}
