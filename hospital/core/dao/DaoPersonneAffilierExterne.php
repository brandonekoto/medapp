<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DaoPersonneAffilierExterne
 *
 * @author Emmanuel TOMBO
 */
class DaoPersonneAffilierExterne extends BDConnect {

    //put your code here

    public function setPersonneAffilierExt(Personneaffilierexterne $perso) {
        $respond = null;

        try {
            $db = $this->connection();
            $ps = $db->prepare("insert into personneaffilierexterne(nom,postnom,prenom,genre,dateNaiss,idPersonnelStructureAffilier) values(?,?,?,?,?,?)");
            $respond = $ps->execute(array($perso->getNom(), $perso->getPostnom(), $perso->getPrenom(), $perso->getGenre(), $perso->getDateNaiss(), $perso->getIdPersonnelStructureAffilier()));
        } catch (Exception $ex) {
            $respond = false;
            echo $ex;
        }
        return $respond;
    }

}
