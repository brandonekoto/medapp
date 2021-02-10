<?php

namespace hospital\core\beans;

class Acte {
    //put your code here
    	private $idActe;
        private $designation;
        private $categorie;
        private $prix;
        
        function getIdActe() {
            return $this->idActe;
        }

        function getDesignation() {
            return $this->designation;
        }

        function getCategorie() {
            return $this->categorie;
        }

        function getPrix() {
            return $this->prix;
        }

        function setIdActe($idActe) {
            $this->idActe = $idActe;
        }

        function setDesignation($designation) {
            $this->designation = $designation;
        }

        function setCategorie($categorie) {
            $this->categorie = $categorie;
        }

        function setPrix($prix) {
            $this->prix = $prix;
        }


}
