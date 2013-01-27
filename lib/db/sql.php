<?php
namespace lib\db;
use PDO;

class SQL {
    private static $instance;

    static public function sql(){
        if(!isset(self::$instance)){
            //self::$instance = new PDO('mysql:host=mysql51-40.perso;dbname=bezannesfsc', 'bezannesfsc', 'Zdu32xdZ');
            self::$instance = new PDO('mysql:host=localhost;dbname=foyer', 'foyer', 'foyer');
            
            self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$instance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        }
        self::$instance->query('SET NAMES UTF8');
        return self::$instance;
    }
}

?>
