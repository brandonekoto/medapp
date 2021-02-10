<?php

namespace composants;
use \PDO;

class DBProvider extends \PDO{
    public static $cnx ;
    private $username  = "root";
    private $pwd = "serverdb2019";
    private $params;

    public function __construct(array $params =[]) {        
        try{
            parent::__construct("mysql:host=127.0.0.1;dbname=managehospital;charset=UTF8", $this->username, $this->pwd);
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8');
            $this->exec("SET SESSION sql_mode = ''");
        } catch (MDEException $ex) {
            var_dump($ex);
        }
    }
    public static function getInstace() {
        if(is_null(self::$cnx)){
            self::$cnx = new DBProvider();
        }
        return self::$cnx;
    }
}
