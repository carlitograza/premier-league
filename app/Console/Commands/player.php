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
    protected $url = 'http://localhost/premierleague/backend/public/data.xml/';
    //protected $url = 'https://fantasy.premierleague.com/api/bootstrap-static/';


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

        // Get Player From API and save to MySQL DB
        $getPlayer = $this->getAndSavePlayerData($this->url);

        // Check if response is success
        if (!$getPlayer["status"]) {
            // Log Error if not success
            Log::error($getPlayer['status_message']);
            return;
        } else {
            // Log Info if success
            Log::info("Auto Fetching Player: Success");
        }
    }

    public function getAndSavePlayerData(string $url)
    {

        // CUrl Process
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);

        $dataString = curl_exec($curl);

        // Check for Curl Error
        $isError = false;
        $errorMessage = "";
        $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if (curl_errno($curl) || $statusCode !== 200) {
            $isError = true;
            $errorMessage = "Auto Fetching Player: Unexpected HTTP code: " . $statusCode;
        }
        curl_close($curl);

        if ($isError) return array("status" => 0, "status_message" => $errorMessage);
        // Fetch Data into JSON and XML
        else return $this->fetchJSONXML($dataString);
    }

    // Convert Data into array from JSON or XML
    public function fetchJSONXML(string $playerString)
    {
        // Check if data is JSON
        $dataObj = json_decode($playerString);
        if ((json_last_error() == JSON_ERROR_NONE)) {
            $data = json_decode(json_encode($dataObj), true);
            if (!empty($data["elements"]))
                return $this->savePlayer($data["elements"]); // Return Players
        } else {

            // Check if data is XML
            libxml_use_internal_errors(true);
            $playerString = simplexml_load_string($playerString);
            if ($playerString) {
                $data = json_decode(json_encode($playerString), true);
                if (!empty($data["elements"]["element"]))
                    return $this->savePlayer($data["elements"]["element"]); // Return Players
            }
        }

        return array("status" => 0, "status_message" => "Auto Fetching Player: Invalid Data");
    }

    // Save Player
    public function savePlayer(array $players)
    {

        // $players = array_slice($players, 0, 1);

        //Create Player Model
        $data = [];
        foreach ($players as $player) {
            $playerObj = new PlayerModel();
            $playerObj->set($player);
            $playerObj->save();
        }

        return array("status" => 1);
    }


}
