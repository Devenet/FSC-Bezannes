<?php
namespace lib\db;
use PDO;

class SQL {
    private static $instance;
    private static $access = 0;

    static public function sql(){
       if (!isset(self::$instance)) {
            $file = dirname(__FILE__) . '/../../config/database.json';

            if (file_exists($file)) {
                $db = json_decode(file_get_contents($file));
                
                self::$instance = new PDO($db->dsn, $db->login, $db->password);
            
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$instance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                self::$instance->query('SET NAMES UTF8');
            }
            else
                throw new \Exception('Database file configuration not found');
        }
        self::$access++;
        return self::$instance;
    }

    static public function access() {
        return self::$access;
    }
}

?>
