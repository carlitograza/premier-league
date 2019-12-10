<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

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
        //
        //Fetch Data
        $curlSession = curl_init();
        //curl_setopt($curlSession, CURLOPT_URL, 'http://localhost/premierleague/backend/public/data.json');
        curl_setopt($curlSession, CURLOPT_URL, 'https://fantasy.premierleague.com/api/bootstrap-static/');
        curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);

        $responseString = curl_exec($curlSession);

        // Check if data is JSON
        if ((json_last_error() == JSON_ERROR_NONE)) {
            //Json
            $dataObj = json_decode($responseString);
            $data = json_decode(json_encode($dataObj), true);
            if (!empty($data["elements"])) {
                $players = $data["elements"];
                $this->saveToDatabase($players);
                return;
            }
        } else {

            // Check if data is XML
            libxml_use_internal_errors(true);
            $dataString = simplexml_load_string($responseString);
            if ($dataString) {
                // Valid XML
                $data = json_decode(json_encode($dataString), true);
                if (!empty($data["elements"]["element"])) {
                    $players = $data["elements"]["element"];
                    $this->saveToDatabase($players);
                    return;
                }
            }
        }
        curl_close($curlSession);
        return "Invalid Data";

    }

    public function saveToDatabase($players)
    {
        $data = [];
        foreach($players as $player){
            $fields = [
                'chance_of_playing_next_round', 
                'chance_of_playing_this_round',
                'code',
                'cost_change_event',
                'cost_change_event_fall',
                'cost_change_start',
                'cost_change_start_fall',
                'dreamteam_count',
                'element_type',
                'ep_next',
                'ep_this',
                'event_points',
                'first_name',
                'form',
                'p_id',
                'in_dreamteam',
                'news',
                'news_added',
                'now_cost',
                'photo',
                'points_per_game',
                'second_name',
                'selected_by_percent',
                'special',
                'squad_number',
                'status',
                'team',
                'total_points',
                'transfers_in',
                'transfers_in_event',
                'transfers_out',
                'transfers_out_event',
                'value_form',
                'value_season',
                'web_name',
                'minutes',
                'goals_scored',
                'assists',
                'clean_sheets',
                'goals_conceded',
                'own_goals',
                'penalties_saved',
                'penalties_missed',
                'yellow_cards',
                'red_cards',
                'saves',
                'bonus',
                'bps',
                'influence',
                'creativity',
                'threat',
                'ict_index'
            ];
            $dataRow = [];
            foreach($fields as $field){
                if($field === "p_id")
                    $dataRow[$field] =  !empty($player['id']) ? $player['id'] : null;
                else 
                    $dataRow[$field] = !empty($player[$field]) 
                                            ? 
                                                (is_array($player[$field] ))
                                                    ? json_encode($player[$field])
                                                    : $player[$field] 
                                            : null;
            }
            $data[] = $dataRow;
        }
        $tableName = 'players';
        DB::table($tableName)->delete(); // Truncate
        DB::table($tableName)->insert($data); // Insert
    }
}
