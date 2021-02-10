<?php

class DaoEchProduit extends BDConnect {

    public function setEchProduit($EchProduit) {
        $respond = "false";

        try {
            $db = $this->connection();

            $ps = $db->prepare("insert into echProduit(designation,idCategorie,modeConservation,uniteConsommation,quantiteAlerte) values(?,?,?,?,?)");
            $ps->execute(array($EchProduit->getDesignation(), $EchProduit->getIdCategorie(), $EchProduit->getModeConservation(), $EchProduit->getUniteConsommation(), $EchProduit->getQuantiteAlerte()));
            $respond = "true";
        } catch (Exception $ex) {
            $respond = "false";
        }
        return $respond;
    }

    public function getEchProduits() {
        $respond = null;

        try {
            $db = $this->connection();
            $ps = $db->query("select * from echProduit ech "
                    . "join categorie cat on ech.idCategorie=cat.idCategorie");
            $respond = json_encode($ps->fetchAll(PDO::FETCH_ASSOC));
        } catch (Exception $th) {
            
        }

        return $respond;
    }

    public function findEchProduit($str) {
        $respond = null;

        try {
            $db = $this->connection();
            $ps = $db->query("select * from echProduit ech "
                    . "join categorie cat on ech.idCategorie=cat.idCategorie "
                    . "where ech.designation like('".$str."%')");
            $respond = json_encode($ps->fetchAll(PDO::FETCH_ASSOC));
        } catch (Exception $th) {
            
        }

        return $respond;
    }

    public function getCategorieEchProduit() {
        $respond = null;

        try {
            $db = $this->connection();
            $ps = $db->query("select * from categorie");
            $respond = json_encode($ps->fetchAll(PDO::FETCH_ASSOC));
        } catch (Exception $ex) {
            echo $ex;
        }

        return $respond;
    }

    public function deleteEchProduit($idEchProduit) {
        $respond = false;

        try {
            $db = $this->connection();

            $ps = $db->prepare("delete from echProduit where idEchProduit=?");
            $respond = $ps->execute(array($idEchProduit));
        } catch (Exception $ex) {
            $respond = false;
        }
        return $respond;
    }

    public function modEchProduit(EchProduit $echProd) {
        $respond = false;

        try {
            $db = $this->connection();

            $ps = $db->prepare("update echProduit set designation=?, idCategorie=?,modeConservation=?, uniteConsommation=?, quantiteAlerte=? where idEchProduit=?");
            $respond = $ps->execute(array($echProd->getDesignation(),
                $echProd->getIdCategorie(),
                $echProd->getModeConservation(),
                $echProd->getUniteConsommation(),
                $echProd->getQuantiteAlerte(),
                $echProd->getIdEchProduit()));
        } catch (Exception $ex) {
            $respond = false;
        }
        return $respond;
    }

}

?>