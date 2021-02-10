<?php

namespace controls;

class Patient extends ControlBase {

    public function setBeans() {
        $this->beans = new \hospital\core\beans\Patient();
    }

    public function setDao() {
        $this->dao = new \hospital\core\dao\DaoPatient();
    }

    public function add() {
        $this->setDao();
        if (isset($_FILES['imgAgent']) && count($_FILES['imgAgent']['name']) > 0 && strlen($_FILES['imgAgent']['name'][0]) > 0) {
            $imgController = new \composants\Download(ROOT . DS . "img/personnel/");
            $s = $imgController->addFiles($_FILES, "imgAgent");
            $this->data['agentPhoto'] = $s['ids'][0];
        }
        $this->data['id_hopital'] = $_SESSION['user']['idhopital'];
        $this->data['province'] = $_SESSION['user']['province'];
        $this->data['id_property'] = $_SESSION['user']['property'];
       
        
        
        $r = $this->dao->add($this->data);
        if ($r == false) {
            $this->session->setFlash($this->dao->errors, "danger");
            $this->session->write("patient", $this->data);
            $this->redirect("/public/patients.php?action=add", "");
        } else {
            $this->session->setFlash("Patient créé avec succès");
            $condition['where'] = " where patient.idPatient = " . $this->dao->lastId();
           
            $i = $this->dao->lastId();
         
            $patient = $this->dao->get("patient", $condition);
            $this->session->write("patient", $patient);
            $this->redirect("/public/patients.php?action=view&id=" . $i);
        }
    }
    public function update() {
        $this->setDao();
        if (isset($_FILES['imgAgent']) && count($_FILES['imgAgent']['name']) > 0 && strlen($_FILES['imgAgent']['name'][0]) > 0) {
            $imgController = new \composants\Download(ROOT . DS . "img/personnel/");
            $s = $imgController->addFiles($_FILES, "imgAgent");
            $this->data['agentPhoto'] = $s['ids'][0];
        }
        $r = $this->dao->modifier($this->data);
        if ($r == false) {
            $this->session->setFlash($this->dao->errors, "danger");
            $this->session->write("patient", $this->data);
            $this->redirect("/public/patients.php?action=edit&id=" . $this->data['idpatient'], "");
        } else {
            $this->session->setFlash("Lies informations du patient ont été mises à jour avec succès");
            $condition['where'] = " where patient.idPatient = " . $this->data['idpatient'];
            $patient = $this->dao->get("patient", $condition);
            $this->session->write("patient", $patient);
            $this->redirect("/public/patients.php?action=view&id=" . $this->data['idpatient']);
        }
    }

