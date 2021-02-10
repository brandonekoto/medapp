<?php
    
    function autoload($class){        
        if (strstr($_SERVER['SERVER_ADDR'], "127.0.0.1")) {
            try {
                require_once $_SERVER["DOCUMENT_ROOT"] . DS . str_replace("\\", "/", $class) .".php";
            } catch (Exception $ex) {
                new \composants\MDEException($ex);
            }            
        }else{
            try {
                require_once $_SERVER["DOCUMENT_ROOT"] . DS. str_replace("\\", "/", $class) .".php";
            } catch (Exception $ex) {
                throw  new \composants\MDEException($ex);
            }            
        }        
    }
    
spl_autoload_register('autoload');