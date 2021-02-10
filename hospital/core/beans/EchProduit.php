<?php

class EchProduit {

    private $idEchProduit;
    private $designation;
    private $idCategorie;
    private $modeConservation;
    private $uniteConsommation;
    private $quantiteAlerte;

    function getIdEchProduit() {
        return $this->idEchProduit;
    }

    function getDesignation() {
        return $this->designation;
    }

    function getIdCategorie() {
        return $this->idCategorie;
    }

    function getModeConservation() {
        return $this->modeConservation;
    }

    function getUniteConsommation() {
        return $this->uniteConsommation;
    }

    function getQuantiteAlerte() {
        return $this->quantiteAlerte;
    }

    function setIdEchProduit($idEchProduit) {
        $this->idEchProduit = $idEchProduit;
    }

    function setDesignation($designation) {
        $this->designation = $designation;
    }

    function setIdCategorie($idCategorie) {
        $this->idCategorie = $idCategorie;
    }

    function setModeConservation($modeConservation) {
        $this->modeConservation = $modeConservation;
    }

    function setUniteConsommation($uniteConsommation) {
        $this->uniteConsommation = $uniteConsommation;
    }

    function setQuantiteAlerte($quantiteAlerte) {
        $this->quantiteAlerte = $quantiteAlerte;
    }

}

?>