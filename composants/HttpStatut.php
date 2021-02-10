<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of HttpStatut
 *
 * @author brandonekoto
 */
class HttpStatut {
    private $code;
    private $message;
    
    function __construct($code , $message = "") {
        $this->code = $code;
        $this->message = $message;
    }

    
    function getCode() {
        return $this->code;
    }

    function getMessage() {
        return $this->message;
    }

    function setCode($code): void {
        $this->code = $code;
    }

    function setMessage($message): void {
        $this->message = $message;
    }


}
