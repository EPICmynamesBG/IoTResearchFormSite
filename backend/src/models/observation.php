<?php

/**
 * @SWG\Definition(
 *  required={
 *      "id",
 *      "user_1",
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
        $arr['tool'] = $this->tool;
        $arr['toolParams'] = $this->tool_params;
        $arr['observations'] = $this->observations;
        if (isset($this->implications)){
            $arr['implications'] = $this->implications;
        }
        $arr['files'] = $this->files;
        return $arr;
    }
        
    
    const $delimiter = ",";
    private static function fileArrayFromString($fileStr) {
        $fileStr = str_replace(" ", "", $fileStr);
        $urls = explode($delimiter, $fileStr);
        return $urls;
    }
    
    private static function fileStringFromArray($fileArr) {
        $str = "";
        for ($i=0; $i < sizeof($fileArr); $i++){
            $obj = $fileArr[$i];
            
            $str += $obj . $delimiter . " ";
		}
        $str = substr($str, 0, -2);
        return $str;
    }
    
    public static function create($data) {
        if (!isset($data['user_1'])){
            throw new Exception("Missing parameter: Observation::user_1", 400);
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
        
        $user1 = null, $user2 = null;
        if (gettype($data['user_1']) == 'string') {
            $user1 = User::getById($data['user1']); 
        } else if (gettype($data['user_1']) == 'array') {
            $user1 = User::findOrCreate($data['user_1']);
        } else {
            throw new Exception("Invalid data type for Observation:User_1.", 400);
        }
        
        if (isset($data['user_2'])){
            if (gettype($data['user_2']) == 'string') {
                $user2 = User::getById($data['user2']); 
            } else if (gettype($data['user_2']) == 'array') {
                $user2 = User::findOrCreate($data['user_2']);
            } else {
                throw new Exception("Invalid data type for Observation:User_2.", 400);
            }
        }
        //convert categories to array
        $catArr = array();
        for ($i = 0; $i < sizeof($data['categories']); $i++){
            $cat = Category::getById($data['categories'][$i]);
            array_push($catArr, $cat);
        }
        $categories = Category::categoriesStringFromArray($catArr);
        
        $tool = Tool::getById($data['tool']);
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
            'User_1' => $user1,
            'User_2' => $user2,
            'Categories' => $categories,
            'Tool' => $tool,
            'Tool_parameters' => $toolParams,
            'Observations' => $obs,
            'Implications' => $implications,
            'Files' => $files
        );
        
        $db = DB::getInstance();
        $obs_id = $db->insert("Observation", $observation);
        
        return Observation::getById($obs_id);
    }
    
    public static function getById($observationId) {
        $db = DB::getInstance();
        $results = $db->select('Observation','*',[
            'Id' => $observationId
        ]);
        
        if (sizeof($results) == 0 || !$results){
			throw new Exception("Invalid observation ID", 400);
		}
        
        return new Observation($results[0]);
    }
    
    public static function getAll() {
        $db = DB::getInstance();
        $results = $db->select('Tool','*',[]);
        
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