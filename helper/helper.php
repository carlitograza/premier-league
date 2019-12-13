<?php

/*
 *  Array Keys to new Naming Convention
 *  @param
 *      array $arrays   |   required
 *      string $type    |   required
 *  
*/
function array_keys_to_new_naming_convention($arrays, $type){

    if(!in_array(strtolower($type), ["snake", "studly", "camel"])) return $arrays;

    $newArrays = [];
    foreach($arrays as $key => $array){
        if(is_array($array) && count($array) > 0){
            $newArrays[\Illuminate\Support\Str::$type($key)] = array_keys_to_new_naming_convention($array, $type);
        }else {
            $newArrays[\Illuminate\Support\Str::$type($key)] = $array;
        }
    }
    return $newArrays;
}

