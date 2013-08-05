<?php

/**
 * (c) 2012-2013  Nicolas Devenet <nicolas@devenet.info>
 * Code source hosted on https://github.com/nicolabricot/FSC-Bezannes
 */

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
            else {
                echo 'Database configuration file not found';
                exit();
            }
        }
        self::$access++;
        return self::$instance;
    }

    static public function access() {
        return self::$access;
    }
}

?>
