<?php

    namespace controls;
    class Acte extends ControlBase{
        static  $etape =[
            '0' => [1,2,3,4,5],
            '1'=>   [1,2,3,4,5],
            '2'=>   [1,2],
            '3'=>   [4],
            '4'=>   [1,2]
        ];
        public function __construct() {
            parent::__construct();
        }
        
        public function setBeans() {
            
        }

        public function setDao() {
            $this->dao = new \hospital\core\dao\DaoActe();
        }

        public function view($id) {
            
        }
        public function init($data=[]) {
            extract($this->data);
            $this->setDao();
            $r = $this->dao->add($this->data);
            $id = $this->dao->lastId();
            if ($r == false) {
                $this->session->setFlash($this->dao->errors, "danger");
                $this->redirect("/public/actes_medicaux.php?etape=0&action=add", "");
            } else {
                $msg = [
                    "<div class='alert alert-warning'><h2>Attention de ne pas quitter cette page ou de l'actualiser sans pour autant copier la référence de l'acte</h2></div>",
                    "Initialisation réussie avec succès. La référence de cet acte est : <h3> Réf Acte : ".$id."</h3>",
                    "Pour voir le detail <a href='/public/actes_medicaux.php?action=view&id=$id' class='btn btn-metis-2 btn-grad'>Cliquez ici</a> ". 'OU imprimer Géton <a href="/public/print.php?id='.$id .'" class="btn btn-grad btn-success printbtn"><i class="glyphicon glyphicon-print"></i></a>',
                   
                    "Pour remplir les informations de consultation, Veuillez Cliquez sur 'Consultation'  puis indiquez la référence de l'acte ci-haut"
                ];
                $this->session->setFlash($msg);               
                $this->redirect("/public/actes_medicaux.php?etape=1&action=add&id_acte=$id");
            }
        }
        public function del($data=[]) {  
            if($_SESSION['user']['idFonction'] != 0 || $_SESSION['user']['idFonction'] != 1){
                $this->session->setFlash("Vous n'avez pas de privilège d'executer cette opération");
                $this->redirect($_SERVER['HTTP_REFERER']);
            }
            if(isset($data['id']) && !empty($data['id'])){
                extract($data);
                $this->setDao();
                $r = $this->dao->del($id);
                if($r == true){
                    $this->session->setFlash("Suppression de l'acte avec succès");
                    $id = $this->dao->lastId(); 
                    $this->redirect("/public/actes_medicaux.php?");
                }else{
                    $this->session->setFlash("Possible de supprimer", "danger");                    
                    $this->redirect("/public/actes_medicaux.php", "");
                }
            }else{
                $this->session->setFlash("Aucun acte n'a été sélectionné", "danger"); 
            }            
        }
        public function delacte($data=[]) {
            if($_SESSION['user']['idFonction'] == 0 || $_SESSION['user']['idFonction'] == 1){
                if(isset($data['id']) && !empty($data['id'])){
                    extract($data);
                    $this->setDao();
                    $r = $this->dao->delActe($id);
                    if($r == true){
                        $this->session->setFlash("Suppression de l'acte avec succès");
                        $id = $this->dao->lastId(); 
                        $this->redirect("/public/actes_medicaux.php?");
                    }else{
                        $this->session->setFlash("Possible de supprimer", "danger");                    
                        $this->redirect("/public/actes_medicaux.php", "");
                    }
                }else{
                    $this->session->setFlash("Aucun acte n'a été sélectionné", "danger"); 
                }
            }else{
                $this->session->setFlash("Vous n'avez pas de privilège d'executer cette opération", 'warning');
               
            }
             $this->redirect($_SERVER['HTTP_REFERER']);
                        
        }
        
        
        
        function search($data = []) {
            if(isset($data['id']) && !empty($data['id'])){
                extract($data);
                $this->setDao();                
                if($r == true){
                    $this->session->setFlash("Suppression de l'acte avec succès");
                    $id = $this->dao->lastId();                              
                    $this->redirect("/public/actes_medicaux.php?");
                }else{
                    $this->session->setFlash("Possible de supprimer", "danger");                    
                    $this->redirect("/public/actes_medicaux.php", "");
                }
            }else{
                $this->session->setFlash("Aucun acte n'a été sélectionné", "danger"); 
                $this->redirect($_SERVER['HTTP_REFERER']);
            } 
            
        }
        
        function get($data=[]) {
            if(isset($data['id']) && !empty($data['id'])){
                extract($data);
                $this->setDao();
                $condition['fields'] =  "`acte`.`id` AS `idacte`, `acte`.`lib` AS `acte`, `acte`.`id_category` AS `id_cate`, "
                        . "`acte`.`prix_prive`, `acte`.`prix_conventionne`, `acte`.`prix_affilier`, `acte`.`prix`, "
                        . "`agent`.`id` AS `id_agent`, `agent`.`nom` AS `nomagent`, `agent`.`prenom` AS `prenomagent`, "
                        . "`agent`.`fonction`, `category_acte`.`lib` AS `categorie`, `patient`.`idPatient` AS `idPatient`, "
                        . "`patient`.`typePatient`, `patient`.`id_avatar` AS `imgpatient`, `patient`.`nom` AS `nompatient`, "
                        . "`patient`.`prenom` AS `prenompatient`, `patient`.`sexe` AS `sexepatient`, `patient`.`age` AS `agepatient`,"
                        . " `acte_pose`.`id` AS `idactepose`, `acte_pose`.`etape`, `acte_pose`.`date` AS `dateactepose`, download.filename, download.type as typeimg, patient.nu, patient.numinterne";
                
                $condition['where'] = " WHERE acte_pose.id = $id AND acte_pose.id_hopital = " . htmlentities($_SESSION['user']['idhopital']) . " ";
                $condition['joins'] =  [
                    'tables' => ['acte', 'patient', 'agent', 'category_acte', 'download'],
                    'tableBase' => ['acte_pose', 'acte_pose', 'acte_pose','acte', 'patient'],
                    'typeJointure' => ['INNER', 'LEFT', 'LEFT', 'INNER', 'INNER'],
                    'keys' => ['id', 'idPatient', 'id','id', 'id_download'],
                    'primaryKeys' => ['id_acte', 'id_patient', 'id_agent','id_category','id_avatar']
                ];                
                $r = $this->dao->get("acte_pose", $condition);
                return $r;
                
            }else{
                return false;
            }   
        }
        
        public function getActes($data=[]) {
            $this->setDao();
            if(count($data) > 0){
                return $this->dao->getActes($data);
            }else{
                return $this->dao->getActes();
            }
            
        }
        public function getActeNursing($data=[]) {
            $this->setDao();
            if(count($data) > 0){
                return $this->dao->getActeNursing($data);
            }else{
                return $this->dao->getActeNursing();
            }
            
        }
        public function getacteprices($data=[]) {
            $this->setDao();
            if(isset($data['motif']) > 0){
                return $this->dao->getActePrices($data['motif']);
            }else{
                return $this->dao->getActePrices();
            }
            
        }
        

    public function after() {
        
    }

    public function before() {
        //session_destroy();
        $userFonction = $_SESSION['user']['idFonction'];
        
    }
    
    public function addexamen($data=[]) {
        if($_SESSION['user']['idFonction'] == 0 || $_SESSION['user']['idFonction'] == 1 || $_SESSION['user']['idFonction']== 2){
            $this->setDao();
            $r = $this->dao->addExamen($this->data);
            if ($r == false) {
                $this->session->setFlash($this->dao->errors, 'danger');
                $this->redirect($_SERVER['HTTP_REFERER']);
            } else {
                $this->session->setFlash('Examen ajouté avec succès');
                $this->redirect($_SERVER['HTTP_REFERER']);
            }
        }else{
            $this->session->setFlash("Vous n'avez pas de privilège d'executer cette opération", "warning");
            $this->redirect($_SERVER['HTTP_REFERER']);
         }
        
    }
    public function acteinfo($condition=[]) {
        $this->setDao();
        return ($this->dao->findActeInfo($condition));
    }
    public function actetoday() {
        $this->setDao();
        return $this->dao->actetoday();
    }
    public function searchacte($data=[]) {
        $this->setDao();
        if(is_array($data)){
            extract($data);
        }
        return $this->dao->searchActe($id);
       
    }
    public function consultationInfo($condition = []) {
        $this->setDao();
        $r =$this->dao->findConsultationInfo($condition);
        return $r;
    }
    
    public function addconsultationinfo($data=[]) {
        $this->setDao();        
        $r = $this->dao->addconsultationinfo($this->data);
        if($r == true){
            $msg = [
                    "<div class='alert alert-warning'><h2>Consultation enregistrée avec succès</h2></div>",
                    "Pour voir le detail <a href='/public/actes_medicaux.php?action=view&id=".$this->data['acte_medical']."' class='btn btn-metis-2 btn-grad'>Cliquez ici</a>",
                    "Pour remplir les informations de consultation, Veuillez Cliquez sur 'Consultation'  puis indiquez la référence de l'acte ci-haut"
                ];
            $this->session->setFlash($msg);
            $this->redirect("/public/actes_medicaux.php?etape=2&action=add");
        }else{
            $this->session->write('data', $this->data);
            $this->session->setFlash($this->dao->errors, "danger");
            $this->redirect("/public/actes_medicaux.php?etape=1&action=add");                     
        }
    }
    
    function addDiagnostic($data=[]) {
        if($_SESSION['user']['idFonction'] == 0 || $_SESSION['user']['idFonction'] == 1 || $_SESSION['user']['idFonction'] == 2){
            $this->setDao();
            $r = $this->dao->addDiagnostic($this->data);
            $id = $this->dao->lastId();
            
            if ($r == true) {
                $this->session->setFlash('Diagnostisque enregistrée avec succèss... Merci de continuer');
                $this->redirect("/public/actes_medicaux.php?action=examen&m=addexamen&id=".$id);
            } else {
                $this->session->setFlash($this->dao->errors, "danger");
                $this->redirect($_SERVER['HTTP_REFERER']);
            }
        }else{
            $this->session->setFlash("Vous n'avez pas de privilège d'executer cette opération", "warning");
            $this->redirect($_SERVER['HTTP_REFERER']);
        }
        
    }
    function addnursing($data=[]) {
        if($_SESSION['user']['idFonction'] == 3 ){
            $this->setDao();
            $r = $this->dao->addNursing($this->data);
            if ($r == true) {
                $this->session->setFlash('Nursing enregistré avec succèss... Merci de continuer');
                $this->redirect("/public/actes_medicaux.php?action=view&id=" . $this->data['acte_pose']);
            } else {
                $this->session->setFlash($this->dao->errors, "danger");
                $this->redirect($_SERVER['HTTP_REFERER']);
            }
        }else{
            $this->session->setFlash("Vous n'avez pas de privilège d'executer cette opération", "warning");
            $this->redirect($_SERVER['HTTP_REFERER']);
        }
        
    }
    
    function getActeOfStructures($id="") {
        $this->setDao();        
        $r = $this->dao->getActeOfStructures($id);
        if(is_array($r) && count($r) > 0){            
            return $r;
        }else{
            return null;
        }
    }
    
    function getListExamen($id="") {
        $this->setDao();        
        $r = $this->dao->getListExamen($id);
        if(is_array($r) && count($r) > 0){            
            return $r;
        }else{
            return 0;
        }
    }
    function getdiagnostic($id="") {
        $this->setDao();
       
        if(isset($id) && !empty($id)){
           $r = $this->dao->getDiagnostics($id);
        }else{
            $r = $this->dao->getDiagnostics();
        }
        return $r;        
    }
     function searchdiagnostic($data=[]) {
        $this->setDao();
        extract($data);
      
        if(isset($data['motif']) && !empty($data['motif'])){
           $r = $this->dao->searchDiagnostics($data['motif']);
        }else{
            $r = $this->dao->searchDiagnostics();
        }
        return $r;        
    }
    
    function getcustomediagnostic($condition =[]) {
        $this->setDao();
        $r = $this->dao->customDiagnostic($condition);        
        return $r;        
    }
    function getnursing($data =[]) {
        $this->setDao();
        extract($data);
        $r = $this->dao->getNursing($id);
        return $r;
    }
    
    function getdiagnosticbydate($data=[]) {
        $this->setDao();
        extract($data);
        if(isset($data['date']) && !empty($date)){
           $r = $this->dao->getPatient($date);
        }else{
            $r = $this->dao->getDiagnosticsByDate();
        }        
        return $r;
        
    }
    function getrecommandexamen($id="") {
        $this->setDao();       
        if(isset($id) && !empty($id)){
           $r = $this->dao->getRecommandExamForExam($id);
        }else{
            $r = $this->dao->getRecommandExamForExam();
        }
        return $r;
           
    }
    
    public function removerecomamandexamen($data=[]) {
        if($_SESSION['user']['idFonction'] == 0 || $_SESSION['user']['idFonction'] == 1 || $_SESSION['user']['idFonction'] == 2){
            $this->setDao();
            extract($data);
            if (isset($data['id']) && !empty($id)) {
                $r = $this->dao->removerecomamandexamen($id);
            } else {
                $r = $this->dao->removerecomamandexamen();
            }
            if ($r == true) {
                $this->session->setFlash("Enlevement de l'examen reussi avec succes");
                $this->redirect($_SERVER['HTTP_REFERER']);
            }
            $this->session->setFlash($this->dao->errors);
            $this->redirect($_SERVER['HTTP_REFERER']);
        }else{
            $this->session->setFlash("Vous n'avez pas de privilège d'executer cette opération",'warning');
            $this->redirect($_SERVER['HTTP_REFERER']);
        }
        
    }
    
    public function getlistacte($data=[]) {
        $this->setDao();
        extract($data);        
        if(isset($data['id']) && !empty($id)){
           $r = $this->dao->getListActe($id);
        }else{
            $r = $this->dao->getListActe();
        }         
        return $r;
         
    }
    
    public function getcustomacte($condition = []) {        
        $this->setDao();        
        $r = $this->dao->costumersearchActe($condition);        
        return $r;
        
    }
    
    public function getcustomexamengroup($condition="") {
        $this->setDao();
        $r = $this->dao->getCustomExamenGroup();
        return $r;
    }
    public function getcustomexamenitem($condition="") {
        $this->setDao();
        $r = $this->dao->getCustomExamenItem($condition);
        return $r;
    }
    
    public function getcustomexamen($condition="") {
        $this->setDao();
        $r = $this->dao->getCustomExamen($condition);
        return $r;
    }
    public function doexamen() {
        if($_SESSION['user']['idFonction'] == 0 || $_SESSION['user']['idFonction'] == 4){
            $this->setDao();
            $r = $this->dao->doExamen($this->data);
            if ($r === true) {
                $this->session->setFlash("Confirmation examen portant ref " . $this->data['examen'] . " a été faite avec succès");
                $this->redirect($_SERVER['HTTP_REFERER']);
            } else {
                $this->session->setFlash($this->dao->errors, "danger");
                $this->redirect($_SERVER['HTTP_REFERER']);
            }
        }else{
            $this->session->setFlash("Vous n'avez pas de privilège d'executer cette opération",'warning');
            $this->redirect($_SERVER['HTTP_REFERER']);
        }
        
    }
    
    public function doprelever() {
        if($_SESSION['user']['idFonction'] == 0 || $_SESSION['user']['idFonction'] == 4){
            $this->setDao();
            $r = $this->dao->doPrelever($this->data);
            if ($r === true) {
                $this->session->setFlash("Confirmation prélèvement examen portant ref " . $this->data['examen'] . " a été faite avec succès");
                $this->redirect($_SERVER['HTTP_REFERER']);
            } else {
                $this->session->setFlash($this->dao->errors, "danger");
                $this->redirect($_SERVER['HTTP_REFERER']);
            }
        }else{
            $this->session->setFlash("Vous n'avez pas de privilège d'executer cette opération",'warning');
            $this->redirect($_SERVER['HTTP_REFERER']);
        }
        
    }
    
    public function getPrescription($condition=[]) {
        $this->setDao();
        $r = $this->dao->getPrescriptions($condition);
        return $r;
    }
    public function getPrescriptionCountEle($condition=[]) {
        $this->setDao();
        $r = $this->dao->getElementPrescritWithCount($condition);
        return $r;
    }
    
    public function getelementPrescritbyprescritionId($condition=[]) {
        $this->setDao();
        $r = $this->dao->getElementPrescritByPrescritionId($condition);
        return $r;
    }
    
    public function getconsultations($condition = "") {
        $this->setDao();
        return $this->dao->getConsultations($condition);
    }    
    public function removeelementfromprescrire($data=[]) {        
        /*
         @ $idPrescription
         @ $idElement
         */
        if($_SESSION['user']['idFonction'] == 0 || $_SESSION['user']['idFonction'] == 1 || $_SESSION['user']['idFonction'] == 2){
            $this->setDao();
            extract($data);            
            $r = $this->dao->removeelementfromprescrire($idelement);
            if($r == true){
                $this->session->setFlash("Element élevé avec succès");
                $this->redirect($_SERVER['HTTP_REFERER']);
            } else {
                $this->session->setFlash("Element non élevé, opération annulée, peut être une erreur est surgie lors de l'élevement","danger");
                $this->redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            $this->session->setFlash("Vous n'avez pas de privilège d'executer cette opération","warning");
            $this->redirect($_SERVER['HTTP_REFERER']);
        }
        
    }
    public function addelementoprescription() {      
        if($_SESSION['user']['idFonction'] == 0 || $_SESSION['user']['idFonction'] == 1 || $_SESSION['user']['idFonction'] == 2){
            $this->setDao();
            $r = $this->dao->addElemenToPrescription($this->data);

            if ($r == true) {
                $this->session->setFlash("Un nouvel élément de la prescription a été ajouté avec succès");
            } else {
                $this->session->setFlash($this->dao->errors, "danger");
            }
            $this->redirect($_SERVER['HTTP_REFERER']);
        } else {
            $this->session->setFlash("Vous n'avez pas de privilège d'executer cette opération", 'warning');
            $this->redirect($_SERVER['HTTP_REFERER']);
        }
        
    }    
    public function initprescription($data=[]) {
        if($_SESSION['user']['idFonction'] == 0 || $_SESSION['user']['idFonction'] == 1 || $_SESSION['user']['idFonction'] == 2){
            $this->setDao();
            $r = $this->dao->initPrescription($this->data);
            $id = $this->dao->lastId();
            if ($r == true) {
                $this->session->setFlash("Initialisation prescription reussie. vous pouvez ajouter maintenant ");
                $this->redirect("/public/actes_medicaux.php?action=prescrire&m=viewdetail&id=$id");
            } else {
                $this->session->setFlash($this->dao->errors, "danger");
                $this->redirect($_SERVER['HTTP_REFERER']);
            }
        }else{
            $this->session->setFlash("Vous n'avez pas de privilège d'executer cette opération","warning");
            $this->redirect($_SERVER['HTTP_REFERER']);
        }
        
    }
    
    public function getlits($condition=[]) {
        $this->setDao();
        return $this->dao->getLits($condition);
    }
    public function getchambre($condition=[]) {
        $this->setDao();
        return $this->dao->getChambre($condition);
    }
    public function gethospitalisation($condition=[]) {
        $this->setDao();
        return $this->dao->getHospitalisation($condition);
    }
    
    public function hospitaliser() {
        if($_SESSION['user']['idFonction'] == 0 || $_SESSION['user']['idFonction'] == 1 || $_SESSION['user']['idFonction'] == 2){
            $this->setDao();
            $r = $this->dao->hospitaliser($this->data);
            $id = $this->dao->lastId();
            if ($r == true) {
                $this->session->setFlash("Hospitalisation du patient reussie avec succès");
            } else {
                $this->session->setFlash($this->dao->errors, "danger");
            }
            $this->redirect($_SERVER['HTTP_REFERER']);
        }else{
            $this->session->setFlash("Vous n'avez pas de privilège d'executer cette opération", "warning");
            $this->redirect($_SERVER['HTTP_REFERER']);
        }
        
    }
    public function deshospitaliser($data=[]) {
        extract($data);
        
        if($_SESSION['user']['idFonction'] == 0 || $_SESSION['user']['idFonction'] == 1 || $_SESSION['user']['idFonction'] == 2){
             $this->setDao();
            $r = $this->dao->deshospitaliser($this->data);
            if ($r == true) {
                $this->session->setFlash("Libération du patient réussie avec succès");
                $this->redirect($_SERVER['HTTP_HOST'] . "/public/actes_medicaux.php?action=view&id=" .$id);
            } else {
                $this->session->setFlash($this->dao->errors, "danger");
            }
            $this->redirect($_SERVER['HTTP_REFERER']);
        }else{
             $this->session->setFlash("Vous n'avez pas de privilège d'executer cette opération", "warning");
             $this->redirect($_SERVER['HTTP_REFERER']);
         }       
    }   
    
    public function transferer($data=[]) {
        extract($this->data);
        
        if($_SESSION['user']['idFonction'] == 0 || $_SESSION['user']['idFonction'] == 1 || $_SESSION['user']['idFonction'] == 2){
             $this->setDao();
            $r = $this->dao->transferer($this->data);
            if ($r == true) {
                $this->session->setFlash("Libération du patient réussie avec succès");
                $this->redirect("/public/actes_medicaux.php?action=view&id=" .$id);
            } else {
                $this->session->setFlash($this->dao->errors, "danger");
            }
            $this->redirect($_SERVER['HTTP_REFERER']);
        }else{
             $this->session->setFlash("Vous n'avez pas de privilège d'executer cette opération", "warning");
             $this->redirect($_SERVER['HTTP_REFERER']);
         }       
    }   
    
    public function searchactes($data="") {
         $this->setDao();
         extract($data);
         $r = $this->dao->searchActe($q);
         return $r;
    }
    public function getexamenrices($data=[]) {
         $this->setDao();
         extract($data);
         if(isset($data['motif']) && !empty($data['motif'])){
             $r = $this->dao->getExamenPrices($motif);
         }else{
             $r = $this->dao->getExamenPrices();
         }         
         return $r;
    }
    public function facturer() {
        $this->setDao();
        if(isset($this->data['comptabled'])){
            if (($_SESSION['user']['idFonction'] != 6)) {
                $this->session->setFlash("Vous n'avez de privilèges d'exécuter cette opération, Prière de contacter l'administrateur pour plus info", "warning");
                $this->redirect($_SERVER['HTTP_REFERER']);
            }
        }
        $r = $this->dao->facturer($this->data); 
        if($r===true){
            $this->session->setFlash("Facturation recue avec succès, prière d'imprimer la facture");
        }else{
            $this->session->setFlash($this->dao->errors, 'danger');
        }        
        $this->redirect($_SERVER['HTTP_REFERER']);     
    }
    
    public function getfacture($condition=[]) {
        $this->setDao();
        return $this->dao->getFacture($condition);
    }
    public function getfacturetotal($condition=[]) {
        $this->setDao();
        return $this->dao->getFactureTotal($condition);
    }
    public function delfacture($data=[]) {
        $this->setDao();
        extract($data);
        if(!isset($id) || empty($id)){
            $this->session->setFlash("Une facture n'a été sélectionnée", "warning");
            $this->redirect($_SERVER['HTTP_REFERER']);
        }  
        if ($_SESSION['user']['idFonction'] == 6 || ($_SESSION['user']['idFonction'] == 0)) {
            $r = $this->dao->delfacture($id);
            if($r == true){
                $this->session->setFlash('la facture a été supprimée avec succès');
            }else{
                $this->session->setFlash("Une erreur est surgie lors de la suppression de la facture, si cette erreur persiste prière de contacter l'administrateur du système", 'danger');
            }
            $this->redirect($_SERVER['HTTP_REFERER']);
        }else{
            $this->session->setFlash("Vous n'avez de privilèges d'exécuter cette opération, Prière de contacter l'administrateur pour plus info", "warning");
            $this->redirect($_SERVER['HTTP_REFERER']);
        }
    }
    public function getListExtra() {
        $this->setDao();
        return $this->dao->getListeExtrat();
    }
    
    public function addextrat($params) {
        $this->setDao();
    
        if($_SESSION['user']['idFonction'] == 0 || $_SESSION['user']['idFonction'] == 1 || $_SESSION['user']['idFonction'] == 2){
            $this->setDao();
            $r = $this->dao->addExtra($this->data, $params['id']);
          
            if ($r == true) {
                $this->session->setFlash("Un nouvel élément de la prescription a été ajouté avec succès");
            } else {
                $this->session->setFlash($this->dao->errors, "danger");
            }
            $this->redirect($_SERVER['HTTP_REFERER']);
        } else {
            $this->session->setFlash("Vous n'avez pas de privilège d'executer cette opération", 'warning');
            $this->redirect($_SERVER['HTTP_REFERER']);
        }        
        
    }
    
    public function getRecommandListExtra($params) {
        extract($params);
        return $this->dao->getRecommandListExtra($id);
    }
    
    public function getExtraDetail($params) {
        extract($params);
        return $this->dao->getRecommandExtra($id);
    }
    
    public function getPrelevementExamForExam($params) {
        extract($params);
        return $this->dao->getPrelevementExamForExam($examen);
    }
    
    
}
