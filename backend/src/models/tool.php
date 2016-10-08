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
        
        return Tool::getById($tool_id);
    }
    
    public static function findOrCreate($toolName) {
        if (!isset($toolName)){
            throw new Exception("Missing requried field: Tool::name", 400);
        }
        
        $db = DB::getInstance();
        $results = $db->select('Tool','*',[
            'Name' => $toolName
        ]);
        
        $tool = null;
        if (sizeof($results) != 1 || !$results){
            $tool = Tool::create($toolName);
        } else {
            $tool = new Tool($results[0]);
        }
        
        if ($tool == null){
            throw new Exception("An error occured finding/creating the tool", 500);
        }
        return $tool;
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
			throw new Exception("Invalid tool ID", 400);
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