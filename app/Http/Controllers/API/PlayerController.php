<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Traits\PlayerTrait;
use App\Model\PlayerModel;

class PlayerController extends Controller
{

    use PlayerTrait;

    /*
    *   Fetch All Player
    *   @param
    *   @response
    *       Array of Object
    */
    public function index()
    {        
        $orderBy = !empty($_GET['order_by']) ? $_GET['order_by'] : 'desc';
        $orderByField = !empty($_GET['order_by_field']) ? $_GET['order_by_field'] : 'id';
        $searchKeyword = !empty($_GET['search_keyword']) ? '%'.$_GET['search_keyword'].'%' : '%';

        $players = DB::table('players')
            ->select('id', 'first_name', 'second_name')
            ->orderBy(in_array($orderByField, $this->whiteListFields) ? $orderByField : "id", $orderBy)
            ->where('first_name', 'like', $searchKeyword)
            ->orWhere('second_name', 'like', $searchKeyword);

        // Pagination Size
        // If no page_size param then get all results
        if (!empty($_GET['page_size']))
            $players = $players->paginate($_GET['page_size'])->items();
        else
            $players = $players->get();

        return $players;
    }


    /*
    *   Fetch Single Player
    *   @param
    *       $id - player id
    *   @response
    *       Object
    */
    public function single($id)
    {
        $player = new PlayerModel();
        return response()->json($player->get($id));
    }
}
