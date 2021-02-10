<?php


namespace controls;

class Accounting extends ControlBase{
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
        $this->dao = new \hospital\core\dao\Accounting();
    }

    public function view($id) {
        
    }
    
    public function add($param=[]) {
        
        if($this->data['type'] == 2){
            if($_SESSION['user']['agent'] !== 34){
                $this->session->setFlash("Vous n'avez pas le privilège d'exécuter une opération de sortie", "warning");
                $this->redirect($_SERVER['HTTP_REFERER']);
            }
        }
        $r = $this->dao->add($this->data);
        if($r === true){
            $this->session->setFlash("Opération enregistrée avec succès");
            $this->redirect("/public/accounting.php?action=view");
        }else{
            $this->session->setFlash($this->dao->errors, 'danger');
            $this->redirect($_SERVER['HTTP_REFERER']);
        }
    }
    public function get($condition="") {
        return $this->dao->listOperation($condition);
    }

}
