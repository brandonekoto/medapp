<?php 
namespace hospital\core\beans ;
class Agent{
    private $nom;
    private $postnom;
    private $prenom;
    private $genre;
    private $dateNaiss;
    private $lieuNaiss;
    private $nationalite;
    private $etatCivil;
    private $nbreEnfant;
    private $idFonction;
    private $adresse;
    private $telDomicile;
    private $telBureau;
    private $email;
    private $nivEtudes;
    private $statut;
    private $dateEngagement;
    private $dateSortir;
    private $urlPhoto;

    public function setUrlPhoto($urlPhoto){
        $this->urlPhoto=$urlPhoto;
    }

    public function setNom($nom){
        $this->nom=$nom;
    }

    public function setPostnom($postnom){
        $this->postnom=$postnom;
    }

    public function setPrenom($prenom){
        $this->prenom=$prenom;
    }

    public function setGenre($genre){
        $this->genre=$genre;
    }

    public function setDateNaiss($dateNaiss){
        $this->dateNaiss=$dateNaiss;
    }

    public function setLieuNaiss($lieuNaiss){
        $this->lieuNaiss=$lieuNaiss;
    }

    public function setIdNationalite($nationalite){
        $this->nationalite=$nationalite;
    }

    public function setEtatCivil($etatCivil){
        $this->etatCivil=$etatCivil;
    }

    public function setNbreEnfant($nbreEnfant){
        $this->nbreEnfant=$nbreEnfant;
    }

    public function setIdFonction($idFonction){
        $this->idFonction=$idFonction;
    }

    public function setAdresse($adresse){
        $this->adresse=$adresse;
    }

    public function setTelDomicile($telDomicile){
        $this->telDomicile=$telDomicile;
    }

    public function setTelBureau($telBureau){
        $this->telBureau=$telBureau;
    }

    public function setEmail($email){
        $this->email=$email;
    }

    public function setNivEtudes($nivEtudes){
        $this->nivEtudes=$nivEtudes;
    }

    public function setStatut($statut){
        $this->statut=$statut;
    }

    public function setDateEngagement($dateEngagement){
        $this->dateEngagement=$dateEngagement;
    }

    public function setDateSortir($dateSortir){
        $this->dateSortir=$dateSortir;
    }

    public function getUrlPhoto(){
        return $this->urlPhoto;
    }

    public function getNom(){
        return $this->nom;
    }

    public function getPostnom(){
        return $this->postnom;
    }

    public function getPrenom(){
        return $this->prenom;
    }

    public function getGenre(){
        return $this->genre;
    }

    public function getDateNaiss(){
        return $this->dateNaiss;
    }

    public function getLieuNaiss(){
        return $this->lieuNaiss;
    }

    public function getIdNationalite(){
        return $this->lieuNaiss;
    }

    public function getEtatCivil(){
        return $this->etatCivil;
    }
    public function getNbreEnfant(){
        return $this->nbreEnfant;
    }
    public function getIdFonction(){
        return $this->idFonction;
    }

    public function getAdresse(){
        return $this->adresse;
    }

    public function getTelDomicile(){
        return $this->telDomicile;
    }
    public function getTelBureau(){
        return $this->telBureau;
    }

    public function getEmail(){
        return $this->email;
    }

    public function getNivEtudes(){
        return $this->nivEtudes;
    }

    public function getStatut(){
        return $this->statut;
    }

    public function getDateEngagement(){
        return $this->dateEngagement;
    }

    public function getDateSortir(){
        return $this->dateSortir;
    }
    
}

?>