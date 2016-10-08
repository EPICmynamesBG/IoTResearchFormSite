<?php

/**
 * @SWG\Definition(
 *  required={
 *      "id",
 *      "manufacturer",
 *      "model"
 *   }
 *  )
 */

class Device {
    
    /**
     * @SWG\Property()
     * @var int
     */
    public $id;
    
    /**
     * @SWG\Property()
     * @var string
     */
    public $manufacturer;
    
    /**
     * @SWG\Property()
     * @var string
     */
    public $model;
    
    /**
     * @SWG\Property()
     * @var string
     */
    public $version;
    
    /**
     * @SWG\Property()
     * @var string
     */
    public $year_manufactured;
    
    function __construct($data) {
        $this->id = $data['Id'];
        $this->manufacturer = $data['Manufacturer'];
        $this->model = $data['Model'];
        if (isset($data['Version'])){
            $this->version = $data['Version'];
        } else {
            $this->version = null;
        }
        if (isset($data['Year_manufactured'])){
            $this->year_manufactured = $data['Year_manufactured'];
        } else {
            $this->year_manufactured = null;
        }
    }
    
    public static function create($manufacturer, $model, $version = null, $year_manufactured = null) {
        $db = DB::getInstance();
        $devArr = array(
            'Manufacturer' => $manufacturer,
            'Model' => $model,
            'Version' => $version,
            'Year_manufactured' => $year_manufactured
        );
        
        $dev_id = $db->insert("Device", $devArr);
        
        return Device::getById($dev_id);
    }
    
//    public static function search($text) {
//        
//        $db = DB::getInstance();
//        $results = $db->select('Device','*',[
//            'Manufacturer[~]' => $text,
//            ['OR' => ['Model[~]' => $text]],
//            ['OR' => ['Version[~]' => $text]],
//            ['OR' => ['Year_manufactured[~]' => $text]]
//        ]);
//        
//        if (sizeof($results) == 0 || !$results){
//            return array();
//        }
//        $devices = array();
//        for ($i=0; $i < sizeof($results); $i++){
//            $d = new Device($results[$i]);
//            array_push($devices, $d);
//		}
//        
//        return $devices;
//    }
    
    public static function getById($deviceId) {
        $db = DB::getInstance();
        $results = $db->select('Device','*',[
            'Id' => $deviceId
        ]);
        
        if (sizeof($results) == 0 || !$results){
			throw new Exception("Invalid device ID", 400);
		}
        
        return new Device($results[0]);
    }
    
    public static function getAll() {
        $db = DB::getInstance();
        $results = $db->select('Device','*',[]);
        
        if (sizeof($results) == 0 || !$results){
			return array();
		}
        $devices = array();
        for ($i=0; $i < sizeof($results); $i++){
            $d = new Device($results[$i]);
            array_push($devices, $d);
		}
        
        return $devices;
    }
    
}