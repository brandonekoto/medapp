<?php

    namespace composants;
    
    class MDEException extends \Exception{
        public function __construct(string $message = "", int $code = 0, \Throwable $previous = NULL) {
            parent::__construct($message, $code, $previous);
            $this->code = $code;
            switch ($code) {
                case 401:
                include_once ROOT . DS. 'public/401.php'   ;     
                    break;
                default:
                include_once ROOT . DS. 'public/500.php'   ; 
                    break;
            }            
        }   
        public function setMessage($str ="", $cod = 0) {
            $this->message =  $str;
            $this->code = $cod;
        }
    }
