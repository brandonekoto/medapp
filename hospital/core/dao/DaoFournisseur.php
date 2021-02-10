<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class DaoFournisseur extends BDConnect {

    public function setFournisseur(Fournisseur $fourn) {
        $respond = false;

        try {
            $db = $this->connection();

            $ps = $db->prepare("insert into fournisseur(fournisseur) values(?)");
            $respond = $ps->execute(array($fourn->getFournisseur()));
        } catch (Exception $ex) {
            $respond = false;
        }
        return $respond;
    }

    public function getFournisseurs() {
        $result = "";

        try {
            $db = $this->connection();
            $ps = $db->prepare("select * from fournisseur");
            $ps->execute();
            $result = json_encode($ps->fetchAll(PDO::FETCH_ASSOC));
        } catch (Exception $th) {
            echo $th;
        }
        return $result;
    }

}
