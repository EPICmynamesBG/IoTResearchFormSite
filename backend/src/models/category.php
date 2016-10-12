<?php

/**
 * @SWG\Definition(
 *  required={
 *      "id",
 *      "name"
 *   }
 *  )
 */

class Category {
    
    /**
     * @SWG\Property(default="I3")
     * @var int
     */
    public $id;
    
    /**
     * @SWG\Property(default="Insecure Network Services")
     * @var string
     */
    public $name;
    
    /**
     * @SWG\Property()
     * @var string
     */
    public $description;
    
    function __construct($data) {
        $this->id = $data['Id'];
        $this->name = $data['Name'];
        if (isset($data['Description']) && $data['Description'] != null){
            $this->description = $data['Description'];
        } else {
            $this->description = null;
        }
        
    }
    
    public static function getById($catId) {
        $db = DB::getInstance();
        $results = $db->select('Category','*',[
            'Id' => $catId
        ]);
        
        if (sizeof($results) == 0 || !$results){
			return null;
		}
        
        return new Category($results[0]);
    }
    
    public static function getAll() {
        $db = DB::getInstance();
        $results = $db->select('Category','*',[]);
        
        if (sizeof($results) == 0 || !$results){
			return array();
		}
        $categories = array();
        for ($i=0; $i < sizeof($results); $i++){
            $c = new Category($results[$i]);
            array_push($categories, $c);
		}
        
        return $categories;
    }
    
    const delimiter = ",";
    public static function categoriesFromString($catStr) {
        $catStr = str_replace(" ", "", $catStr);
        $categories = explode(self::delimiter, $catStr);
        
        $response = array();
        for ($i=0; $i < sizeof($categories); $i++){
            $c = Category::getById($categories[$i]);
            array_push($response, $c);
		}
        return $response;
    }
    
    public static function categoriesStringFromArray($catArr) {
        $str = "";
        for ($i=0; $i < sizeof($catArr); $i++){
            $obj = $catArr[$i];
            if (gettype($obj) == "string"){
                $obj = Category::getById($obj);
            }
            $str .= $obj->id . self::delimiter . " ";
		}
        $str = substr($str, 0, -2);
        return $str;
    }
    
}
