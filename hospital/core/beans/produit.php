<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Produit{
    private $idProduit;
    private $idEchProduit;
    private $codeBar;
    private $prixUnitaire;
    private $quantite;
    private $dateFab;
    private $dateExp;
    private $idFournisseur;
    
    function getIdProduit() {
        return $this->idProduit;
    }

    function getIdEchProduit() {
        return $this->idEchProduit;
    }

    function getCodeBar() {
        return $this->codeBar;
    }

    function getPrixUnitaire() {
        return $this->prixUnitaire;
    }

    function getQuantite() {
        return $this->quantite;
    }

    function getDateFab() {
        return $this->dateFab;
    }

    function getDateExp() {
        return $this->dateExp;
    }

    function getIdFournisseur() {
        return $this->idFournisseur;
    }

    function setIdProduit($idProduit) {
        $this->idProduit = $idProduit;
    }

    function setIdEchProduit($idEchProduit) {
        $this->idEchProduit = $idEchProduit;
    }

    function setCodeBar($codeBar) {
        $this->codeBar = $codeBar;
    }

    function setPrixUnitaire($prixUnitaire) {
        $this->prixUnitaire = $prixUnitaire;
    }

    function setQuantite($quantite) {
        $this->quantite = $quantite;
    }

    function setDateFab($dateFab) {
        $this->dateFab = $dateFab;
    }

    function setDateExp($dateExp) {
        $this->dateExp = $dateExp;
    }

    function setIdFournisseur($idFournisseur) {
        $this->idFournisseur = $idFournisseur;
    }

}

