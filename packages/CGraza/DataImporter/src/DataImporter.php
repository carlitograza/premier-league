<?php

namespace CGraza;

class DataImporter
{

    /*
     *  Fetch Data From Remote URL
     *  Can import XML or JSON Data
     * 
     * 
    */
    public static function fetch(string $url, $convention = null)
    {
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
            $errorMessage = "Unexpected HTTP code: " . $statusCode;
        }
        curl_close($curl);

        if ($isError) return array("status" => 0, "status_message" => $errorMessage);
        // Convert String of Data into array from JSON or XML
        else return self::fetchJSONXML($dataString, $convention);

    }

    // 
    /*
     *  Convert String of Data into array from JSON or XML
     *  @param
     *      string $playerString    |   required
     *
    */
    public static function fetchJSONXML(string $dataString, $convention)
    {
        // Check if data is JSON
        $dataObj = json_decode($dataString);
        if ((json_last_error() == JSON_ERROR_NONE)) {
            return [
                "status" => 1,
                "source_type" => "json",
                "data" => self::handleNamingConvention($dataObj, $convention)
            ];
        } else {
            // Check if data is XML
            libxml_use_internal_errors(true);
            $dataString = simplexml_load_string($dataString);
            if ($dataString) 
                return [
                    "status" => 1,
                    "source_type" => "xml",
                    "data" => self::handleNamingConvention($dataString, $convention)
                ];
               
        }

        return array("status" => 0, "status_message" => "Invalid Data");
    }


    /*
     *  Handle Naming Convention if applicable
     *  @param
     *      string $data            |   required
     *      string $convention      |   required      studly, camel, snake
     *
    */
    public static function handleNamingConvention($data, $convention){
        $data = json_decode(json_encode($data), true);
        if(!empty($convention)) 
            $data = array_keys_to_new_naming_convention($data, $convention); // Handle New Naming Convention
        return $data;
    }



}
