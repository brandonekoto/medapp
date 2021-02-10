<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Fournisseur{
    private $idFournisseur;
    private $fournisseur;
    private $contact;

    function getIdFournisseur() {
        return $this->idFournisseur;
    }

    function getFournisseur() {
        return $this->fournisseur;
    }

    function getContact() {
        return $this->contact;
    }

    function setIdFournisseur($idFournisseur) {
        $this->idFournisseur = $idFournisseur;
    }

    function setFournisseur($fournisseur) {
        $this->fournisseur = $fournisseur;
    }

    function setContact($contact) {
        $this->contact = $contact;
    }



}