<?php
    define('DS', DIRECTORY_SEPARATOR);
    define('ROOT', $_SERVER['DOCUMENT_ROOT']);
    define('WEBROOT', 'http://' . $_SERVER['HTTP_HOST'] . '/');
    include_once ROOT . DS . 'auto_load.php';
    set_time_limit(0);
    setlocale(LC_ALL, "en_US.utf8"); 
    if(!isset($_SESSION)){
        session_start();
    }
    $session = new composants\Session();    
    static $left;
    static $html = "";
    static $url;    
    $userController = new \controls\User();
    $userController->checkConnectivity();
    if(!isset($_SESSION['TAUX'])){
        $session = new composants\Session();
        $session->write('TAUX', hospital\core\dao\Pharmacy::getTaux());
        unset($session);
    }