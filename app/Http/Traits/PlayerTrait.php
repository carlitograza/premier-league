<?php

namespace App\Http\Traits;

use Illuminate\Support\Str;

trait PlayerTrait
{
    // White fields
    protected $whiteListFields = [
        'id',
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

    // Handle XML Attributes
    public function fixDataField($value)
    {
        $fixedValue = "";
        if (is_array($value) && count($value) > 0) {
            if (!empty($value["@attributes"]))
                if ($value["@attributes"]["null"])
                    $fixedValue = null;
        } else {
            // Handle if value is an array but no value or count at all
            // Applicable only for XML
            if (is_array($value) && count($value) == 0)
                $fixedValue = "";
            else
                $fixedValue = $value;
        }
        return $fixedValue;
    }


}
