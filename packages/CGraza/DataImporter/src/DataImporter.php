<?php

namespace CGraza;

class DataImporter
{

    protected $url;
    protected $source_type;
    protected $data;

    /**
     *  Set URL and validate
     * 
     *  @param
     *      string URL  |   required
     *  @response
     *      Object
     */
    public function __construct($url)
    {

        // Validate if Valid URL
        if (!filter_var($url, FILTER_VALIDATE_URL))
            throw new \Exception("Invalid URL");

        $this->url = $url;
        $this->fetch();
    }

    /**
     *  Get Data From Remote URL
     *  Can import XML or JSON Data
     * 
     * 
     */
    protected function fetch()
    {
        $curl = curl_init($this->url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);

        $dataString = curl_exec($curl);

        // Check for Curl Error
        $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if (curl_errno($curl) || $statusCode !== 200)
            throw new \Exception("Unexpected HTTP code: " . $statusCode);

        curl_close($curl);
        return $this->fetchJSONXML($dataString);
    }

    /**
     *  Convert String of Data into array from JSON or XML
     *  @param
     *      string $playerString    |   required
     *
     */
    protected function fetchJSONXML(string $dataString)
    {
        // Check if data is JSON
        $dataObj = json_decode($dataString);
        if ((json_last_error() == JSON_ERROR_NONE)) {
            $this->source_type = 'json';
            $this->data = json_decode(json_encode($dataObj), true);
            return $this;
        } else {
            // Check if data is XML
            libxml_use_internal_errors(true);
            $dataString = simplexml_load_string($dataString);
            if ($dataString) {
                $this->source_type = 'xml';
                $this->data = json_decode(json_encode($dataString), true);
                return $this;
            }
        }

        throw new \Exception("Invalid Data Format");
    }


    /**
     * Get Data
     * @response
     *      Array   |   Data
     */
    public function get()
    {
        return [
            "source_type" => $this->source_type,
            "data" => $this->data
        ];
    }


    /**
     * Convert Data to Camel Case
     * 
     */
    public function toCamel()
    {
        $this->data = array_keys_to_new_naming_convention($this->data, "camel");
        return $this;
    }


    /**
     * Convert Data to Snake Case
     * 
     */
    public function toSnake()
    {
        $this->data = array_keys_to_new_naming_convention($this->data, "snake");
        return $this;
    }


    /**
     * Convert Data to Studly Case
     * 
     */
    public function toStudly()
    {
        $this->data = array_keys_to_new_naming_convention($this->data, "studly");
        return $this;
    }
}
