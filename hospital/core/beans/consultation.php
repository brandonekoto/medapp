<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of consultation
 *
 * @author Emmanuel TOMBO
 */
class Consultation extends BDConnect{
    //put your code here
    
    private $idConsult;	
    private $idPatient;
    private $acte;
    private $anamnese;
    private $taille;
    private $poids;
    private $temp;
    private $examens;
    private $obs;
    private $diagnostique;
    private $resultat;
    private $dateConsult;
    private $valideDoc;
    private $valideLabo;
            
    function getIdConsult() {
        return $this->idConsult;
    }

    function getIdPatient() {
        return $this->idPatient;
    }

    function getActe() {
        return $this->acte;
    }

    function getAnamnese() {
        return $this->anamnese;
    }

    function getTaille() {
        return $this->taille;
    }

    function getPoids() {
        return $this->poids;
    }

    function getTemp() {
        return $this->temp;
    }

    function getExamens() {
        return $this->examens;
    }

    function getObs() {
        return $this->obs;
    }

    function getResultat() {
        return $this->resultat;
    }

    function getDateConsult() {
        return $this->dateConsult;
    }

    function getValider() {
        return $this->valider;
    }
    
    function getDiagnostique() {
        return $this->diagnostique;
    }

    function setDiagnostique($diagnostique) {
        $this->diagnostique = $diagnostique;
    }

    function getValideDoc() {
        return $this->valideDoc;
    }

    function getValideLabo() {
        return $this->valideLabo;
    }

    function setValideDoc($valideDoc) {
        $this->valideDoc = $valideDoc;
    }

    function setValideLabo($valideLabo) {
        $this->valideLabo = $valideLabo;
    }

        
    function setIdConsult($idConsult) {
        $this->idConsult = $idConsult;
    }

    function setIdPatient($idPatient) {
        $this->idPatient = $idPatient;
    }

    function setActe($acte) {
        $this->acte = $acte;
    }

    function setAnamnese($anamnese) {
        $this->anamnese = $anamnese;
    }

    function setTaille($taille) {
        $this->taille = $taille;
    }

    function setPoids($poids) {
        $this->poids = $poids;
    }

    function setTemp($temp) {
        $this->temp = $temp;
    }

    function setExamens($examens) {
        $this->examens = $examens;
    }

    function setObs($obs) {
        $this->obs = $obs;
    }

    function setResultat($resultat) {
        $this->resultat = $resultat;
    }

    function setDateConsult($dateConsult) {
        $this->dateConsult = $dateConsult;
    }

    function setValider($valider) {
        $this->valider = $valider;
    }

}
