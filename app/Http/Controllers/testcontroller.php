<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Model\PlayerModel;

class testcontroller extends Controller
{

    public function handle()
    {

        $player = new PlayerModel();
        $hasPlayer = true;
        if(!$player->get("1")) $hasPlayer = false;

        $url = "http://localhost/premierleague/backend/public/data_snake.json/";
        $importer = new \CGraza\DataImporter($url);     // Data Importer
        $response = $importer->toSnake()->get();

        $this->handleDifferentSourceType($response);
        Log::info("Auto Fetching Player: Success");
    }


    /**
     *  Handle Different Source Type
     *  from XML Type or JSON Type
     * @param
     *      array $response
     */ 
    public function handleDifferentSourceType(array $response)
    {
        // Fetch Player
        if ($response["source_type"] === 'json') {
            if (!empty($response["data"]["elements"]))
                $players = $response["data"]["elements"];
        } else {
            if (!empty($response["data"]["elements"]["element"]))
                $players = $response["data"]["elements"]["element"];
        }
        $this->savePlayer($players);
    }

    /**
     *  Save Player to DB
     * @param
     *      array $players
     */ 
    public function savePlayer(array $players)
    {
        foreach ($players as $player) {
            //Create Player Model
            $playerObj = new PlayerModel();
            $playerObj->set($player);
            dump($playerObj->save());
            break;
        }
    }
}
