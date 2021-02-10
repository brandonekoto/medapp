<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DaoPersonnelStructureAffil
 *
 * @author Emmanuel TOMBO
 */
class DaoPersonnelStructureAffil extends BDConnect {

    //put your code here

    public function setPersonStruc(PersonnelStructureAffilier $pers) {
        $respond = false;

        try {
            $db = $this->connection();
            $ps = $db->prepare("insert into personnelstructureaffilier(matricule,nom,postnom,prenom,genre,idStructure) values(?,?,?,?,?,?)");
            $respond = $ps->execute(array($pers->getMatricule(), $pers->getNom(), $pers->getPostnom(), $pers->getPrenom(), $pers->getGenre(), $pers->getIdStructure()));
        } catch (Exception $ex) {
            $respond = false;
        }
        return $respond;
    }

}
