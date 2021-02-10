<?php

namespace hospital\core\dao;
class DaoPatient extends \model\Model {
    
    public function __construct($options = array()) {
        parent::__construct($options);
    }
    
    
    public function setPatient(Patient $p) {
        $respond = false;
        try {
            $ps = $this->cnx->prepare("insert into patient(nom,postnom,prenom,genre,dateNaiss,contact,adresse,typePatient,numAffiation) values(?,?,?,?,?,?,?,?,?)");
            $respond = $ps->execute(array($p->getNom(), $p->getPostnom(), $p->getPrenom(), $p->getGenre(), $p->getdateNaiss(), $p->getContact(), $p->getAdresse(), $p->getTypePatient(), $p->getNumAffiation()));
        } catch (Exception $ex) {
            $respond = false;
        }
        return $respond;
    }
    
    public function add($data=[]) {
        extract($data);
        $this->valideData($nom, "#^[a-zA-Z\s-]{2,30}$#", "Le nom ne doit être vide et doit commencer par une Majuscule suivi des lettres miniscules maximum 30 caractères", "Nom");
        $this->valideData($postnom, "#^[A-Za-z\s-]{2,30}$#", "Le postnom ne doit être vide et doit commencer par une Majuscule suivi des lettres miniscules maximum 30 caractères", "Postnom");
        $this->valideData($prenom, "#^[A-Za-z\s-]{2,30}$#", "Le Prénom ne doit être vide et doit commencer par une Majuscule suivi des lettres miniscules maximum 30 caractères", "Prénom");
        $this->valideData($dateNaiss, "#^[0-9]{4}-(0[1-9]| 1[0-2])-[0-9]{2}$#", "La date de naissance ne doit être vide et doit respecter le format (AAAA/MM/JJ) Ex: 2019,10,15", "date");
        $this->valideData($adresse, "#^(.{1,100})$#", "L'adresse ne doit être vide et doit contenir que les lettres [A-Za-z0-9] ces caractères - _ , / ", "Adresse");
        $this->valideData($lieuNaiss, "#^[\w\s-]{2,90}$#", "Le Lieu de naissance ne doit être vide et doit composé des caractères simples", "date");
        $this->valideData($etatCivil, "#^c|m|d|v$#", "L'Etat civil ne doit être vide et Veuillez sélectionner un parmi ces choix (Celibataire, mariée, divorcé, veuf (ve))", "Etat civil");
        $this->valideData($sexe, "#^M|F$#", "Le sexe ne doit être vide et Veuillez sélectionner un parmi ces choix (Masculin ou Féminin", "Sexe");
        $this->valideData($type, "#^[0-3]$#", "Le type ne doit être vide et Veuillez sélectionner un parmi ces choix (Ordinaire, Affilié Externe, Affilié interne)", "Type");
        $this->valideData($telephone, "#^\+(\d){1,4}(\d){10}$#", "Le numéro de téléphone doit être vide et doit respecter le format (+CODE CCCCCCCCCC) suivi des chiffres ", "Téléphone");
        $this->valideData($email, "#^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$#i", "L'Adresse email doit être vide et doit respecter le format ([a-z] host.domaine) Exemple  : exemple@exemple.com", "Adresse email", false);
        
        //$this->valideData($email, "#^[\w-._]+@[\w.-]+\.[a-z]{2,}$#i", "L'Adresse email doit être vide et doit respecter le format ([a-z] host.domaine) Exemple  : exemple@exemple.com", "Adresse email", false);
        
        
        $this->valideData($sang, "#A|B|AB|O#i", "Le groupe sanguin n'est pas inséré ou n'est pas valide", "Groupe Sanguin", false);
        
        if(count($this->errors)>0){
            return false;
        }else{
            $data =  new \stdClass();
            $data->nom = strtoupper($nom);
            $data->postnom = strtoupper($postnom);
            $data->prenom = strtoupper($prenom);
            $data->age = $dateNaiss;
            $data->adresse = $adresse;
            $data->lieuNaiss = strtoupper($lieuNaiss);
            $data->id_hopital = $id_hopital;
            $data->etatCivil = $etatCivil;
            $data->email = $email;
            $data->typePatient = $type;
            $data->group_sanguin = $sang;
            $data->sexe = $sexe;
            $data->contact = $telephone;
            $data->id_property = $id_property;
            
            $nu = null ;
            $nu .= strrev(ucfirst(substr(explode("-",$data->age)[0], 0, 4)));
            $nu .= ucfirst(substr(explode("-",$data->age)[1], 0, 2));
            $nu .= ucfirst(substr(explode("-",$data->age)[2], 0, 2));
            $nu .= $this->translateInAsciiCode($data->nom);
            $nu .= $this->translateInAsciiCode($data->prenom);
            
            //$nu .= ucfirst(substr($data->nom, 0, 3));
            //$nu .= ucfirst(substr($data->prenom, 0, 3));
            
           
            $nu .= "-".ucfirst(substr($_SESSION['user']['hopital'], 0, 3));
            $nu .= ucfirst(($_SESSION['user']['idhopital']));
           
            $nu .= "/".(count($this->get("patient")) != null && is_numeric(count($this->get("patient"))) ? count($this->get("patient")) + 1 : 1);
            $nu .= "/".ucfirst(substr(date("Y"), 0, -2));
            $data->nu =  $nu;
            
            $condition['fields'] = " max(numinterne) as max ";
            $condition['where'] = " where patient.nom LIKE '%".substr($data->nom, 0,1)."' ";
            $maxp = $this->get("patient", $condition);
            if($maxp != null && count($maxp) > 0){
                $data->numinterne =  ($maxp[0]->max) + 1;
            }else{
                $data->numinterne = 1;
            }
         
            if(isset($agentPhoto) && !empty($agentPhoto)){
                $data->id_avatar = $agentPhoto;
            }
            return $this->input($data, "patient"); 
            
        }       
    }
    
