<?php

/**
 * @SWG\Definition(
 *  required={
 *      "id",
 *      "first_name",
 *      "last_name"
 *   }
 *  )
 */

class User {
    
    /**
     * @SWG\Property()
     * @var int
     */
    public $id;
    
    /**
     * @SWG\Property()
     * @var string
     */
    public $first_name;
    
    /**
     * @SWG\Property()
     * @var string
     */
    public $last_name;
    
    /**
     * @SWG\Property()
     * @var string
     */
    public $full_name;
    
    function __construct($data) {
        $this->id = $data['Id'];
        $this->first_name = $data['First_name'];
        $this->last_name = $data['Last_name'];
        $this->full_name = $this->first_name . " " . $this->last_name;
    }
    
    //should only be created from POST request
    public static function create($fName, $lName) {
        $db = DB::getInstance();
        $userArr = array(
            'First_name' => $fName,
            'Last_name' => $lName
        );
        
        $user_id = $db->insert("User", $userArr);
        
        return User::getById($user_id);
    }
    
    //Should contain first_name and last_name
    public static function findOrCreate($user) {
        $fName = null;
        $lName = null;
        if (isset($user['first_name'])){
            $fName = $user['first_name'];
        }
        if (isset($user['First_name'])){
            $fName = $user['First_name'];
        }
        if (isset($user['last_name'])){
            $lName = $user['last_name'];
        }
        if (isset($user['Last_name'])){
            $lName = $user['Last_name'];
        }
        if ($fName == null){
            throw new Exception("Missing requried field: User::first_name", 400);
        }
        if ($lName == null){
            throw new Exception("Missing requried field: User::last_name", 400);
        }
        
        $db = DB::getInstance();
        $results = $db->select('User','*',[
            'First_name' => $fName,
            'Last_name' => $lName
        ]);
        
        $user = null;
        if (sizeof($results) != 1 || !$results){
            $user = User::create($fName, $lName);
        } else {
            $user = new User($results[0]);
        }
        
        if ($user == null){
            throw new Exception("An error occured finding/creating the user", 500);
        }
        return $user;
    }
    
    public static function getById($userId) {
        $db = DB::getInstance();
        $results = $db->select('User','*',[
            'Id' => $userId
        ]);
        
        if (sizeof($results) == 0 || !$results){
			throw new Exception("Invalid user ID", 400);
		}
        
        return new User($results[0]);
    }
    
    public static function getAll() {
        $db = DB::getInstance();
        $results = $db->select('User','*',[]);
        
        if (sizeof($results) == 0 || !$results){
			return array();
		}
        $users = array();
        for ($i=0; $i < sizeof($results); $i++){
            $u = new User($results[$i]);
            array_push($users, $u);
		}
        
        return $users;
    }
    
}