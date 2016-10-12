<?php

/**
 * @SWG\Definition(
 *  required={
 *      "id",
 *      "name"
 *   }
 *  )
 */

class Tool {
    
    /**
     * @SWG\Property()
     * @var int
     */
    public $id;
    
    /**
     * @SWG\Property()
     * @var string
     */
    public $name;
    
    function __construct($data) {
        $this->id = $data['Id'];
        $this->name = $data['Name'];
    }
    
    public static function create($name) {
        $db = DB::getInstance();
        $toolArr = array(
            'Name' => $name
        );
        
        $tool_id = $db->insert("Tool", $toolArr);
        
        if (!$tool_id || $tool_id == 0){
            throw new Exception("Tool insert error", 500);
        }
        
        return Tool::getById($tool_id);
    }
    
    public static function findOrCreate($tool) {
        if (!isset($tool['name'])){
            throw new Exception("Missing requried field: Tool::name", 400);
        }
        
        $db = DB::getInstance();
        $results = $db->select('Tool','*',[
            'Name' => $tool['name']
        ]);
        
        if (sizeof($results) != 1 || !$results){
            if (sizeof($results) > 1){
                throw new Exception("Multiple tools with given name exist", 500);
            }
            return Tool::create($tool['name']);
        }
        
        return new Tool($results[0]);
    }
    
//    public static function search($text) {
//        if (!isset($toolName)){
//            throw new Exception("Missing requried field: Tool::name", 400);
//        }
//        
//        $db = DB::getInstance();
//        $results = $db->select('Tool','*',[
//            'Name[~]' => $toolName
//        ]);
//        
//        if (sizeof($results) == 0){
//            return array();
//        }
//        
//        $tools = array();
//        for ($i=0; $i < sizeof($results); $i++){
//            $t = new Tool($results[$i]);
//            array_push($tools, $t);
//		}
//        
//        return $tools;
//    }
    
    public static function getById($toolId) {
        $db = DB::getInstance();
        $results = $db->select('Tool','*',[
            'Id' => $toolId
        ]);
        
        if (sizeof($results) == 0 || !$results){
			return null;
		}
        
        return new Tool($results[0]);
    }
    
    public static function getAll() {
        $db = DB::getInstance();
        $results = $db->select('Tool','*',[]);
        
        if (sizeof($results) == 0 || !$results){
			return array();
		}
        $tools = array();
        for ($i=0; $i < sizeof($results); $i++){
            $t = new Tool($results[$i]);
            array_push($tools, $t);
		}
        
        return $tools;
    }
    
}