    public function deceder($data=[]) {
        extract($data);
       
        $this->valideData($cause, "#^[a-zA-Z\s-]{2,100}$#", "Le nom ne doit être vide et doit commencer par une Majuscule suivi des lettres miniscules maximum 30 caractères", "Nom");
        $this->valideData($lieu_deces, "#^[A-Za-z\s-]{2,50}$#", "Le postnom ne doit être vide et doit commencer par une Majuscule suivi des lettres miniscules maximum 30 caractères", "Postnom");        
        $this->valideData($date_deces, "#^[0-9]{4}-(0[1-9]| 1[0-2])-[0-9]{2}$#", "La date de naissance ne doit être vide et doit respecter le format (AAAA/MM/JJ) Ex: 2019,10,15", "date");
        $this->valideData($observation_deces, "#^(.{1,100})$#", "L'adresse ne doit être vide et doit contenir que les lettres [A-Za-z0-9] ces caractères - _ , / ", "Observation");
        
        $patient = $this->getPatient($idpatient);
        if(count($patient) != 1){
            array_push($this->errors, "Aucun patient trouvé");
        }
        
        
        if(count($this->errors)>0){
            return false;
        }else{
            $data =  new \stdClass();
            $data->date_deces = strtoupper($date_deces);
            $data->lieu_deces = strtoupper($lieu_deces);
            $data->statut = 1;
            $data->observation_deces = strtoupper($observation_deces);
            $data->agent_deces = $_SESSION['user']['agent'];
            $data->cause = $cause;  
            $condition['where'] =  " WHERE patient.idPatient = $idpatient";
            return $this->update($condition, $data, "patient");  
            
            
        }       
    }
    
