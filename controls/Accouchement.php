<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace controls;

use \hospital\core\dao\DaoAccouchement;

/**
 * Description of Accouchement
 *
 * @author brandonekoto
 */
class Accouchement extends ControlBase {

    //put your code here
    public function __construct() {
        parent::__construct();
        $this->setDao();
    }

    public function after() {
        
    }

    public function before() {
        
    }

    public function setBeans() {
        
    }

    public function setDao() {
        $this->dao = new DaoAccouchement();
    }

    public function view($id) {
        
    }

    public function addBabies() {
        $this->dao->add();
    }

    public function init($data = []) {
        extract($this->data);
        $this->setDao();
        $r = $this->dao->init($this->data);
        //\composants\Utilitaire::debug($r, true);
        //$id = $this->dao->lastId();
        if ($r == false) {
            $this->session->setFlash($this->dao->errors, "danger");
            $this->redirect("/public/accouchement.php?etape=0&action=add", "");
        } else {
            $msg = [
                "<div class='alert alert-warning'><h2>Attention de ne pas quitter cette page ou de l'actualiser sans pour autant copier la référence de l'acte</h2></div>",
                "Initialisation réussie avec succès. La référence de cet acte est : <h3> Réf Acte : " . $r . "</h3>",
                "Pour voir le detail <a href='/public/accouchement.php?action=view&id=$r' class='btn btn-metis-2 btn-grad'>Cliquez ici</a> " . 'OU imprimer Géton <a href="/public/print.php?id=' . $id . '" class="btn btn-grad btn-success printbtn"><i class="glyphicon glyphicon-print"></i></a>',
                "Pour remplir les informations de consultation, Veuillez Cliquez sur 'Consultation'  puis indiquez la référence de l'acte ci-haut"
            ];
            $this->session->setFlash($msg);
            $this->redirect("/public/accouchement.php?etape=1&action=add&id_acte=$r");
        }
    }
    
    public function getList() {
        return $this->dao->getList();
    }
    
    public function getEnfantByAccouchement($datas = []) {
        extract($datas);
        return $this->dao->getEnfantByAccouchement($accouchement);
    }
    
    public function getDetail($datas) {
        extract($datas);
        return $this->dao->getDetailByDetail($idacte);
    }
}
