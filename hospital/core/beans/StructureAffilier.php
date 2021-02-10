<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of StructureAffilier
 *
 * @author Emmanuel TOMBO
 */
class StructureAffilier {
    //put your code here
    
    private $libelle;
    private $adresse;
    private $contacts;
    
    function getLibelle() {
        return $this->libelle;
    }

    function getAdresse() {
        return $this->adresse;
    }

    function getContacts() {
        return $this->contacts;
    }

    function setLibelle($libelle) {
        $this->libelle = $libelle;
    }

    function setAdresse($adresse) {
        $this->adresse = $adresse;
    }

    function setContacts($contacts) {
        $this->contacts = $contacts;
    }
    
}
