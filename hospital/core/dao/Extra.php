<?php

namespace hospital\core\dao;

use model\Model;
use model\DaoInterface;

/**
 * Description of Extra
 *
 * @author djbek
 */
class Extra extends Model implements DaoInterface {

    public function __construct($options = array()) {
        parent::__construct($options);
    }

    public function add($data = array()) {
        extract($data);
        $this->valideData($extra, "#\d{1,5}#", "Cet extra n'est pas valide ou il n'a pas été sélectionné, Veuillez corriger l'erreur", 'extra');
        $this->valideData($obs, "#^.{1,5000}$#s", "Veuillez vous assurer que les caractères non autorités n'ont pas été saisis", "Observation", false);
        $this->valideData($acte_pose, "#\d{1,5}#", "L'acte posé est invalide, veuillez le corriger", "acte medical");
        if (count($this->errors) > 0) {
            return false;
        }

        $values = new \stdClass();
        $values->id_acte = $acte_pose;
        $values->id_agent = $_SESSION["user"]["agent"];

        $values->id_extra = $extra;
        $values->details = $obs;
        $r = $this->input($values, "extrat");
        if ($r == false) {
            
        }
        return $r;
    }

    public function del($id) {
        
    }

    public function edit($id, $data = array()) {
        
    }

    public function getListExtra() {

        return $this->get('liste_extra');
    }

    public function getRecommandListExtra($acte) {
        $sql = "SELECT e.id as idext ,e.details, e.date as dateextrat, e.id_extra, le.lib as extrat, le.prix_affilier as prixa, le.prix_prive pp, ap.id idactepose, ap.id_acte idacteme, a.*
from extrat as e INNER JOIN liste_extra as le ON le.id = e.id_extra INNER JOIN acte_pose as ap ON ap.id = e.id_acte INNER JOIN agent a ON a.id = e.id_agent
 WHERE ap.id =' ".$acte . "'";
        //\composants\Utilitaire::debug($acte);
        try {
            $stm = $this->cnx->query($sql);
            /*$stm->execute([
                "acte" => $acte
            ])*/;
            $q = $stm->fetchAll(\PDO::FETCH_OBJ);

            return $q;
        } catch (\PDOException $e) {

            $this->errors = $e;
            return null;
        }
        //return $this->get('liste_extra');
    }
    public function getRecommandExtra($acte) {
        $sql = "SELECT e.id as idext ,e.details, e.date as dateextrat, e.id_extra, le.lib as extrat, le.prix_affilier as prixa, le.prix_prive pp, ap.id idactepose, ap.id_acte idacteme, a.*
from extrat as e INNER JOIN liste_extra as le ON le.id = e.id_extra INNER JOIN acte_pose as ap ON ap.id = e.id_acte INNER JOIN agent a ON a.id = e.id_agent
 WHERE  e.id = :id";
        try {
            $stm = $this->cnx->prepare($sql);
            $stm->execute([
                "id" => $acte
            ]);
            $q = $stm->fetchAll(\PDO::FETCH_OBJ);

            return $q;
        } catch (\PDOException $e) {
            $e->getTraceAsString();
            $this->errors = $e;
            return null;
        }
        //return $this->get('liste_extra');
    }

    public function getOneExtraList($id) {
        $condition['where'] = " WHERE id = '$id'";
        return $this->get('liste_extra', $condition);
    }

}