    public function modifier($data=[]) {
        extract($data);
        $this->valideData($nom, "#^[a-zA-Z]{2,30}$#", "Le nom ne doit être vide et doit commencer par une Majuscule suivi des lettres miniscules maximum 30 caractères", "Nom");
        $this->valideData($postnom, "#^[A-Za-z]{2,30}$#", "Le postnom ne doit être vide et doit commencer par une Majuscule suivi des lettres miniscules maximum 30 caractères", "Postnom");
        $this->valideData($prenom, "#^[A-Za-z]{2,30}$#", "Le Prénom ne doit être vide et doit commencer par une Majuscule suivi des lettres miniscules maximum 30 caractères", "Prénom");
        $this->valideData($dateNaiss, "#^[0-9]{4}-(0[1-9]| 1[0-2])-[0-9]{2}$#", "La date de naissance ne doit être vide et doit respecter le format (AAAA/MM/JJ) Ex: 2019,10,15", "date");
        $this->valideData($adresse, "#^(.{1,100})$#", "L'adresse ne doit être vide et doit contenir que les lettres [A-Za-z0-9] ces caractères - _ , / ", "Adresse");
        $this->valideData($lieuNaiss, "#^\w{2,90}$#", "Le Lieu de naissance ne doit être vide et doit composé des caractères simples", "date");
        $this->valideData($etatCivil, "#^c|m|d|v$#", "L'Etat civil ne doit être vide et Veuillez sélectionner un parmi ces choix (Celibataire, mariée, divorcé, veuf (ve))", "Etat civil");
        $this->valideData($sexe, "#^M|F$#", "Le sexe ne doit être vide et Veuillez sélectionner un parmi ces choix (Masculin ou Féminin", "Sexe");
        $this->valideData($type, "#^[0-3]$#", "Le type ne doit être vide et Veuillez sélectionner un parmi ces choix (Ordinaire, Affilié Externe, Affilié interne)", "Type");
        $this->valideData($telephone, "#^\+(\d){1,4}(\d){10}$#", "Le numéro de téléphone doit être vide et doit respecter le format (+CODE CCCCCCCCCC) suivi des chiffres ", "Téléphone");
        $this->valideData($email, "# ^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$#i", "L'Adresse email doit être vide et doit respecter le format ([a-z] host.domaine) Exemple  : exemple@exemple.com", "Adresse email");
        $this->valideData($sang, "#A|B|AB|O#i", "Le groupe sanguin n'est pas inséré ou n'est pas valide", "Groupe Sanguin", false);
        $patient = $this->getPatient($idpatient);
        if(count($patient) !== 1){
            array_push($this->errors, "Aucun patient trouvé");
        }
        
        if(count($this->errors)>0){
            return false;
        }else{
            
            $data =  new \stdClass();
            $data->nom = strtoupper($nom);
            $data->postnom = strtoupper($postnom);
            $data->prenom = strtoupper($prenom);
            $data->age = $dateNaiss;
            $data->group_sanguin = $sang;
            $data->adresse = $adresse;
            $data->lieuNaiss = $lieuNaiss;
            $data->etatCivil = $etatCivil;
            $data->email = strtolower($email);
            $data->typePatient = $type;
            $data->sexe = $sexe;
            $data->contact = $telephone;
            
            if(isset($agentPhoto) && !empty($agentPhoto)){
                $data->id_avatar = $agentPhoto;
            }
            $condition['where'] =  " WHERE patient.idPatient = $idpatient";
            $this->update($condition, $data, "patient");     
            return true;
        }       
    }
    public function getPatients() {
        $respond = null;

        try {
            $db = $this->connection();
            $ps = $db->query("select * from patient order by nom asc limit 7");
            $respond = json_encode($ps->fetchAll(PDO::FETCH_ASSOC));
        } catch (Exception $th) {
            
        }

        return $respond;
    }

    public function findPatient($str) {
        $respond = null;
        try {
            $db = $this->connection();
            $ps = $db->query("select * from patient where nom like('" . $str . "%') order by nom limit 7");
            $respond = json_encode($ps->fetchAll(PDO::FETCH_ASSOC));
        } catch (Exception $th) {
            
        }
        return $respond;
    }

