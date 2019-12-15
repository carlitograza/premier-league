<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

use App\Model\PlayerModel;


class player extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'player:get';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetching Player Remote from API';

    /**
     * API URL for players
     *
     * @var string
     */
    //protected $url = 'https://fantasy.premierleague.com/api/bootstrap-static/';
    //protected $url = 'https://utils.crmweb.com.ph/premierleague/public/data.xml';
    protected $url = 'https://utils.crmweb.com.ph/premierleague/public/data_snake.json';
    //protected $url = 'https://utils.crmweb.com.ph/premierleague/public/data_camel.json';
    //protected $url = 'https://utils.crmweb.com.ph/premierleague/public/data_studly.json';


    /**
     * Data Naming Convention
     *
     * @var string
     */
    protected $defaultNamingConvention = "snake"; // studly, camel, snake

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $importer = new \CGraza\DataImporter($this->url);     // Data Importer
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
            $playerObj->save();
        }
    }


}
