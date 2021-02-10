<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class DaoProduit extends BDConnect {

    public function setProduit(Produit $produit, $idLot) {
        $respond = "false";

        try {
            $db = $this->connection();

            if ($produit->getCodeBar() == "") {
                $produit->setCodeBar(0);
            }

            $ps = $db->prepare("insert into produit(idEchProduit,prixUnitaire,quantite,dateFab,dateExp,idFournisseur,codebar) values(?,?,?,?,?,?,?)");
            $ps->execute(array($produit->getIdEchProduit(), $produit->getPrixUnitaire(), $produit->getQuantite(), $produit->getDateFab(), $produit->getDateExp(), $produit->getIdFournisseur(), $produit->getCodeBar()));

           
            $idProd = $db->lastInsertId();
            $ps0 = $db->prepare("insert into lot_produit(idLot,idProduit) value(?,?)");
            $respond = $ps0->execute(array($idLot, $idProd));
        } catch (Exception $ex) {
            $respond = "false";
        }
        return $respond;
    }

    public function getProduits() {
        $respond = null;

        $rep = array();
        try {
            $db = $this->connection();
            $ps = $db->query("select * from produit pr "
                    . "join fournisseur fourn on fourn.idFournisseur=pr.idFournisseur "
                    . "join echProduit ech on ech.idEchProduit=pr.idEchProduit "
                    . "join categorie cat on cat.idCategorie=ech.idCategorie");
            $respond = json_encode($ps->fetchAll(PDO::FETCH_ASSOC));
        } catch (Exception $th) {
            
        }

        return $respond;
    }

    public function getListAutoComplete($str) {
        $respond = null;
        try {
            $db = $this->connection();
            $ps = $db->query("select * from produit pr "
                    . "join fournisseur fourn on fourn.idFournisseur=pr.idFournisseur "
                    . "join echProduit ech on ech.idEchProduit=pr.idEchProduit "
                    . "join categorie cat on cat.idCategorie=ech.idCategorie "
                    . "where ech.designation like('$str%') LIMIT 10");
            $respond = json_encode($ps->fetchAll(PDO::FETCH_ASSOC));
        } catch (Exception $th) {
            
        }

        return $respond;
    }

    public function getByBarcode($str) {
        $respond = null;

        try {
            $db = $this->connection();
            $ps = $db->prepare("select * from produit p join echProduit ech on p.idEchProduit=ech.idEchProduit where p.codebar=?");
            $ps->execute(array($str));
            $respond = json_encode($ps->fetchAll(PDO::FETCH_ASSOC));
        } catch (Exception $th) {
            
        }

        return $respond;
    }

    public function deleteProduit($idProduit) {
        $respond = false;

        try {
            $db = $this->connection();

            $ps = $db->prepare("delete from produit where idProduit=?");
            $respond = $ps->execute(array($idProduit));
        } catch (Exception $ex) {
            $respond = false;
        }
        return $respond;
    }

    public function modProduit(Produit $prod) {
        $respond = false;

        try {
            $db = $this->connection();

            $ps = $db->prepare("update produit set prixUnitaire=?, quantite=?,dateFab=?, dateExp=?, idFournisseur=? where idProduit=?");
            $respond = $ps->execute(array($prod->getPrixUnitaire(),
                $prod->getQuantite(),
                $prod->getDateFab(),
                $prod->getDateExp(),
                $prod->getIdFournisseur(),
                $prod->getIdProduit()));
        } catch (Exception $ex) {
            $respond = false;
        }
        return $respond;
    }

}
