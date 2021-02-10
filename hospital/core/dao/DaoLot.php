<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class DaoLot extends BDConnect {

    public function setLot(Lot $lot) {
        $respond = "false";
        
        try {
            $db = $this->connection();

            $ps = $db->prepare("insert into lot(designation,dateLot,heure,document,etat) values(?,?,now(),?,?)");
            $ps->execute(array($lot->getDesignationLot(), $lot->getDateLot(), $lot->getDoc(), "non active"));
            $respond = "true";
        } catch (Exception $ex) {
            $respond = "false";
        }
        return $respond;
    }

    public function getLots() {
        $respond = null;

        $rep = array();
        try {
            $db = $this->connection();
            $ps = $db->query("select * from lot order by heure desc");
            $respond = json_encode($ps->fetchAll(PDO::FETCH_ASSOC));
        } catch (Exception $th) {
            
        }

        return $respond;
    }

}
