<?php

require_once "Category.php";
require_once "Device.php";
require_once "Tool.php";
require_once "User.php";
/**
 * @SWG\Definition(
 *  required={
 *      "id",
 *      "user_1",
 *      "device",
 *      "categories",
 *      "tool",
 *      "tool_params",
 *      "observations"
 *   }
 *  )
 */

class Observation implements JsonSerializable {
    
    /**
     * @SWG\Property()
     * @var int
     */
    public $id;
    
    /**
     * @SWG\Property()
     * @var User
     */
    public $user_1;
    
    /**
     * @SWG\Property()
     * @var User
     */
    public $user_2;
    
    /**
     * @SWG\Property()
     * @var Device
     */
    public $device;
    
    /**
     * @SWG\Property()
     * @var array
     */
    public $categories;
    
    /**
     * @SWG\Property()
     * @var Tool
     */
    public $tool;
    
    /**
     * @SWG\Property()
     * @var string
     */
    public $tool_params;
    
    /**
     * @SWG\Property()
     * @var string
     */
    public $observations;
    
    /**
     * @SWG\Property()
     * @var string
     */
    public $implications;
    
    /**
     * @SWG\Property()
     * @var array
     */
    public $files;
    
    function __construct($data) {
        $this->id = $data['Id'];
        $this->user_1 = User::getById($data['User_1']);
        if (isset($data['User_2']) && $data['User_2'] != null){
            $this->user_2 = User::getById($data['User_2']);
        } else {
            $this->user_2 = null;
        }
        $this->device = Device::getById($data['Device']);
        $this->categories = Category::categoriesFromString($data['Categories']);
        $this->tool = Tool::getById($data['Tool']);
        $this->tool_params = $data['Tool_parameters'];
        $this->observations = $data['Observations'];
        if (isset($data['Implications']) && $data['Implications'] != null){
            $this->implications = $data['Implications'];
        } else {
            $this->implications = null;
        }
        if (isset($data['Files']) && $data['Files'] != null){
            $this->files = Observation::fileArrayFromString($data['Files']);
        } else {
            $this->files = null;
        }
    }
    
    function jsonSerialize() {
        $arr = array();
        
        $arr['id'] = $this->id;
        $users = array();
        array_push($users, $this->user_1);
        if (isset($this->user_2)){
            array_push($users, $this->user_2);
        }
        
        $arr['users'] = $users;
        $arr['device'] = $this->device;
        $arr['tool'] = $this->tool;
        $arr['toolParams'] = $this->tool_params;
        $arr['observations'] = $this->observations;
        $arr['implications'] = $this->implications;
        $arr['files'] = $this->files;
        return $arr;
    }
        
    function toArray() {
        $arr = array();
        
        $arr['user1'] = $this->user_1->full_name;
        if (isset($this->user_2)){
            $arr['user2'] = $this->user_2->full_name;
        } else {
            $arr['user2'] = "";
        }
        $arr['device_manufacturer'] = $this->device->manufacturer;
        $arr['device_model'] = $this->device->model;
        $arr['device_version'] = $this->device->version;
        $arr['device_year_manufactured'] = $this->device->year_manufactured;
        
        $arr['categories'] = Category::categoriesStringFromArray($this->categories);
        
        $arr['tool'] = $this->tool->name;
        $arr['toolParams'] = $this->tool_params;
        $arr['observations'] = $this->observations;
        $arr['implications'] = $this->implications;
        $arr['files'] = Observation::fileStringFromArray($this->files);
        return $arr;
    }
    
    const delimiter = ",";
    private static function fileArrayFromString($fileStr) {
        $fileStr = str_replace(" ", "", $fileStr);
        $urls = explode(self::delimiter, $fileStr);
        return $urls;
    }
    
