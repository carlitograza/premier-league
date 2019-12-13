<?php

namespace App\Model;

use Illuminate\Support\Str;
use App\Http\Traits\PlayerTrait;

use Illuminate\Support\Facades\DB;

class PlayerModel
{

    use PlayerTrait;

    /*
     *  Database table name
    */
    protected $table = "players";

    /*
     *  Required Fields
    */
    protected $requiredFields = ["id", "code", "first_name"];

    // Properties
    protected $id;
    protected $chance_of_playing_next_round;
    protected $chance_of_playing_this_round;
    protected $code;
    protected $cost_change_event;
    protected $cost_change_event_fall;
    protected $cost_change_start;
    protected $cost_change_start_fall;
    protected $dreamteam_count;
    protected $element_type;
    protected $ep_next;
    protected $ep_this;
    protected $event_points;
    protected $first_name;
    protected $form;
    protected $in_dreamteam;
    protected $news;
    protected $news_added;
    protected $now_cost;
    protected $photo;
    protected $points_per_game;
    protected $second_name;
    protected $selected_by_percent;
    protected $special;
    protected $squad_number;
    protected $status;
    protected $team;
    protected $total_points;
    protected $transfers_in;
    protected $transfers_in_event;
    protected $transfers_out;
    protected $transfers_out_event;
    protected $value_form;
    protected $value_season;
    protected $web_name;
    protected $minutes;
    protected $goals_scored;
    protected $assists;
    protected $clean_sheets;
    protected $goals_conceded;
    protected $own_goals;
    protected $penalties_saved;
    protected $penalties_missed;
    protected $yellow_cards;
    protected $red_cards;
    protected $saves;
    protected $bonus;
    protected $bps;
    protected $influence;
    protected $creativity;
    protected $threat;
    protected $ict_index;

    public function save()
    {
        $player = [];
        foreach ($this->whiteListFields as $field) {
            $player[$field] = $this->$field;
        }

        // Validation
        // If Required fields are not set or empty
        // Skip that data
        if($this->testPlayerDataVsRequiredFields($player)) return false;

        $player["updated_at"] = date("Y-m-d H:i:s");

        // If record not exists
        // Insert
        $playerDB = DB::table($this->table)->where("id", $player["id"]);
        if (!$playerDB->first()) {
            $player["created_at"] = date("Y-m-d H:i:s");
            DB::table($this->table)->insert($player);
        }
        // If record exists
        // Update  
        else {
            $playerDB->update($player);
        }
    }

    // Validation
    // If Required fields are not set or empty
    // Skip that data
    public function testPlayerDataVsRequiredFields($player)
    {
        $isSkip = false;
        foreach ($this->requiredFields as $field) {
            if (empty($player[$field])) {
                $isSkip = true;
                break;
            }
        }
        return $isSkip;
    }

    public function set(array $player)
    {

        // Dynamic Setters
        foreach ($this->whiteListFields as $field) {
            $methodName = "set" . Str::studly($field);
            $this->$methodName(
                isset($player[$field]) ? $this->fixDataField($player[$field]) : null
            );
        }

        // Manual Setters
        // Set ID
        // $this->setId(
        //     isset($player["id"]) ? $player["id"] : null
        // );

        // Set Chance Of Playing Next Round
        // $this->setChanceOfPlayingNextRound(
        //     isset($player["chance_of_playing_next_round"]) ? $player["chance_of_playing_next_round"] : null
        // );

    }


    public function setId($val)
    {
        // Validation
        // End Validaton
        $this->id = $val;
    }

    public function setChanceOfPlayingNextRound($val)
    {
        // Validation
        // End Validaton
        $this->chance_of_playing_next_round = $val;
    }

    public function setChanceOfPlayingThisRound($val)
    {
        // Validation
        // End Validaton
        $this->chance_of_playing_this_round = $val;
    }

    public function setCode($val)
    {
        // Validation
        // End Validaton
        $this->code = $val;
    }

    public function setCostChangeEvent($val)
    {
        $this->cost_change_event = $val;
    }

    public function setCostChangeEventFall($val)
    {
        // Validation
        // End Validaton
        $this->cost_change_event_fall = $val;
    }

    public function setCostChangeStart($val)
    {
        // Validation
        // End Validaton
        $this->cost_change_start = $val;
    }

    public function setCostChangeStartFall($val)
    {
        // Validation
        // End Validaton
        $this->cost_change_start_fall = $val;
    }

    public function setDreamteamCount($val)
    {
        // Validation
        // End Validaton
        $this->dreamteam_count = $val;
    }
    public function setElementType($val)
    {
        // Validation
        // End Validaton
        $this->element_type = $val;
    }

    public function setEpNext($val)
    {
        // Validation
        // End Validaton
        $this->ep_next = $val;
    }

