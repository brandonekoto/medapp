<?php
namespace hospital\core\beans;
class Patient {

    //put your code here
    private $idPatient;
    private $nom;
    private $postnom;
    private $prenom;
    private $genre;
    private $dateNaiss;
    private $contact;
    private $adresse;
    private $typePatient;
    private $numAffiation;
    private $idhopital;

    function getIdPatient() {
        return $this->idPatient;
    }

    function getNom() {
        return $this->nom;
    }

    function getPostnom() {
        return $this->postnom;
    }

    function getPrenom() {
        return $this->prenom;
    }

    function getGenre() {
        return $this->genre;
    }

    function getdateNaiss() {
        return $this->dateNaiss;
    }

    function getContact() {
        return $this->contact;
    }

    function getAdresse() {
        return $this->adresse;
    }

    function getTypePatient() {
        return $this->typePatient;
    }

    function getNumAffiation() {
        return $this->numAffiation;
    }

    function setIdPatient($idPatient) {
        $this->idPatient = $idPatient;
    }

    function setNom($nom) {
        $this->nom = $nom;
    }

    function setPostnom($postnom) {
        $this->postnom = $postnom;
    }

    function setPrenom($prenom) {
        $this->prenom = $prenom;
    }

    function setGenre($genre) {
        $this->genre = $genre;
    }

    function setdateNaiss($dateNaiss) {
        $this->dateNaiss = $dateNaiss;
    }

    function setContact($contact) {
        $this->contact = $contact;
    }

    function setAdresse($adresse) {
        $this->adresse = $adresse;
    }

    function setTypePatient($typePatient) {
        $this->typePatient = $typePatient;
    }

    function setNumAffiation($numAffiation) {
        $this->numAffiation = $numAffiation;
    }
    function getIdhopital() {
        return $this->idhopital;
    }

    function setIdhopital($idhopital): void {
        $this->idhopital = $idhopital;
    }


}
