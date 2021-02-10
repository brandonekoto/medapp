<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DaoConsult
 *
 * @author Emmanuel TOMBO
 */
class DaoConsult extends BDConnect {

    //put your code here
    public function setConsult1(Consultation $cons) {
        $respond = false;

        try {
            $db = $this->connection();
            $ps = $db->prepare("insert into consultation(idPatient,anamnese,taille,poids,temp,dateConsult) values(?,?,?,?,?,now())");
            $respond = $ps->execute(array($cons->getIdPatient(), $cons->getAnamnese(), $cons->getTaille(), $cons->getPoids(), $cons->getTemp()));
            $idConsult = $db->lastInsertId();
            $ps0 = $db->prepare("insert into consultation_acte(idConsult,idActe) values(?,?)");
            $respond = $ps0->execute(array($idConsult, $cons->getActe()));
        } catch (Exception $ex) {
            $respond = false;
        }
        return $respond;
    }

    public function setConsultDoc(Consultation $cons) {
        $respond = false;
        try {
            $db = $this->connection();
            $ps = $db->prepare("update consultation set examens=?,obs=?, diagnostique=?,valideDoc=? where idConsult=?");
            $respond = $ps->execute(array($cons->getExamens(), $cons->getObs(), $cons->getDiagnostique(), $cons->getValideDoc(), $cons->getIdConsult()));
        } catch (Exception $ex) {
            echo $ex;
            $respond = false;
        }
        return $respond;
    }

    public function setConsultLabo(Consultation $cons) {
        $respond = false;
        try {
            $db = $this->connection();
            $ps = $db->prepare("update consultation set resultat=?, valideLabo=? where idConsult=?");
            $respond = $ps->execute(array($cons->getResultat(), $cons->getIdConsult()));
        } catch (Exception $ex) {
            $respond = false;
        }
        return $respond;
    }

    public function getConsults() {
        $respond = null;

        try {
            $db = $this->connection();
            $ps = $db->query("select * from consultation c "
                    . "join patient p on c.idPatient=p.idPatient");
            $respond = json_encode($ps->fetchAll(PDO::FETCH_ASSOC));
        } catch (Exception $th) {
            
        }

        return $respond;
    }

    public function findConsult($str) {
        $respond = null;

        try {
            $db = $this->connection();
            $ps = $db->query("select * from consultation c "
                    . "join patient p on c.idPatient=p.idPatient "
                    . "where c.idConsult=$str or p.nom like('$str%')");
            $respond = json_encode($ps->fetchAll(PDO::FETCH_ASSOC));
        } catch (Exception $th) {
            
        }

        return $respond;
    }

    public function getConsultByPatient($id) {
        $respond = null;

        try {
            $db = $this->connection();
            $ps = $db->prepare("select * from consultation c "
                    . "join patient p on c.idPatient=p.idPatient "
                    . "where p.idPatient=?");
            $ps->execute(array($id));
            $respond = json_encode($ps->fetchAll(PDO::FETCH_ASSOC));
        } catch (Exception $th) {
            
        }

        return $respond;
    }

}
