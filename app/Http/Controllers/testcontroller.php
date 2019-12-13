<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Model\PlayerModel;

class testcontroller extends Controller
{

    protected $url = 'http://localhost/premierleague/backend/public/data_camel.json/';
    //protected $url = 'http://localhost/premierleague/backend/public/data.xml/';

    public function handle()
    {

        $importer = \CGraza\DataImporter::fetch($this->url, "snake");
        dump($importer);

        // Check if response is success
        // if (!$importer["status"]) {
        //     // Log Error if not success
        //     Log::error("Auto Fetching Player: ". $importer['status_message']);
        //     return;
        // } else {
        //     // Log Info if success
        //     Log::info("Auto Fetching Player: Success");
        // }


    }

    /*
     *  Fetch Data from URL the save to MYSQL DB
     *  @return
     *      array status
     * 
    */
    public function getAndSavePlayerData()
    {
        // Get Data from URL
        // CUrl Process
        $curl = curl_init($this->url);
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
        // Convert String of Data into array from JSON or XML
        else return $this->fetchJSONXML($dataString);
    }

    // 
    /*
     *  Convert String of Data into array from JSON or XML
     *  @param
     *      string $playerString    |   required
     *
    */
    public function fetchJSONXML(string $playerString)
    {
        // Check if data is JSON
        $dataObj = json_decode($playerString);
        if ((json_last_error() == JSON_ERROR_NONE)) {
            $data = json_decode(json_encode($dataObj), true);
            $data = array_keys_to_new_naming_convention($data, "snake"); // Handle Naming Convention
            if (!empty($data["elements"]))
                return $this->savePlayer($data["elements"]); // Return Players
        } else {
            // Check if data is XML
            libxml_use_internal_errors(true);
            $playerString = simplexml_load_string($playerString);
            if ($playerString) {
                $data = json_decode(json_encode($playerString), true);
                $data = array_keys_to_new_naming_convention($data, "snake"); // Handle Naming Convention
                if (!empty($data["elements"]["element"]))
                    return $this->savePlayer($data["elements"]["element"]); // Return Players
            }
        }

        return array("status" => 0, "status_message" => "Auto Fetching Player: Invalid Data");
    }

    // Save Player
    public function savePlayer(array $players)
    {
        $data = [];
        foreach ($players as $player) {
            //Create Player Model
            $playerObj = new PlayerModel();
            $playerObj->set($player);
            $playerObj->save();
        }
        return array("status" => 1);
    }
}
