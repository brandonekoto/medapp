<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of HttpResponse
 *
 * @author brandonekoto
 */
class HttpResponse {
    private $httpStatut;
    private $response;
    
    function __construct(HttpStatut $httpStatut, string $response) {
        $this->httpStatut = $httpStatut;
        $this->response = $response;
    }
    
    function getHttpStatut() {
        return $this->httpStatut;
    }

    function getResponse() {
        return $this->response;
    }

    function setHttpStatut($httpStatut): void {
        $this->httpStatut = $httpStatut;
    }

    function setResponse($response): void {
        $this->response = $response;
    }



}
