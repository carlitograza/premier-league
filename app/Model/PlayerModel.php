<?php

namespace App\Model;

use Illuminate\Support\Str;
use App\Http\Traits\PlayerTrait;

use Illuminate\Support\Facades\DB;

class PlayerModel
{

    use PlayerTrait;

    /**
     *  Database table name
     */
    protected $table = "players";

    /**
     *  Required Fields
     */
    protected $requiredFields = ["id", "code", "first_name"];

   

    /**
     *  Save Player to Database - INSERT OR UPDATE
     * 
     */
    public function save()
    {
        $player = [];
        foreach ($this->whiteListFields as $field) {
            $player[$field] = $this->$field;
        }

        // Validation
        // If Required fields are not set or empty
        // Skip that data
        if ($this->testPlayerDataVsRequiredFields($player)) return false;

        $player["updated_at"] = date("Y-m-d H:i:s");

        // If record not exists
        // Insert
        $playerDB = DB::table($this->table)->where("id", $player["id"]);
        if (!$playerDB->first()) {
            $player["created_at"] = date("Y-m-d H:i:s");
            return DB::table($this->table)->insert($player);
        }
        // If record exists
        // Update  
        else {
            return $playerDB->update($player);
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

    /**
     * GET
     * 
     */
    public function get($id) {
        return DB::table('players')
            ->where('id', $id)
            ->first();
    }


    /**
     *  SET
     * 
     */
    public function set(array $player)
    {

        // Dynamic Setters
        foreach ($this->whiteListFields as $field) {
            $methodName = "set" . Str::studly($field);
            $this->$methodName(
                isset($player[$field]) ? $this->fixDataField($player[$field]) : null
            );
        }
    }


    
}