    public function setEpThis($val)
    {
        // Validation
        // End Validaton
        $this->ep_this = $val;
    }

    public function setEventPoints($val)
    {
        // Validation
        // End Validaton
        $this->event_points = $val;
    }

    public function setFirstName($val)
    {
        // Validation
        // End Validaton
        $this->first_name = $val;
    }

    public function setForm($val)
    {
        // Validation
        // End Validaton
        $this->form = $val;
    }

    public function setInDreamteam($val)
    {
        // Validation
        // End Validaton
        $this->in_dreamteam = $val;
    }

    public function setNews($val)
    {
        // Validation
        // End Validaton
        $this->news = $val;
    }

    public function setNewsAdded($val)
    {
        // Validation
        // End Validaton
        $this->news_added = $val;
    }

    public function setNowCost($val)
    {
        // Validation
        // End Validaton
        $this->now_cost = $val;
    }

    public function setPhoto($val)
    {
        // Validation
        // End Validaton
        $this->photo = $val;
    }

    public function setPointsPerGame($val)
    {
        // Validation
        // End Validaton
        $this->points_per_game = $val;
    }

    public function setSecondName($val)
    {
        // Validation
        // End Validaton
        $this->second_name = $val;
    }

    public function setSelectedByPercent($val)
    {
        // Validation
        // End Validaton
        $this->selected_by_percent = $val;
    }

    public function setSpecial($val)
    {
        // Validation
        // End Validaton
        $this->special = $val;
    }

    public function setSquadNumber($val)
    {
        // Validation
        // End Validaton
        $this->squad_number = $val;
    }

    public function setStatus($val)
    {
        // Validation
        // End Validaton
        $this->status = $val;
    }

    public function setTeam($val)
    {
        // Validation
        // End Validaton
        $this->team = $val;
    }

    public function setTotalPoints($val)
    {
        // Validation
        // End Validaton
        $this->total_points = $val;
    }

    public function setTransfersIn($val)
    {
        // Validation
        // End Validaton
        $this->transfers_in = $val;
    }

    public function setTransfersInEvent($val)
    {
        // Validation
        // End Validaton
        $this->transfers_in_event = $val;
    }

    public function setTransfersOut($val)
    {
        // Validation
        // End Validaton
        $this->transfers_out = $val;
    }

    public function setTransfersOutEvent($val)
    {
        // Validation
        // End Validaton
        $this->transfers_out_event = $val;
    }

    public function setValueForm($val)
    {
        // Validation
        // End Validaton
        $this->value_form = $val;
    }

    public function setValueSeason($val)
    {
        // Validation
        // End Validaton
        $this->value_season = $val;
    }

    public function setWebName($val)
    {
        // Validation
        // End Validaton
        $this->web_name = $val;
    }

    public function setMinutes($val)
    {
        // Validation
        // End Validaton
        $this->minutes = $val;
    }

    public function setGoalsScored($val)
    {
        // Validation
        // End Validaton
        $this->goals_scored = $val;
    }

    public function setAssists($val)
    {
        // Validation
        // End Validaton
        $this->assists = $val;
    }

    public function setCleanSheets($val)
    {
        // Validation
        // End Validaton
        $this->clean_sheets = $val;
    }

    public function setGoalsConceded($val)
    {
        // Validation
        // End Validaton
        $this->goals_conceded = $val;
    }

    public function setOwnGoals($val)
    {
        // Validation
        // End Validaton
        $this->own_goals = $val;
    }

    public function setPenaltiesSaved($val)
    {
        // Validation
        // End Validaton
        $this->penalties_saved = $val;
    }

    public function setPenaltiesMissed($val)
    {
        // Validation
        // End Validaton
        $this->penalties_missed = $val;
    }

    public function setYellowCards($val)
    {
        // Validation
        // End Validaton
        $this->yellow_cards = $val;
    }

    public function setRedCards($val)
    {
        // Validation
        // End Validaton
        $this->red_cards = $val;
    }

    public function setSaves($val)
    {
        // Validation
        // End Validaton
        $this->saves = $val;
    }

    public function setBonus($val)
    {
        // Validation
        // End Validaton
        $this->bonus = $val;
    }

    public function setBps($val)
    {
        // Validation
        // End Validaton
        $this->bps = $val;
    }

    public function setInfluence($val)
    {
        // Validation
        // End Validaton
        $this->influence = $val;
    }

    public function setCreativity($val)
    {
        // Validation
        // End Validaton
        $this->creativity = $val;
    }

    public function setThreat($val)
    {
        // Validation
        // End Validaton
        $this->threat = $val;
    }

    public function setIctIndex($val)
    {
        // Validation
        // End Validaton
        $this->ict_index = $val;
    }
}
