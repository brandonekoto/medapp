<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Lot{
    private $idLot;
    private $designationLot;
    private $dateLot;
    private $doc;
    
    function __construct($designationLot, $dateLot, $doc) {
        $this->designationLot = $designationLot;
        $this->dateLot = $dateLot;
        $this->doc = $doc;
    }
    
    function getIdLot() {
        return $this->idLot;
    }

    function getDesignationLot() {
        return $this->designationLot;
    }

    function getDateLot() {
        return $this->dateLot;
    }

    function getDoc() {
        return $this->doc;
    }

    function setIdLot($idLot) {
        $this->idLot = $idLot;
    }

    function setDesignationLot($designationLot) {
        $this->designationLot = $designationLot;
    }

    function setDateLot($dateLot) {
        $this->dateLot = $dateLot;
    }

    function setDoc($doc) {
        $this->doc = $doc;
    }

}
