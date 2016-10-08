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
        
    }
    
    private static function fileStringFromArray($fileArr) {
        
    }
    
    public static function create($data) {
        
    }
    
    public static function getById($observationId) {
        
    }
    
    public static function getAll() {
        
    }
}