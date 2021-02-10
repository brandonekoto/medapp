<?php

    namespace controls;
    abstract  class ControlBase {
        public $dao ;
        public $beans;
        protected $data ;
        public $view ;
        public $isPost = false;
        public $session ;
        public $module ;
        public function __construct() {
            $this->getPost();            
            if(!isset($_SESSION)){
                session_start();
            }
            $this->before();
            $this->session = new \composants\Session();
        }

        abstract function setDao();
        abstract function setBeans();

        public function getPost() {
            if(isset($_POST) && count($_POST) > 0){
                $this->data = $_POST;
                $this->isPost = true;
            }
        }
        public function hasUpload() {
            
        }
        abstract function view($id);
        
        public function redirect($url = '', $complete = false, $passedVars = null) {
        if ($passedVars) {
            $this->session->write('passedVars', serialize($passedVars));
        }

        if ($complete) {
            header("Location:$url");
            exit();
        } else {
            header("Location:$url");
            exit();
        }
    }
    static public function genereToken(){
        $str = str_shuffle(str_repeat("ABCDEFGHIJKLMNOPQRSTVWXYZabcdefghijklmnopqrstvwxyz0123456789",2));
        strlen($str);
        return $str;
    }
    
    public function beforeLoad() {
        if($_SERVER['X_REQUESTED_WITH']){
            
        }else{
            
        }
    }
    public function afterLoad() {
        
    }
    abstract function before();
    abstract function after();
    public function valideData($data, $regExp, $msg, $champ, $required = true) {

        if ($required === true) {
            if (!isset($data) || strlen($data) < 1) {
                array_push($this->errors, "Ce champ $champ ne peut être vide, Veuillez l'insérer svp");
                return false;
            }
        } else {
            return false;
        }
        if (preg_match($regExp, $data) == false) {
            array_push($this->errors, $msg);
            return false;
        }
    }

}