    public function findPatientByStructure($str) {
        $respond = null;
        try {
            $db = $this->connection();
            $ps = $db->query("select * from patient where numAffiation=" . $str . "");
            $respond = json_encode($ps->fetchAll(PDO::FETCH_ASSOC));
        } catch (Exception $th) {
            
        }
        return $respond;
    }

    public function del($id) {
        $respond = null;
        try {
            $db = $this->connection();
            $ps = $db->prepare("delete from patient where idPatient=?");
            $respond = $ps->execute(array($id));
        } catch (Exception $th) {
            
        }
        return $respond;
    }
    
    public function getPatient($id='') {
        
        $condition['joins'] = [
                'tables' => ['download'],
                'tableBase' => ['patient'],
                'typeJointure' => ['INNER'],
                'keys' => ['id_download'],
                'primaryKeys' => ['id_avatar']
            ];
        if(isset($id) && !empty($id)){
            $condition['where'] = " WHERE idPatient = $id AND id_hopital = " . htmlentities($_SESSION['user']['idhopital']) . " ";
        }else{
            $condition['where'] = " WHERE id_hopital = " . htmlentities($_SESSION['user']['idhopital']) . " ";
        }
        $condition['order'] = " patient.nom ASC ";
        return $this->get("patient", $condition);
    }
    public function searchPatient($motif="") {        
        $condition['joins'] = [
                'tables' => ['download', "structureaffilier"],
                'tableBase' => ['patient', "patient"],
                'typeJointure' => ['INNER', "LEFT"],
                'keys' => ['id_download', "id"],
                'primaryKeys' => ['id_avatar', "idstructure"]
            ];
        if(isset($motif) && !empty($motif)){
            $condition['where'] = " WHERE (numinterne LIKE '%$motif%' OR idPatient LIKE '%$motif%' OR nom LIKE '%$motif%' OR prenom LIKE '%$motif%' OR postnom LIKE '$motif%%'  OR nu LIKE '$motif%%' OR numinterne LIKE '$motif%%') AND patient.id_hopital = ". htmlentities($_SESSION['user']['idhopital']). " AND patient.statut = 0";
        }else{
              $condition['where'] = " WHERE id_hopital = " . $_SESSION["user"]['idhopital'] . " AND patient.statut = 0 ";
        }
        
        $condition['order'] = " patient.nom ASC ";
        return $this->get("patient", $condition);
    }
    
    public function addAnt($idPatient, $data=[]) {     
        $this->setTable_and_Model('antecedent');
        extract($data);
        $this->valideData($element, "#^[\w\s-]{2,60}$#", "Le champ élément ne doit être vide", "Elément");
        $this->valideData($detail, "#^[\w\s-]{2,3000}$#", "Le champ détail est invalide, il contient les caractères non autorisé, veuillez le corriger", "Détail", true);
        $this->valideData($type, "#1|2|3#", "le type d'antécédent doit appartenir à l'intervalle suivant [Normal, Famillier, Autre]", "Type d'antécédent");
        
        if(count($this->errors)>0){
            return false;
        }else{  
            $flag = $this->getPatient($idPatient);
            if(is_null($flag) || count($flag) == 0){
                $this->errors = "Patient non trouvé";
                return false;
            }
            $datas = new \stdClass();
            $datas->element = $element;
            $datas->detail = $detail;
            $datas->id_patient = $idPatient;          
            $datas->type_antecedent = $type;
            return $this->input($datas, 'antecedent');
        }        
    }
    
    public function getAntecedent($idPatient) {
        $condition['where'] =  " WHERE id_patient = $idPatient";
        return $this->get("antecedent", $condition);
    }
    
    public  function translateInAsciiCode($str) {

        $new = "";
        if (isset($str) && !empty($str)) {
            for ($i = 0; $i < strlen($str); $i++) {
                $new .= ord($str[$i]);
            }
        }
        
        return $new;
    }
    
}
