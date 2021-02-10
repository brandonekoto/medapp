<?php

namespace composants;
use \PDO;

class DBProvider extends \PDO{
    public static $cnx ;
    //private $username  = "be";
    //private $pwd = "EBrandon*987@654";
    //private $username  = "root";
    //private $pwd = "admin123";
    private $params;
    
    //Prod 
    private $username  = "be";
    private $pwd = "EBrandon*987@694";
    

    public function __construct(array $params =[]) {        
        try{
            //Prod
            parent::__construct("mysql:host=102.68.62.39;port=3306;dbname=hsptalMgr;charset=UTF8", $this->username, $this->pwd);
            //Test
            //parent::__construct("mysql:host=102.68.62.42;port=3306;dbname=hsptalMgr;charset=UTF8", $this->username, $this->pwd);
            //Local dev
            //parent::__construct("mysql:host=127.0.0.1;dbname=managerhospital;charset=UTF8", $this->username, $this->pwd);
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
