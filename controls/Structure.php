<?php

namespace controls;

class Structure extends ControlBase{
    //put your code here
    public function after() {
        
    }

    public function before() {
        
    }

    public function setBeans() {
        $this->dao = new \hospital\core\dao\Structure();
    }

    public function setDao() {
        
    }

    public function view($id) {
        
    }
    public function bind($data=[]) {
        $this->setBeans();
        $r = $this->dao->bind($this->data);
        if($r === true){
            $this->session->setFlash("Liaison du patient à la structure effectuée avec succès");
            $this->redirect("/public/patients.php?action=view&id=". $this->data['idpatient']);
        }else{
            $this->session->setFlash($this->dao->errors);
            $this->redirect($_SERVER['HTTP_REFERER']);
        }
    }

}
