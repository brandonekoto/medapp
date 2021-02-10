<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Facture
 *
 * @author Emmanuel TOMBO
 */
class Facture {

    //put your code here

    private $numRef;
    private $montant;
    private $quantite;
    private $dateVente;
    
    function setNumRef($numRef) {
        $this->numRef = $numRef;
    }

    function setMontant($montant) {
        $this->montant = $montant;
    }

    function setQuantite($quantite) {
        $this->quantite = $quantite;
    }

    function setDateVente($dateVente) {
        $this->dateVente = $dateVente;
    }
    function getNumRef() {
        return $this->numRef;
    }

    function getMontant() {
        return $this->montant;
    }

    function getQuantite() {
        return $this->quantite;
    }

    function getDateVente() {
        return $this->dateVente;
    }



}
