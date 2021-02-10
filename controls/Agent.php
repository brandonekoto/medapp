<?php

namespace controls;

class Agent extends ControlBase {

    public function __construct() {
        parent::__construct();
        $this->setDao();
    }

    public function setDao() {
        $this->dao = new \hospital\core\dao\DaoAgent();
    }

    public function add() {
        $this->setDao();
        if ($_SESSION['user']['idFonction'] == 0) {
            if (isset($_FILES['imgAgent']) && count($_FILES['imgAgent']['name']) > 0 && strlen($_FILES['imgAgent']['name'][0]) > 0) {
                $imgController = new \composants\Download(ROOT . DS . "img/personnel/");
                $s = $imgController->addFiles($_FILES, "imgAgent");
                $this->data['agentPhoto'] = $s['ids'][0];
            }

            $this->data['id_hopital'] = $_SESSION['user']['idhopital'];
            $this->data['province'] = $_SESSION['user']['province'];
            
            $r = $this->dao->add($this->data);
            if ($r == false) {
                $this->session->setFlash($this->dao->errors, "danger");
                $this->session->write("data", $this->data);
                $this->redirect("/public/personnel.php?action=add", "");
            } else {
                $this->session->setFlash("Agent créé avec succès");
                $id = $this->dao->lastId();
                $condition['where'] = " where id = '" . $id . "'";
                $agent = $this->dao->get("agent", $condition);
                $this->session->write("agent", $agent);
                $this->redirect("/public/personnel.php?action=view&id=$id");
            }
        } else {
            $this->session->setFlash("Vous n'avez pas de privilège d'executer cette opération", "warning");
            $this->redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function update() {
        $this->setDao();
        if ($_SESSION['user']['agent'] != $this->data['idagent']) {
            $this->session->setFlash("Vous n'avez pas de privilège d'executer cette opération", "warning");
            $this->redirect($_SERVER['HTTP_REFERER']);
        }
        if (isset($_FILES['imgAgent']) && count($_FILES['imgAgent']['name']) > 0 && strlen($_FILES['imgAgent']['name'][0]) > 0) {
            $imgController = new \composants\Download(ROOT . DS . "img/personnel/");
            $s = $imgController->addFiles($_FILES, "imgAgent");
            $this->data['agentPhoto'] = $s['ids'][0];
        }
        $r = $this->dao->modifier($this->data);
        if ($r == false) {
            $this->session->setFlash($this->dao->errors, "danger");
            $this->session->write("data", $this->data);
            $this->redirect("/public/personnel.php?action=edit&id=" . $this->data['idagent'], "");
        } else {
            $this->session->setFlash("Les informations de l'agent ont été mises à jours créé avec succès");
            $id = $this->dao->lastId();
            $condition['where'] = " where id = '" . $id . "'";
            $agent = $this->dao->get("agent", $condition);
            $this->session->write("agent", $agent);
            $this->redirect("/public/personnel.php?action=view&id=" . $this->data['idagent']);
        }
    }

    public function setBeans() {
        $this->beans = new \hospital\core\beans\Agent();
    }

    public function list() {
        $this->setDao();
        $agent = $this->dao->getAgents();
        return $agent;
    }

    function setPhoto($agent) {
        
    }

    public function view($id) {
        
    }

    function get($id) {
        $this->setDao();
        if (isset($id)) {
            return $this->dao->getById($id);
        }
        return false;
    }

    function delete($data = []) {
        $this->setDao();
        if ($_SESSION['user']['fonction'] == 0) {
            extract($data);
            if (isset($id)) {
                $r = $this->dao->del($id);
                if ($r === true) {
                    $this->session->setFlash("La suppression de l'agent portant id $id a été effectuée avec succès");
                    $this->redirect("/public/personnel.php");
                } else {
                    $this->session->setFlash("La suppression de l'agent portant id $id a été annulée.", 'danger');
                    $this->redirect($_SERVER['HTTP_REFERER']);
                }
            }
        } else {
            $this->session->setFlash("Vous n'avez pas de privilège d'executer cette opération", "warning");
            $this->redirect($_SERVER['HTTP_REFERER']);
        }

        return false;
    }

    public function getfonction($id = "") {
        $this->setDao();
        return $this->dao->getFonction($id);
    }

    public function edit($data = []) {
        extract($data);
    }

    public function after() {
        
    }

    public function before() {
        
    }

}
