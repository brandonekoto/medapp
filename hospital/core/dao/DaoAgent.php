<?php
namespace hospital\core\dao;
use \PDO ;

class DaoAgent extends \model\Model{
    public function __construct(array $params = array()) {
        parent::__construct($params);
    }
    public function add($data) {
        extract($data);
        
        $this->valideData(trim($nom), "#^[A-Za-z\s-]{2,30}$#", "Le nom ne doit être vide et doit commencer par une Majuscule suivi des lettres miniscules maximum 30 caractères", "Nom");
        $this->valideData(trim($postnom), "#^[A-Za-z\s-]{2,30}$#", "Le postnom ne doit être vide et doit commencer par une Majuscule suivi des lettres miniscules maximum 30 caractères", "Postnom");
        $this->valideData(trim($prenom), "#^[A-Za-z\s-]{2,30}$#", "Le Prénom ne doit être vide et doit commencer par une Majuscule suivi des lettres miniscules maximum 30 caractères", "Postnom");
        $this->valideData($dateNaiss, "#^[0-9]{4}-[0-9]{2}-[0-9]{2}$#", "La date de naissance ne doit être vide et doit respecter le format (AAAA/MM/JJ) Ex: 2019,10,15", "date de naissance");
        $this->valideData($dateEngagement, "#^[0-9]{4}-[0-9]{2}-[0-9]{2}$#", "La date d'engagement ne doit être vide et doit respecter le format (AAAA/MM/JJ) Ex: 2019,10,15", "Date d'engagement");
        //$this->valideData(isset($datesortie) ? $datesortie : "", "#^[0-9]{4}-(0[1-9]| 1[0-2])-[0-9]{2}$#", "La date de sortie ne doit être vide et doit respecter le format (AAAA/MM/JJ) Ex: 2019,10,15", "Date de sortie", false);
        $this->valideData($adresse, "#^.{1,100}$#", "L'adresse ne doit être vide et doit contenir que les lettres [A-Za-z0-9] ces caractères - _ , / ", "Adresse");
        $this->valideData($lieuNaiss, "#^[\w\s-]{2,90}$#", "Le Lieu de naissance ne doit être vide et doit composé des caractères simples", "date");
        $this->valideData($etatCivil, "#^c|m|d|v$#", "L'Etat civil ne doit être vide et Veuillez sélectionner un parmi ces choix (Celibataire, mariée, divorcé, veuf (ve))", "Etat civil");
        $this->valideData($statut, "#^0|1$#", "Le statut de l'agent ne doit être vide et Veuillez sélectionner un parmi ces choix (Contracté, Non contracté)", "Statut");
        $this->valideData($niveauEtude, "#^doc|lic|grad|dip$#", "Le niveau d'Etude ne doit être vide et Veuillez sélectionner un parmi ces choix (Docteur(Thèse), Licencié (Bac+5), Gradué (e) (Bac+3), Diplomé (e) (Bac))", "Niveau d'étude");
        $this->valideData($sexe, "#^M|F$#", "Le sexe ne doit être vide et Veuillez sélectionner un parmi ces choix (Masculin ou Féminin", "Sexe");
        $this->valideData(trim($fonction), "#^[0-7]$#", "La fonction ne doit être vide et Veuillez sélectionner un parmi ces choix (Infirmier, Médecin , Réceptionniste ,Comptable, Autre)", "Fonction");
        $this->valideData(trim($telephone), "#^\+(\d){1,4}(\d){10}$#", "Le numéro de téléphone doit être vide et doit respecter le format (+CODE CCCCCCCCCC) suivi des chiffres ", "Téléphone");
        //$this->valideData($email, "#^[\w-._]+@[\w.-]+\.[a-z]{2,}$#i", "L'Adresse email doit être vide et doit respecter le format ([a-z] host.domaine) Exemple  : exemple@exemple.com", "Adresse email",false);
        $this->valideData($email, "# ^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$#i", "L'Adresse email doit être vide et doit respecter le format ([a-z] host.domaine) Exemple  : exemple@exemple.com", "Adresse email",false);
        
       
        $this->valideData(isset($nbrenfant) ? trim($nbreEnfant) : 0, "#\d+$#i", "Le nombre d'enfant email doit être vide et doit respecter le format ([a-z] host.domaine) Exemple  : exemple@exemple.com", "Nombre d'enfant", false);
         $this->valideData($type_agent, "#^0|1$#", "Le type d'agent ne doit être vide et Veuillez sélectionner un parmi ces choix (Interne ou externe)", "type");
        if(count($this->errors)>0){
            return false;
        }else{   
            $data =  new \stdClass();
            $data->nom = strtoupper($nom);
            $data->postnom = strtoupper($postnom);
            $data->prenom = strtoupper($prenom);
            $data->dateNaiss = $dateNaiss;
            $data->adresse = $adresse;
            $data->lieuNaiss = strtoupper($lieuNaiss);
            $data->etatCivil = $etatCivil;
            $data->nbreEnfant = $nbreEnfant;
            $data->nivEtude = $niveauEtude;
            $data->dateEng = $dateEngagement;
            $data->id_hopital = $id_hopital;
            //$data->id_province = $id_province;
            //$data->dateSortir = $datesortie;
            $data->email = $email;
            $data->fonction = $fonction;
            $data->type_agent = $type_agent;
            $data->genre = $sexe;
            $data->contact = $telephone;            
            if(isset($agentPhoto) && !empty($agentPhoto)){
                $data->id_avatar = $agentPhoto;
            }
            return $this->input($data, "agent");            
           
        }
    }
    public function modifier($data) {
        extract($data);
        $this->valideData(trim($nom), "#^[A-Za-z]{2,30}$#", "Le nom ne doit être vide et doit commencer par une Majuscule suivi des lettres miniscules maximum 30 caractères", "Nom");
        $this->valideData(trim($postnom), "#^[A-Za-z]{2,30}$#", "Le postnom ne doit être vide et doit commencer par une Majuscule suivi des lettres miniscules maximum 30 caractères", "Postnom");
        $this->valideData(trim($prenom), "#^[A-Za-z]{2,30}$#", "Le Prénom ne doit être vide et doit commencer par une Majuscule suivi des lettres miniscules maximum 30 caractères", "Prénom");
        $this->valideData($dateNaiss, "#^[0-9]{4}-(0[1-9]| 1[0-2])-[0-9]{2}$#", "La date de naissance ne doit être vide et doit respecter le format (AAAA/MM/JJ) Ex: 2019,10,15", "date");
        //$this->valideData($dateEngagement, "#^[0-9]{4}-(0[1-9]| 1[0-2])-[0-9]{2}$#", "La date d'engagement ne doit être vide et doit respecter le format (AAAA/MM/JJ) Ex: 2019,10,15", "Date d'engagement");
        //$this->valideData($datesortie, "#^[0-9]{4}-(0[1-9]| 1[0-2])-[0-9]{2}$#", "La date de sortie ne doit être vide et doit respecter le format (AAAA/MM/JJ) Ex: 2019,10,15", "Date de sortie");
        $this->valideData(trim($adresse), "#(.{1,100})$#", "L'adresse ne doit être vide et doit contenir que les lettres [A-Za-z0-9] ces caractères - _ , / ", "Adresse");
        $this->valideData($lieuNaiss, "#^([A-Za-z]){2,90}$#", "Le Lieu de naissance ne doit être vide et doit composé des caractères simples", "date");
        $this->valideData($etatCivil, "#^c|m|d|v$#", "L'Etat civil ne doit être vide et Veuillez sélectionner un parmi ces choix (Celibataire, mariée, divorcé, veuf (ve))", "Etat civil");
        //$this->valideData($statut, "#^0|1$#", "Le statut de l'agent ne doit être vide et Veuillez sélectionner un parmi ces choix (Contracté, Non contracté)", "Statut");
        $this->valideData($niveauEtude, "#^doc|lic|grad|dip$#", "Le niveau d'Etude ne doit être vide et Veuillez sélectionner un parmi ces choix (Docteur(Thèse), Licencié (Bac+5), Gradué (e) (Bac+3), Diplomé (e) (Bac))", "Niveau d'étude");
        $this->valideData($sexe, "#^M|F$#", "Le sexe ne doit être vide et Veuillez sélectionner un parmi ces choix (Masculin ou Féminin", "Sexe");
        //$this->valideData($fonction, "#^[0-4]$#", "La fonction ne doit être vide et Veuillez sélectionner un parmi ces choix (Infirmier, Médecin , Réceptionniste ,Comptable, Autre)", "Fonction");
        $this->valideData(trim($telephone), "#^\+(\d){1,4}(\d){10}$#", "Le numéro de téléphone doit être vide et doit respecter le format (+CODE CCCCCCCCCC) suivi des chiffres ", "Téléphone");
        $this->valideData(trim($email), "#^[\w-._]+@[\w.-]+\.[a-z]{2,}$#i", "L'Adresse email doit être vide et doit respecter le format ([a-z] host.domaine) Exemple  : exemple@exemple.com", "Adresse email");
        //$this->valideData($nbreEnfant, "#\d+$#i", "Le nombre email doit être vide et doit respecter le format ([a-z] host.domaine) Exemple  : exemple@exemple.com", "Nombre d'enfant email", false);
        $agent = $this->getById($idagent);
        if(count($agent) < 1){
            array_push($this->errors, "Agent non trouvée");
        }        
        if(count($this->errors)>0){
            return false;
        }else{            
            $data =  new \stdClass();
            $data->nom = strtoupper(trim($nom));
            $data->postnom = strtoupper(trim($postnom));
            $data->prenom = strtoupper(trim($prenom));
            $data->dateNaiss = $dateNaiss;
            $data->adresse = trim($adresse);
            $data->lieuNaiss = $lieuNaiss;
            $data->etatCivil = $etatCivil;
            $data->nbreEnfant = $nbreEnfant;
            $data->nivEtude = $niveauEtude;
            $data->dateEng = $dateEngagement;
            $data->dateSortir = $datesortie;
            $data->email = $email;
            $data->fonction = $fonction;
            $data->genre = $sexe;
            $data->contact = trim($telephone);
            if(isset($agentPhoto) && !empty($agentPhoto)){
                $data->id_avatar = $agentPhoto;
            }
            $condition['where'] = " WHERE agent.id = $idagent";
            $this->update($condition,$data, "agent");      
            return true;
        }
    }
    
    
    public function getAgents() {
        $respond = null;
        try {            
            $ps = $this->cnx->query("select * from agent LEFT JOIN fonction ON agent.fonction = fonction.idFonction");
            $respond = ($ps->fetchAll(PDO::FETCH_OBJ));
        } catch (Exception $th) {
            var_dump($en);
        }
        return $respond;
    }
    public function getAgent($id) {
        $respond = null;
        try {            
            $ps = $this->cnx->query("select * from agent where idAgent=$id");
            $daoFonction = new DaoFonction();
            while ($rs = $ps->fetch()) {
                $respond = json_encode(
                        array("idAgent" => $rs["idAgent"],
                            "urlPhoto" => $rs["urlPhoto"],
                            "nom" => $rs["nom"],
                            "postnom" => $rs["postnom"],
                            "prenom" => $rs["prenom"],
                            "genre" => $rs["genre"],
                            "dateNaiss" => $rs["dateNaiss"],
                            "lieuNaiss" => $rs["lieuNaiss"],
                            "fonction" => $daoFonction->getFonctionName($rs["idFonction"]),
                            "etatCivil" => $rs["etatCivil"],
                            "nbreEnfant" => $rs["nbreEnfant"],
                            "adresse" => $rs["adresse"],
                            "telDomicile" => $rs["telDomicile"],
                            "telBureau" => $rs["telBureau"],
                            "email" => $rs["email"],
                            "statut" => $rs["statut"],
                            "nivEtudes" => $rs["nivEtudes"],
                            "dateEng" => $rs["dateEng"],
                            "dateSortir" => $rs["dateSortir"]
                ));
            }
        } catch (Exception $th) {
            
        }

        return $respond;
    }

