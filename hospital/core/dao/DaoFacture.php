<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DaoFacture
 *
 * @author Emmanuel TOMBO
 */
class DaoFacture extends BDConnect {

    //put your code here

    public function setFacture(Facture $f, $data, $comp) {
        $respond = null;

        try {
            $db = $this->connection();

            $ps = $db->prepare("insert into facture(montant,dateVente) values(?,now())");
            $respond = $ps->execute(array($f->getMontant()));
            $idFacture = $db->lastInsertId();

            for ($i = 1; $i <= $comp; $i++) {
                $produit = array();
                $produit = $data["produit$i"];

                $ps = $db->prepare("select pr.idProduit from produit pr where idEchProduit=(select ech.idEchProduit from echProduit ech where designation=?)");
                $ps->execute(array($produit["designation"]))["idProduit"];

                $idProduit = $ps->fetch()["idProduit"];
                $ps0 = $db->prepare("insert into facture_produit(idProduit,idFacture,quantite) values(?,?,?)");
                $respond = $ps0->execute(array($idProduit, $idFacture, $produit["quantite"]));
                if ($respond) {
                    $ps1 = $db->prepare("update produit set quantite=? where idProduit=?");
                    $respond = $ps1->execute(array(($produit["quantite"] - 3), $idProduit));
                }
            }

            $resp = array("id" => $idFacture, "response" => $respond);
            $respond = $resp;
        } catch (Exception $ex) {
            $respond = false;
        }
        return $respond;
    }

    public function getFactures() {
        $respond = false;

        try {
            $db = $this->connection();
            $ps = $db->query("select * from facture");
            $respond = json_encode($ps->fetchAll(PDO::FETCH_ASSOC));
        } catch (Exception $th) {
            $respond = false;
        }

        return $respond;
    }

    public function getFactureId($id) {
        $respond = false;

        try {
            $db = $this->connection();
            $ps = $db->prepare("select f.numRef,(select ech.designation from echProduit ech where ech.idEchProduit=p.idEchProduit) as designation,f.montant,fp.quantite,p.prixUnitaire,f.dateVente from facture f "
                    . "join facture_produit fp on f.numRef=fp.idFacture "
                    . "join produit p on fp.idProduit=p.idProduit where f.numRef=?");
            $ps->execute(array($id));

            $respond = json_encode($ps->fetchAll(PDO::FETCH_ASSOC));
        } catch (Exception $ex) {
            $respond = false;
        }
        return $respond;
    }

    public function reportVente($type) {
        $respond = null;

        try {
            $db = $this->connection();

            $ps0 = $db->query("select * from facture");

            $i = 0;
            $datas = array();


            while ($rs = $ps0->fetch()) {
                if ($type === "journ") {
                    $ps = $db->prepare("select f.numRef,(select ech.designation from echProduit ech where ech.idEchProduit=p.idEchProduit) as designation,f.montant,fp.quantite,p.prixUnitaire,f.dateVente from facture f "
                            . "join facture_produit fp on f.numRef=fp.idFacture "
                            . "join produit p on fp.idProduit=p.idProduit where f.numRef=? and f.dateVente=current_date()");
                    $ps->execute(array($rs["numRef"]));
                    $data = array();
                    $data["numRef"] = $rs["numRef"];
                    $data["data"] = json_encode($ps->fetchAll(PDO::FETCH_ASSOC));
                    $datas["datas" . $i] = $data;
                    $i = $i + 1;
                } else {
                    $ps = $db->prepare("select f.numRef,(select ech.designation from echProduit ech where ech.idEchProduit=p.idEchProduit) as designation,f.montant,fp.quantite,p.prixUnitaire,f.dateVente from facture f "
                            . "join facture_produit fp on f.numRef=fp.idFacture "
                            . "join produit p on fp.idProduit=p.idProduit where f.numRef=? and month(f.dateVente)=month(current_date());");
                    $ps->execute(array($rs["numRef"]));
                    $data = array();
                    $data["numRef"] = $rs["numRef"];
                    $data["data"] = json_encode($ps->fetchAll(PDO::FETCH_ASSOC));
                    $datas["datas" . $i] = $data;
                    $i = $i + 1;
                }
            }

            $datas["comp"] = $i;
            $respond = $datas;
        } catch (Exception $ex) {
            $respond = null;
        }
        return $respond;
    }

}