    private static function fileStringFromArray($fileArr) {
        $str = "";
        for ($i=0; $i < sizeof($fileArr); $i++){
            $obj = $fileArr[$i];
            $str .= $obj . self::delimiter . " ";
		}
        $str = substr($str, 0, -2);
        return $str;
    }
    
    public static function create($data) {
        if (!isset($data['user_1'])){
            throw new Exception("Missing parameter: Observation::user_1", 400);
        }
        if (!isset($data['device'])){
            throw new Exception("Missing parameter: Observation::device", 400);
        }
        if (!isset($data['categories'])){
            throw new Exception("Missing parameter: Observation::categories", 400);
        }
        if (!isset($data['tool'])){
            throw new Exception("Missing parameter: Observation::tool", 400);
        }
        if (!isset($data['toolParams'])){
            throw new Exception("Missing parameter: Observation::toolParams", 400);
        }
        if (!isset($data['observations'])){
            throw new Exception("Missing parameter: Observation::observations", 400);
        }
        
        $user1 = null;
        $user2 = null;
        $user1_id = null;
        $user2_id = null;
        if (gettype($data['user_1']) == 'string') {
            $user1 = User::getById($data['user_1']);
            $user1_id = $user1->id;
        } else if (gettype($data['user_1']) == 'array') {
            $user1 = User::findOrCreate($data['user_1']);
            $user1_id = $user1->id;
        } else {
            throw new Exception("Invalid data type for Observation:User_1.", 400);
        }
        
        
        if (isset($data['user_2'])){
            if (gettype($data['user_2']) == 'string') {
                $user2 = User::getById($data['user_2']); 
                $user2_id = $user2->id;
            } else if (gettype($data['user_2']) == 'array') {
                $user2 = User::findOrCreate($data['user_2']);
                $user2_id = $user2->id;
            } else {
                throw new Exception("Invalid data type for Observation:User_2.", 400);
            }
        }
        
        $device = Device::getById($data['device']);
        if ($device == null) {
            $device = Device::findOrCreate($data['device']);
        }
        
        //convert categories to array
        $catArr = array();
        for ($i = 0; $i < sizeof($data['categories']); $i++){
            $cat = Category::getById($data['categories'][$i]);
            array_push($catArr, $cat);
        }
        $categories = Category::categoriesStringFromArray($catArr);
        
        $tool = Tool::getById($data['tool']);
        if ($tool == null) {
            $tool = Tool::findOrCreate($data['tool']);
        }
        $toolParams = $data['toolParams'];
        $obs = $data['observations'];
        $implications = null;
        if (isset($data['implications'])){
            $implications = $data['implications'];
        }
        $files = null;
        if (isset($data['files'])){
            $files = Observation::fileStringFromArray($data['files']);
        }
        
        $observation = array(
            'User_1' => $user1_id,
            'User_2' => $user2_id,
            'Device' => $device->id,
            'Categories' => $categories,
            'Tool' => $tool->id,
            'Tool_parameters' => $toolParams,
            'Observations' => $obs,
            'Implications' => $implications,
            'Files' => $files
        );
        
        $db = DB::getInstance();
        $obs_id = $db->insert("Observation", $observation);
        if ($obs_id == 0){
            throw new Exception("Observation creation error", 500);
        }
        
        return Observation::getById($obs_id);
    }
    
    public static function getById($observationId) {
        $db = DB::getInstance();
        $results = $db->select('Observation','*',[
            'Id' => $observationId
        ]);
        
        if (sizeof($results) == 0 || !$results){
			throw new Exception("Unable to find observation with ID ". $observationID, 400);
		}
        
        return new Observation($results[0]);
    }
    
    public static function getAll() {
        $db = DB::getInstance();
        $results = $db->select('Observation','*',[]);
        
        if (sizeof($results) == 0 || !$results){
			return array();
		}
        $obs = array();
        for ($i=0; $i < sizeof($results); $i++){
            $o = new Observation($results[$i]);
            array_push($obs, $o);
		}
        
        return $obs;
    }
}
