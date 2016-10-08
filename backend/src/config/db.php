<?php
class DB {

    protected function __construct() {}

    public static function getInstance()
    {
        global $CONFIG;
        $db = new medoo([
            'database_type' => 'mysql',
            'database_name' => $CONFIG['server_db'],
            'server' => $CONFIG['server_name'],
            'username' => $CONFIG['server_user'],
            'password' => $CONFIG['server_pass'],
            'port' => $CONFIG['server_port'],
            'charset' => 'utf8'
        ]);

        return $db;
    }

    public static function handleError($db) {
        $errorString = $db->error()[2];
        if (sizeof($errorString) > 0) {
            throw new Exception($errorString, 400);
        }
    }
}
