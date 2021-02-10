<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of personneaffilierexterne
 *
 * @author Emmanuel TOMBO
 */
class Personneaffilierexterne {

    //put your code here
    private $idPersonne;
    private $nom;
    private $postnom;
    private $prenom;
    private $genre;
    private $dateNaiss;
    private $idPersonnelStructureAffilier;

    function getIdPersonne() {
        return $this->idPersonne;
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

    function getDateNaiss() {
        return $this->dateNaiss;
    }

    function getIdPersonnelStructureAffilier() {
        return $this->idPersonnelStructureAffilier;
    }

    function getPrenom() {
        return $this->prenom;
    }

    function setPrenom($prenom) {
        $this->prenom = $prenom;
    }

    function setIdPersonne($idPersonne) {
        $this->idPersonne = $idPersonne;
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

    function setDateNaiss($dateNaiss) {
        $this->dateNaiss = $dateNaiss;
    }

    function setIdPersonnelStructureAffilier($idPersonnelStructureAffilier) {
        $this->idPersonnelStructureAffilier = $idPersonnelStructureAffilier;
    }

}
