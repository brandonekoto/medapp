<?php
namespace controls;

class Structureaffilie extends ControlBase{
    //put your code here
    public function setBeans() {        
       
    }

    public function setDao() {
         $this->dao =  new \hospital\core\dao\DaoStructureAffilier();
    }
    
    public function add() {
        $this->setDao();
        $r = $this->dao->add($this->data);
        if ($r == false) {
            $this->session->setFlash($this->dao->errors, "danger");
            $this->redirect("/public/structures_affilies.php?action=add", "");
        } else {
            $this->session->setFlash("Structure créée avec succès");
            $id = $this->dao->lastId();
            $condition['where'] = " where structureaffilier.id = " . $id;
           
            $patient = $this->dao->get("structureaffilier", $condition);
        
            //$this->session->write("structureaffilier", $patient);
            
            $this->redirect("/public/structures_affilies.php?action=view&id=".$id."", "");
        }
    }
    
    public function addActesToStructure($ids) {
        $this->setDao();
        extract($ids);
        //\composants\Utilitaire::debug($this->data, true);
        $r = $this->dao->addActes($this->data);        
        
        
        if ($r == false) {
            $this->session->setFlash($this->dao->errors, "danger");
            $this->redirect("/public/structures_affilies.php?action=add", "");
            http_response_code(500);
        } else {
            //$this->session->setFlash("Opération réussie avec succès");
            $res = new \stdClass();
            $res->id = $id;
            return $res;
        }
    }
    
    public function getList() {
        $this->setDao();
        return $this->dao->paginate("structureaffilier", null,10);
    }
    
    public function get($id) {
        $condition['where'] = " WHERE id = $id";
        $this->setDao();
        return $this->dao->get('structureaffilier', $condition);
    }
    
     public function del($id) {
         
        $condition['where'] = " WHERE id = '". $_GET['id'] ."' ";
        $this->setDao();
        $d = $this->dao->get('structureaffilier', $condition);
        if($d != null && count($d) > 0){
            $r = $this->dao->delete("id", $_GET['id'], "acte");
            if($r == true){
                $this->session->setFlash("Suppression effectuée avec succes");
                
                $this->redirect($_SERVER['HTTP_REFERER']);
            }
        }else{
            return -1;
        }
    }
    public function view($id) {
        extract($_GET);
        $condition['where'] = " WHERE id = $id";
        $this->setDao();
        $this->session->write('structure', $this->dao->get('structureaffilier', $condition, 10));
        
        
        $this->redirect("/public/structures_affilies.php?action=view&id=".$_GET['id']);
    }
    public function getMembers($data=[]) {        
        $this->setDao();
        return $this->dao->getMembers($data);
    }
    
    public function after() {
        
    }

    public function before() {
        
    }

}
