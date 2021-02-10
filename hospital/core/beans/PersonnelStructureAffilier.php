<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PersonnelStructureAffilier
 *
 * @author Emmanuel TOMBO
 */
class PersonnelStructureAffilier {

    //put your code here
    private $idPersonnel;
    private $matricule;
    private $nom;
    private $postnom;
    private $prenom;
    private $genre;
    private $idStructure;
    
    function getMatricule() {
        return $this->matricule;
    }

    function setMatricule($matricule) {
        $this->matricule = $matricule;
    }
    
    function getPrenom() {
        return $this->prenom;
    }

    function setPrenom($prenom) {
        $this->prenom = $prenom;
    }
    
    function getIdPersonnel() {
        return $this->idPersonnel;
    }

    function getNom() {
        return $this->nom;
    }

    function getPostnom() {
        return $this->postnom;
    }

    function getGenre() {
        return $this->genre;
    }

    function getIdStructure() {
        return $this->idStructure;
    }

    function setIdPersonnel($idPersonnel) {
        $this->idPersonnel = $idPersonnel;
    }

    function setNom($nom) {
        $this->nom = $nom;
    }

    function setPostnom($postnom) {
        $this->postnom = $postnom;
    }

    function setGenre($genre) {
        $this->genre = $genre;
    }

    function setIdStructure($idStructure) {
        $this->idStructure = $idStructure;
    }

}
