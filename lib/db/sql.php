<?php
namespace lib\db;
use PDO;

class SQL {
    private static $instance;
    private static $access = 0;
    private static $file = '../config/database.json';

    static public function sql(){
        if (!isset(self::$instance)){
            
            if (file_exists(self::$file)) {
                $db = json_decode(file_get_contents(self::$file));
                
                self::$instance = new PDO($db->dsn, $db->login, $db->foyer);
            
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$instance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            }
            else
                throw new \Exception('DataBase file configuration not found');
        }
        //self::$instance->query('SET NAMES UTF8');
        self::$access++;
        return self::$instance;
    }

    static public function access() {
        return self::$access;
    }
}

?>