    public function findAgent($str) {

        $respond = null;
        try {
            $ps = $this->cnx->query("select * from agent where nom like('" . $str . "%')");
            $respond = json_encode($ps->fetchAll(PDO::FETCH_OBJ));
        } catch (Exception $th) {
            
        }

        return $respond;
    }

    public function getPersonAffiliers($idAgent) {
        $respond = null;
        try {
            $ps = $thi->prepare("select * from personneaffilierinterne where idAgent=?");
            $ps->execute(array($idAgent));
            $respond = json_encode($ps->fetchAll(PDO::FETCH_OBJ));
        } catch (Exception $th) {
            
        }
        return $respond;
    }
    
    public function getById($id) {
        if(isset($id) && !empty($id)){ 
            $condition['fields'] =  "`agent`.*, `user`.`id` AS `iduser`, `fonction`.*, `download`.*, `agent`.`id` AS `idagent`, "
                    . "`user`.`username`, `user`.`pwd`, `user`.`category`, `user`.`sous_category`, `user`.`allowed`, `user`.`code`";
            $condition['where'] = " WHERE agent.id=$id ";
            $condition['joins'] =  [
                'tables' => ['user', 'fonction', 'download'],
                'tableBase' => ['agent', 'agent', 'agent'],
                'typeJointure' => ['LEFT', 'INNER', 'LEFT'],
                'keys' => ['id', 'idFonction', 'id_download'],
                'primaryKeys' => ['id_user', 'fonction','id_avatar']
            ];
            return $this->get("agent", $condition);
        }else{
            return false;
        }
    }    
    
    public function getFonction($id="") {
        if(isset($id) && !empty($id)){
            $condition['where'] =  " WHERE idFonction ='$id'";
        }else{
            $condition = [];
        }
        return $this->get('fonction', $condition);
    }
    public function del($id) {
        if(isset($id) && !empty($id)){
            $condition['where'] = " WHERE agent.id=$id ";
            return $this->delete("id", $id, "agent");
        }
        return false;
    }
    
    public function updateUser($id, $value) {
        $sql = "UPDATE agent SET id_user = :id WHERE id = ".htmlentities($id, ENT_IGNORE); 
        try{
            
            $stm = $this->cnx->prepare($sql);
            var_dump( $stm->execute([':id'=>$value]));
            die();
        } catch (\Exception $ex) {
            $ex->getTraceAsString();
            throw new MDEException($ex);
        }
        
    }
}