    public function edit($data = []) {
        $this->setDao();
        if (isset($data['id'])) {
            $id = $data['id'];
            $condition['where'] = " WHERE idPatient = $id";
            $r = $this->dao->getPatient($id);
            if (count($r) > 0) {
                $this->session->write('data', $r);
                $this->redirect("/public/patients.php?action=edit&id=$data[id]");
            } else {
                $this->session->setFlash('Patient non trouvée', 'warning');
                $this->redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            $this->session->setFlash('Patient non sélectionné', 'warning');
            $this->redirect($_SERVER['HTTP_REFERER']);
        }
        return $r;
    }

    public function getList($statut = "") {
        $this->setDao();
        $condition['joins'] = [
            'tables' => ["structureaffilier", 'download'],
            'tableBase' => ['patient', "patient"],
            'typeJointure' => ["LEFT", 'INNER'],
            'keys' => ["id", 'id_download'],
            'primaryKeys' => ["idStructure", 'id_avatar']
        ];
        //\composants\Utilitaire::debug($statut, true);
        if($statut != null){
            $condition['where'] = " where patient.statut = '". addslashes(htmlentities($statut)) ."' AND patient.id_hopital = " .htmlentities($_SESSION['user']['idhopital']);
        }else{
        $condition['where'] = " where patient.id_hopital = " .htmlentities($_SESSION['user']['idhopital']);
        }
        $condition['order'] = " patient.nom ASC ";
        return $this->dao->paginate("patient", $condition, 100);
    }
    
    
    public function getListNormal($statut = "") {
        $this->setDao();
        $condition['joins'] = [
            'tables' => ["structureaffilier", 'download'],
            'tableBase' => ['patient', "patient"],
            'typeJointure' => ["LEFT", 'INNER'],
            'keys' => ["id", 'id_download'],
            'primaryKeys' => ["idStructure", 'id_avatar']
        ];
        if($statut != null){
            $condition['where'] = " where patient.statut = '". (htmlentities($statut)) ."' AND patient.id_hopital = " .htmlentities($_SESSION['user']['idhopital']);
        }else{
        $condition['where'] = " where patient.id_hopital = " .htmlentities($_SESSION['user']['idhopital']);
        }
        $condition['order'] = " patient.nom ASC ";
        return $this->dao->get("patient", $condition);
    }


    public function get($id) {
        if (is_array($id)) {
            extract($id);
        }
        $condition['where'] = " WHERE idPatient = '$id' ";
        $condition['fields'] = "`patient`.*, `structureaffilier`.`raisonsociale`, `structureaffilier`.`responsable`, `structureaffilier`.`adresse` AS `adressestructure`, `structureaffilier`.`contact` AS `telstructure`, `structureaffilier`.`typefk`, `download`.`filename`, `download`.`type`, `structureaffilier`.`id`, `typestructure`.*, patient.statut as statutp";
        $condition['joins'] = [
            'tables' => ['download', 'structureaffilier', 'typestructure'],
            'tableBase' => ['patient', 'patient', 'structureaffilier'],
            'typeJointure' => ['INNER', 'LEFT', 'LEFT'],
            'keys' => ['id_download', 'id', 'idtypestructure'],
            'primaryKeys' => ['id_avatar', 'idStructure', 'typefk']
        ];
        $this->setDao();
        return $this->dao->get('patient', $condition);
    }
    public function getByStructure($id) {
        if (is_array($id)) {
            extract($id);
        }
        $condition['where'] = " WHERE structureaffilier.id = '$id' ";
        $condition['fields'] = "`patient`.*, `structureaffilier`.`raisonsociale`, `structureaffilier`.`responsable`, `structureaffilier`.`adresse` AS `adressestructure`, `structureaffilier`.`contact` AS `telstructure`, `structureaffilier`.`typefk`, `download`.`filename`, `download`.`type`, `structureaffilier`.`id`, `typestructure`.*";
        $condition['joins'] = [
            'tables' => ['download', 'structureaffilier', 'typestructure'],
            'tableBase' => ['patient', 'patient', 'structureaffilier'],
            'typeJointure' => ['INNER', 'LEFT', 'LEFT'],
            'keys' => ['id_download', 'id', 'idtypestructure'],
            'primaryKeys' => ['id_avatar', 'idStructure', 'typefk']
        ];
        $this->setDao();
        return $this->dao->get('patient', $condition);
    }

    public function view($id) {
        extract($_GET);
        $this->setDao();
        $this->session->write('patient', $this->get($id));
        $this->redirect("/public/patients.php?action=view&id=$id");
    }

    public function after() {
        
    }

    public function before() {
        
    }

    public function getpatient($data = []) {
        $this->setDao();
        if (isset($data['id'])) {
            $id = $data['id'];
            $condition['where'] = " WHERE idPatient = $id";
            $r = $this->dao->getPatient($id);
        } else {
            $r = $this->dao->getPatient();
        }
        return $r;
    }

    public function searchpatient($data = []) {
        $this->setDao();
        extract($data);
        //\composants\Utilitaire::debug($data, true);
        if (isset($data['patient'])) {
            $id = $data['patient'];
            $r = $this->dao->searchPatient($id);
        } elseif(isset ($data['q'])){
            $r = $this->dao->searchPatient($data['q']);
        } else {
            $r = $this->dao->searchPatient();
        }
        return $r;
    }

    public function addAnt($id) {
        $this->setDao();
        $return = $this->dao->addAnt($id['id'], $this->data);
        if ($return == true) {
            return (['valide' => true]);
        }
        return (['valide' => false, 'error' => $this->dao->errors]);
    }

    public function getAntecedent($idPatient) {
        return $this->dao->getAntecedent($idPatient);
    }
    
    public function deceder($data=[]) {
        $this->setDao();
     
        $r = $this->dao->deceder($this->data);
        if($r === true){
            $this->session->setFlash("Changement du statut du patient effectué avec succès");
            $this->redirect("/public/patients.php?action=view&id=". $this->data['idpatient']);
        }else{
            $this->session->setFlash($this->dao->errors, "danger");
            $this->redirect($_SERVER['HTTP_REFERER']);
        }
    }
}
