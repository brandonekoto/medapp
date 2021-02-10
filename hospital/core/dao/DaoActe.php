<?php

namespace hospital\core\dao;

use model\Model;
use model\DaoInterface;

class DaoActe extends Model implements DaoInterface {

    public $DAOExtra;

    public function __construct($options = array()) {
        parent::__construct($options);
    }

    public function setActe(Acte $acte) {
        $respond = false;
        try {
            $ps = $this->cnx->prepare("insert into acte(designation,categorie,prix) values(?,?,?)");
            $respond = $ps->execute(array($acte->getDesignation(), $acte->getCategorie(), $acte->getPrix()));
        } catch (Exception $ex) {
            $respond = false;
        }
        return $respond;
    }

    public function InstanceExtra() {
        return $this->DAOExtra = new Extra();
    }

    public function getListeExtrat() {

        return $this->InstanceExtra()->getListExtra();
    }

    public function getActes($data = []) {
        $condition['fields'] = " acte.id, category_acte.id as id_cat, category_acte.lib as category, acte.lib as acte, acte.prix, acte.prix_prive, acte.prix_conventionne, acte.prix_affilier  ";
        $condition['order'] = " category_acte.id ";
        $condition['joins'] = [
            'tables' => ['category_acte'],
            'tableBase' => ['acte'],
            'typeJointure' => ['INNER'],
            'keys' => ['id'],
            'primaryKeys' => ['id_category']
        ];

        $condition['where'] = " WHERE acte.id_hopital_ac = " . htmlentities($_SESSION['user']['idhopital']) . " ";
        return $this->get("acte", $condition);
    }

    public function getActeNursing($id = "") {
        $condition['order'] = " lib ASC";
        if (isset($id) && !empty($id)) {
            $condition['where'] = " WHERE id = '$id' AND id_hopital =  " . $_SESSION['user']['idhopital'] . " ";
        } else {
            $condition['where'] = " WHERE id_hopital =  " . $_SESSION['user']['idhopital'] . " ";
        }
        return $this->get("acte_infirmier", $condition);
    }

    public function getActePrices($motif = "") {
        $condition['fields'] = " acte.id, category_acte.id as id_cat, category_acte.lib as category, acte.lib as acte, acte.prix, acte.prix_prive, acte.prix_conventionne, acte.prix_affilier ";
        $condition['order'] = " category_acte.id";
        $condition['joins'] = [
            'tables' => ['category_acte'],
            'tableBase' => ['acte'],
            'typeJointure' => ['INNER'],
            'keys' => ['id'],
            'primaryKeys' => ['id_category']
        ];
        if (isset($motif) && !empty($motif)) {
            $condition['where'] = " WHERE ((acte.id LIKE '%$motif%' OR acte.lib LIKE '%$motif%' OR category_acte.id LIKE '%$motif%')) AND acte.id_hopital_ac = " . htmlentities($_SESSION['user']['idhopital']) . " ";
        } else {
            $condition['where'] = " WHERE acte.id_hopital_ac = " . htmlentities($_SESSION['user']['idhopital']) . " ";
        }
        return $this->get("acte", $condition);
    }

    public function getActeOfStructures($motif = "") {
        $condition['fields'] = " acte.id, category_acte.id as id_cat, category_acte.lib as category, acte.lib as acte, acte.prix, acte.prix_prive, acte.prix_conventionne, acte.prix_affilier ";
        $condition['order'] = " category_acte.id";
        $condition['joins'] = [
            'tables' => ['category_acte', "structure_actes"],
            'tableBase' => ['acte', "acte"],
            'typeJointure' => ['INNER', 'INNER'],
            'keys' => ['id', 'acte_id'],
            'primaryKeys' => ['id_category', 'id']
        ];
        if (isset($motif) && !empty($motif)) {
            $condition['where'] = " WHERE structure_id = '" . $motif . "' AND acte.id_hopital_ac = " . htmlentities($_SESSION['user']['idhopital']) . " ";
            return $this->get("acte", $condition);
        } else {
            return null;
            //$condition['where'] = " WHERE acte.id_hopital_ac = " . htmlentities($_SESSION['user']['idhopital']) . " ";
        }
    }

    public function findActes($str) {
        try {
            $ps = $this->cnx->query("select * from acte where designation like('$str%') AND acte.id_hopital_ac = " . htmlentities($_SESSION['user']['idhopital']));
            $respond = json_encode($ps->fetchAll(PDO::FETCH_ASSOC));
        } catch (Exception $th) {
            
        }
        return $respond;
    }

    public function add($data = array()) {
        extract($data);
        $condition['where'] = " Where id = '$acte_medical'";
        $act = $this->get("acte", $condition);
        unset($condition);
        $condition['where'] = " Where idPatient ='$patient'";
        $p = $this->get("patient", $condition);
        if (count($p) > 0 && count($act) > 0) {
            $values = new \stdClass();
            $values->id_acte = $acte_medical;
            $values->id_hopital = $_SESSION['user']['idhopital'];
            $values->id_province = $_SESSION['user']['province'];
            $values->id_patient = $patient;
            $values->id_agent = $_SESSION['user']['agent'];
            if (isset($_SESSION['user']['idgroupe']) && !empty($_SESSION['user']['idgroupe']) && $_SESSION['user']['idgroupe'] != 0) {
                $values->id_group = $_SESSION['user']["idgroupe"];
            }
            $values->etape = 1;
            return $this->input($values, "acte_pose");
        } else {
            $this->errors[] = "Veuillez sélectionner le patient et l'acte à conjuguer. Si l'erreur persiste c'est être une tentative de piratage. Please veuillez contacter MDE SERVICES IT";
            return false;
        }
    }

    public function del($id) {
        $condition['where'] = " Where id = $id";
        $act = $this->get("acte", $condition);
        if (count($act) > 0) {
            return $this->delete("id", $id, "acte");
        } else {
            return false;
        }
    }

    public function delActe($id) {
        $condition['where'] = " WHERE id = $id";
        $act = $this->get("acte_pose", $condition);
        if (count($act) > 0) {
            return $this->delete("id", $id, "acte_pose");
        } else {
            return false;
        }
    }

    public function edit($id, $data = array()) {
        
    }

    public function findActeInfo($conditionadditive = []) {
        $condition['fields'] = "`acte_pose`.`id`, `acte_pose`.`id_acte`, `acte_pose`.`id_agent`, `acte_pose`.`id_patient`, `acte_pose`.`etape`, "
                . "`acte_pose`.`date`, `acte_pose`.`end`, `acte`.`lib` AS `acte_pose`, `acte`.`prix_prive`, `acte`.`prix_conventionne`, "
                . "`acte`.`prix_affilier`, `acte`.`prix`, `category_acte`.`lib` AS `category`, `agent`.`nom` AS `nomagent`,"
                . " `agent`.`prenom` AS `prenomagent`, `agent`.`fonction` AS `idfonction`, `fonction`.`libelle` AS `fonctionagent`, "
                . "`agent`.`id` AS `idagent`, `patient`.`idPatient`, `patient`.`nom` AS `nompatient`, `patient`.`prenom` AS `prenompatient`,"
                . " `patient`.`sexe` AS `sexepatient`, `patient`.`age` AS `agepatient`, `download`.`filename`, `download`.`type`";
        $condition['joins'] = [
            'tables' => ['acte', 'category_acte', 'agent', 'fonction', 'patient', 'download'],
            'tableBase' => ['acte_pose', 'acte', 'acte_pose', 'agent', 'acte_pose', 'patient'],
            'typeJointure' => ['INNER', 'INNER', 'INNER', 'LEFT', 'INNER', 'LEFT'],
            'keys' => ['id', 'id', 'id', 'idFonction', 'idPatient', 'id_download'],
            'primaryKeys' => ['id_acte', 'id_category', 'id_agent', 'fonction', 'id_patient', 'id_avatar']
        ];
        if (count($conditionadditive) > 0) {
            $condition = array_merge($condition, $conditionadditive);
        }
        return $this->paginate("acte_pose", $condition, 100);
    }

    public function actetoday() {
        $condition['fields'] = "`acte_pose`.`id`, `acte_pose`.`id_acte`, `acte_pose`.`id_agent`, `acte_pose`.`id_patient`, `acte_pose`.`etape`, "
                . "`acte_pose`.`date`, `acte_pose`.`end`, `acte`.`lib` AS `acte_pose`, `acte`.`prix_prive`, `acte`.`prix_conventionne`, "
                . "`acte`.`prix_affilier`, `acte`.`prix`, `category_acte`.`lib` AS `category`, `agent`.`nom` AS `nomagent`,"
                . " `agent`.`prenom` AS `prenomagent`, `agent`.`fonction` AS `idfonction`, `fonction`.`libelle` AS `fonctionagent`, "
                . "`agent`.`id` AS `idagent`, `patient`.`idPatient`, `patient`.`nom` AS `nompatient`, `patient`.`prenom` AS `prenompatient`,"
                . " `patient`.`sexe` AS `sexepatient`, `patient`.`age` AS `agepatient`, `download`.`filename`, `download`.`type`";
        $condition['joins'] = [
            'tables' => ['acte', 'category_acte', 'agent', 'fonction', 'patient', 'download'],
            'tableBase' => ['acte_pose', 'acte', 'acte_pose', 'agent', 'acte_pose', 'patient'],
            'typeJointure' => ['INNER', 'INNER', 'INNER', 'LEFT', 'INNER', 'LEFT'],
            'keys' => ['id', 'id', 'id', 'idFonction', 'idPatient', 'id_download'],
            'primaryKeys' => ['id_acte', 'id_category', 'id_agent', 'fonction', 'id_patient', 'id_avatar']
        ];
        $condition['where'] = " WHERE acte_pose.date >= '" . date("Y-m-d") . "'  AND acte_pose.id_hopital = " . htmlentities($_SESSION['user']['idhopital']) . " ";
        $condition['order'] = " acte_pose.date DESC ";
        return $this->get("acte_pose", $condition);
    }

    public function searchActe($motif = "") {
        $condition['fields'] = "`acte_pose`.`id`, `acte_pose`.`id_acte`, `acte_pose`.`id_agent`, `acte_pose`.`id_patient`, `acte_pose`.`etape`, "
                . "`acte_pose`.`date`, `acte_pose`.`end`, `acte`.`lib` AS `acte_pose`, `acte`.`prix_prive`, `acte`.`prix_conventionne`, "
                . "`acte`.`prix_affilier`, `acte`.`prix`, `category_acte`.`lib` AS `category`, `agent`.`nom` AS `nomagent`,"
                . " `agent`.`prenom` AS `prenomagent`, `agent`.`fonction` AS `idfonction`, `fonction`.`libelle` AS `fonctionagent`, "
                . "`agent`.`id` AS `idagent`, `patient`.`idPatient`, `patient`.`nom` AS `nompatient`, `patient`.`prenom` AS `prenompatient`,"
                . " `patient`.`sexe` AS `sexepatient`, `patient`.`age` AS `agepatient`, `download`.`filename`, `download`.`type`, patient.nu, patient.numinterne";
        $condition['joins'] = [
            'tables' => ['acte', 'category_acte', 'agent', 'fonction', 'patient', 'download'],
            'tableBase' => ['acte_pose', 'acte', 'acte_pose', 'agent', 'acte_pose', 'patient'],
            'typeJointure' => ['INNER', 'INNER', 'INNER', 'LEFT', 'INNER', 'LEFT'],
            'keys' => ['id', 'id', 'id', 'idFonction', 'idPatient', 'id_download'],
            'primaryKeys' => ['id_acte', 'id_category', 'id_agent', 'fonction', 'id_patient', 'id_avatar']
        ];
        //$condition = array_merge($condition, $conditionadditive);
        $condition['where'] = " WHERE (patient.nom LIKE '%$motif%' OR  patient.prenom LIKE '%$motif%' OR patient.postnom LIKE '%$motif%') OR acte_pose.id LIKE '$motif' AND acte_pose.id_hopital  = " . htmlentities($_SESSION['user']['idhopital']) . " ";
        return $this->get("acte_pose", $condition);
    }

    public function costumersearchActe($conditionadditive = []) {
        $condition['fields'] = "`acte_pose`.`id`, `acte_pose`.`id_acte`, `acte_pose`.`id_agent`, `acte_pose`.`id_patient`, `acte_pose`.`etape`, "
                . "`acte_pose`.`date`, `acte_pose`.`end`, `acte`.`lib` AS `acte_pose`, `acte`.`prix_prive`, `acte`.`prix_conventionne`, "
                . "`acte`.`prix_affilier`, `acte`.`prix`, `category_acte`.`lib` AS `category`, `agent`.`nom` AS `nomagent`,"
                . " `agent`.`prenom` AS `prenomagent`, `agent`.`fonction` AS `idfonction`, `fonction`.`libelle` AS `fonctionagent`, "
                . "`agent`.`id` AS `idagent`, `patient`.`idPatient`, `patient`.`nom` AS `nompatient`, `patient`.`prenom` AS `prenompatient`,"
                . " patient.postnom as postnompatient, `patient`.`sexe` AS `sexepatient`, `patient`.`age` AS `agepatient`, `download`.`filename`, `download`.`type`, acte_pose.id_hopital, patient.nu, patient.numinterne";
        $condition['joins'] = [
            'tables' => ['acte', 'category_acte', 'agent', 'fonction', 'patient', 'download'],
            'tableBase' => ['acte_pose', 'acte', 'acte_pose', 'agent', 'acte_pose', 'patient'],
            'typeJointure' => ['INNER', 'INNER', 'INNER', 'LEFT', 'INNER', 'LEFT'],
            'keys' => ['id', 'id', 'id', 'idFonction', 'idPatient', 'id_download'],
            'primaryKeys' => ['id_acte', 'id_category', 'id_agent', 'fonction', 'id_patient', 'id_avatar']
        ];
        if (is_array($conditionadditive) && count($conditionadditive) > 0) {
            $condition = array_merge($condition, $conditionadditive);
        }
        $condition['order'] = " acte_pose.date DESC ";
        return $this->paginate("acte_pose", $condition);
    }

    public function findConsultationInfo($conditionadditive = []) {
        $condition['fields'] = "`consultation`.`id` AS `idConsultation`,  `consultation`.`anamnese`, "
                . "`consultation`.`taille`, `consultation`.`poids`, `consultation`.`temp`, `consultation`.`tension`, `consultation`.`obs`,"
                . " consultation.date as dateconsultation, `acte_pose`.`id` AS `idactepose`, `acte_pose`.`id_acte`, `acte_pose`.`id_agent` AS `idagent`,"
                . " `acte_pose`.`id_patient` AS `idpatient`, `acte_pose`.`etape`, `acte`.`lib` AS `acte_pose`, pouls, fr, spo,"
                . "`acte`.`id_category` AS `idcategoryacte`, `category_acte`.`lib` AS `category`, `acte_pose`.`date`, "
                . "`agent`.`id`, `agent`.`nom` AS `nomagent`, `agent`.`prenom` AS `prenomagent`, `agent`.`fonction` AS `idfonction`,"
                . " `fonction`.`libelle` AS `fonction`, `patient`.`idPatient`, `patient`.`nom` AS `nompatient`, "
                . "`patient`.`prenom` AS `prenompatient`, `patient`.`sexe`, `patient`.`age`, `patient`.`etatcivil`, "
                . "`download`.`filename`, `download`.`type`";
        $condition['joins'] = [
            'tables' => ['acte_pose', 'acte', 'category_acte', 'agent', 'fonction', 'patient', 'download'],
            'tableBase' => ['consultation', 'acte_pose', 'acte', 'acte_pose', 'agent', 'acte_pose', 'patient'],
            'typeJointure' => ['INNER', 'INNER', 'INNER', 'INNER', 'INNER', 'INNER', 'LEFT'],
            'keys' => ['id', 'id', 'id', 'id', 'idFonction', 'idPatient', 'id_download'],
            'primaryKeys' => ['id_acte', 'id_acte', 'id_category', 'id_agent', 'fonction', 'id_patient', 'id_avatar']
        ];
        $condition = array_merge($condition, $conditionadditive);
        return $this->get("consultation", $condition);
    }

    public function getConsultations($condition = "") {
        /* $sql = " SELECT `consultation`.`id` AS `idConsultation`, `consultation`.`anamnese`, `consultation`.`taille`, `consultation`.`poids`, 
          `consultation`.`temp`, `consultation`.`tension`, `consultation`.`obs`, consultation.date as dateconsultation, fr, spo, pouls,
          `acte_pose`.`id` AS `idactepose`, `acte_pose`.`id_acte`, `acte_pose`.`id_agent` AS `idagent`, `acte_pose`.`id_patient` AS `idpatient`,
          `acte_pose`.`etape`, `acte`.`lib` AS `acte_pose`, `acte`.`id_category` AS `idcategoryacte`, `category_acte`.`lib` AS `category`,
          `acte_pose`.`date`, `agent`.`id`, `agent`.`nom` AS `nomagent`, `agent`.`prenom` AS `prenomagent`, `agent`.`fonction` AS `idfonction`,
          `fonction`.`libelle` AS `fonction`, `patient`.`idPatient`, `patient`.`nom` AS `nompatient`, `patient`.`prenom` AS `prenompatient`,
          `patient`.`sexe`, `patient`.`age`, `patient`.`etatcivil`, `download`.`filename`, `download`.`type`, consult.prix AS prixConsultation
          FROM consultation
          INNER JOIN acte_pose ON acte_pose.id = consultation.id_acte
          INNER JOIN acte ON acte.id = acte_pose.id_acte
          INNER JOIN category_acte ON category_acte.id = acte.id_category
          INNER JOIN agent ON agent.id = acte_pose.id_agent
          INNER JOIN fonction ON fonction.idFonction = agent.fonction
          INNER JOIN patient ON patient.idPatient = acte_pose.id_patient
          LEFT JOIN download ON download.id_download = patient.id_avatar
          LEFT JOIN (SELECT * FROM acte) AS consult ON consult.id_category = 1
          "; */
        $sql = "SELECT `consultation`.`id` AS `idConsultation`, `consultation`.`anamnese`, `consultation`.`taille`, `consultation`.`poids`, "
                . "`consultation`.`temp`, `consultation`.`tension`, `consultation`.`obs`, consultation.date as dateconsultation, fr, spo, pouls, "
                . "`acte_pose`.`id` AS `idactepose`, `acte_pose`.`id_acte`, `acte_pose`.`id_agent` AS `idagent`, `acte_pose`.`id_patient` AS `idpatient`,"
                . " `acte_pose`.`etape`, `acte`.`lib` AS `acte_pose`, `acte`.`id_category` AS `idcategoryacte`, `category_acte`.`lib` AS `category`, "
                . "`acte_pose`.`date`, `agent`.`id`, `agent`.`nom` AS `nomagent`, `agent`.`prenom` AS `prenomagent`, `agent`.`fonction` AS `idfonction`,"
                . " `fonction`.`libelle` AS `fonction`, `patient`.`idPatient`, `patient`.`nom` AS `nompatient`, `patient`.`prenom` AS `prenompatient`, "
                . "`patient`.`sexe`, `patient`.`age`, `patient`.`etatcivil`, `download`.`filename`, `download`.`type`, acte.prix AS prixConsultation "
                . "FROM consultation "
                . "INNER JOIN acte_pose ON acte_pose.id = consultation.id_acte "
                . "INNER JOIN acte ON acte.id = acte_pose.id_acte "
                . "INNER JOIN category_acte ON category_acte.id = acte.id_category "
                . "INNER JOIN agent ON agent.id = acte_pose.id_agent "
                . "INNER JOIN fonction ON fonction.idFonction = agent.fonction "
                . "INNER JOIN patient ON patient.idPatient = acte_pose.id_patient "
                . "LEFT JOIN download ON download.id_download = patient.id_avatar "
        ;

        if (isset($condition) && !empty($condition)) {
            $sql .= " " . $condition . " ";
        }
        $sql .= " HAVING acte.id_category = 1 ORDER BY consultation.date DESC";
        $stm = $this->cnx->query($sql);
        return $stm->fetchAll(\PDO::FETCH_OBJ);
    }

    public function searchConsultation($motif) {
        $condition['fields'] = "`consultation`.`id` AS `idConsultation`, `consultation`.`id_patient`, `consultation`.`anamnese`, "
                . "`consultation`.`taille`, `consultation`.`poids`, `consultation`.`temp`, `consultation`.`tension`, `consultation`.`obs`,"
                . " `acte_pose`.`id` AS `idactepose`, `acte_pose`.`id_acte`, `acte_pose`.`id_agent` AS `idagent`,"
                . " `acte_pose`.`id_patient` AS `idpatient`, `acte_pose`.`etape`, `acte`.`lib` AS `acte_pose`, "
                . "`acte`.`id_category` AS `idcategoryacte`, `category_acte`.`lib` AS `category`, `acte_pose`.`date`, "
                . "`agent`.`id`, `agent`.`nom` AS `nomagent`, `agent`.`prenom` AS `prenomagent`, `agent`.`fonction` AS `idfonction`,"
                . " `fonction`.`libelle` AS `fonction`, `patient`.`idPatient`, `patient`.`nom` AS `nompatient`, "
                . "`patient`.`prenom` AS `prenompatient`, `patient`.`sexe`, `patient`.`age`, `patient`.`etatcivil`, "
                . "`download`.`filename`, `download`.`type`";
        $condition['joins'] = [
            'tables' => ['acte_pose', 'acte', 'category_acte', 'agent', 'fonction', 'patient', 'download'],
            'tableBase' => ['consultation', 'acte_pose', 'acte', 'acte_pose', 'agent', 'acte_pose', 'patient'],
            'typeJointure' => ['INNER', 'INNER', 'INNER', 'INNER', 'INNER', 'INNER', 'LEFT'],
            'keys' => ['id', 'id', 'id', 'id', 'idFonction', 'idPatient', 'id_download'],
            'primaryKeys' => ['id_acte', 'id_acte', 'id_category', 'id_agent', 'fonction', 'id_patient', 'id_avatar']
        ];
        $condition['where'] = " WHERE patient.nom LIKE '%$motif%' XOR  patient.prenom LIKE '%$motif%' XOR patient.postnom LIKE '%$motif%'";
        return $this->get("consultation", $condition);
    }

    public function getDiagnostics($id = "") {
        $condition['fields'] = "`diagnostic`.`id` AS `id_diagnostic`, diagnostic.date as datediagnostic,`diagnostic`.`obs_diagnostic`, `diagnostic`.`id_agent` AS `agentdiagnostic`,"
                . " `acte_pose`.`id` AS `idactepose`, `acte_pose`.`id_acte`, `acte_pose`.`id_agent` AS `idagent`,"
                . " `acte_pose`.`id_patient` AS `idpatient`, `acte_pose`.`etape`, `acte`.`lib` AS `acte_pose`, "
                . "`acte`.`id_category` AS `idcategoryacte`, `category_acte`.`lib` AS `category`, `acte_pose`.`date`, "
                . "`agent`.`id`, `agent`.`nom` AS `nomagent`, `agent`.`prenom` AS `prenomagent`, `agent`.`fonction` AS `idfonction`,"
                . " `fonction`.`libelle` AS `fonction`, `patient`.`idPatient`, `patient`.`nom` AS `nompatient`, "
                . "`patient`.`prenom` AS `prenompatient`, patient.postnom as postnompatient,`patient`.`sexe`, `patient`.`age`, `patient`.`etatcivil`, "
                . "`download`.`filename`, `download`.`type`";
        $condition['joins'] = [
            'tables' => ['acte_pose', 'acte', 'category_acte', 'agent', 'fonction', 'patient', 'download'],
            'tableBase' => ['diagnostic', 'acte_pose', 'acte', 'acte_pose', 'agent', 'acte_pose', 'patient'],
            'typeJointure' => ['INNER', 'INNER', 'INNER', 'INNER', 'INNER', 'INNER', 'LEFT'],
            'keys' => ['id', 'id', 'id', 'id', 'idFonction', 'idPatient', 'id_download'],
            'primaryKeys' => ['id_acte', 'id_acte', 'id_category', 'id_agent', 'fonction', 'id_patient', 'id_avatar']
        ];
        if (isset($id) && !empty($id)) {
            $condition['where'] = " WHERE diagnostic.id ='$id'";
            return $this->get("diagnostic", $condition);
        }
        return $this->paginate("diagnostic", $condition, 2);
    }

    public function getNursing($id = "") {
        $condition['fields'] = "traitement_administre.id as idtraitement,`traitement_administre`.`id_acte_pose` AS `id_traitement`, `traitement_administre`.`id_acte_pose`, "
                . "`traitement_administre`.`id_acte_infirmier_fk`, `traitement_administre`.`observation` AS `obsnursing`, "
                . "`traitement_administre`.`id_infirmier`, `traitement_administre`.`datenursing`, `agent`.`nom`, `agent`.`postnom`, "
                . "`agent`.`prenom`, `agent`.`fonction`, `acte_pose`.*, `acte_infirmier`.`lib` AS `nursingpose`, `acte_infirmier`.`prix` as prixsoin";

        $condition['joins'] = [
            'tables' => ['acte_pose', 'acte_infirmier', 'agent'],
            'tableBase' => ['traitement_administre', 'traitement_administre', 'traitement_administre'],
            'typeJointure' => ['INNER', 'INNER', 'INNER'],
            'keys' => ['id', 'id_acte_infirmier', 'id'],
            'primaryKeys' => ['id_acte_pose', 'id_acte_infirmier_fk', 'id_infirmier']
        ];
        if (isset($id) && !empty($id)) {
            $condition['where'] = " WHERE acte_pose.id ='$id'";
        }
        return $this->get("traitement_administre", $condition);
    }

    public function searchDiagnostics($motif = "") {
        $condition['fields'] = "`diagnostic`.`id` AS `id_diagnostic`, diagnostic.date as datediagnostic,`diagnostic`.`obs_diagnostic`, `diagnostic`.`id_agent` AS `agentdiagnostic`,"
                . " `acte_pose`.`id` AS `idactepose`, `acte_pose`.`id_acte`, `acte_pose`.`id_agent` AS `idagent`,"
                . " `acte_pose`.`id_patient` AS `idpatient`, `acte_pose`.`etape`, `acte`.`lib` AS `acte_pose`, "
                . "`acte`.`id_category` AS `idcategoryacte`, `category_acte`.`lib` AS `category`, `acte_pose`.`date`, "
                . "`agent`.`id`, `agent`.`nom` AS `nomagent`, `agent`.`prenom` AS `prenomagent`, `agent`.`fonction` AS `idfonction`,"
                . " `fonction`.`libelle` AS `fonction`, `patient`.`idPatient`, `patient`.`nom` AS `nompatient`, "
                . "`patient`.`prenom` AS `prenompatient`, patient.postnom as postnompatient,`patient`.`sexe`, `patient`.`age`, `patient`.`etatcivil`, "
                . "`download`.`filename`, `download`.`type`";

        $condition['joins'] = [
            'tables' => ['acte_pose', 'acte', 'category_acte', 'agent', 'fonction', 'patient', 'download'],
            'tableBase' => ['diagnostic', 'acte_pose', 'acte', 'acte_pose', 'agent', 'acte_pose', 'patient'],
            'typeJointure' => ['INNER', 'INNER', 'INNER', 'INNER', 'INNER', 'INNER', 'LEFT'],
            'keys' => ['id', 'id', 'id', 'id', 'idFonction', 'idPatient', 'id_download'],
            'primaryKeys' => ['id_acte', 'id_acte', 'id_category', 'id_agent', 'fonction', 'id_patient', 'id_avatar']
        ];
        if (isset($motif) && !empty($motif)) {
            $condition['where'] = " WHERE diagnostic.id LIKE '%$motif%' OR acte_pose.id LIKE '%$motif%' OR patient.nom LIKE '%$motif%' OR patient.prenom LIKE '%$motif%' OR patient.postnom LIKE '%$motif%'";
        }
        $condition['order'] = " diagnostic.date DESC , acte_pose.date DESC";
        return $this->get("diagnostic", $condition);
    }

    public function getDiagnosticsByDate($date = "") {
        $condition['fields'] = "`diagnostic`.`id` AS `id_diagnostic`, diagnostic.date as datediagnostic, `diagnostic`.`obs_diagnostic`, `diagnostic`.`id_agent` AS `agentdiagnostic`,"
                . " `acte_pose`.`id` AS `idactepose`, `acte_pose`.`id_acte`, `acte_pose`.`id_agent` AS `idagent`,"
                . " `acte_pose`.`id_patient` AS `idpatient`, `acte_pose`.`etape`, `acte`.`lib` AS `acte_pose`, "
                . "`acte`.`id_category` AS `idcategoryacte`, `category_acte`.`lib` AS `category`, `acte_pose`.`date`, "
                . "`agent`.`id`, `agent`.`nom` AS `nomagent`, `agent`.`prenom` AS `prenomagent`, `agent`.`fonction` AS `idfonction`,"
                . " `fonction`.`libelle` AS `fonction`, `patient`.`idPatient`, `patient`.`nom` AS `nompatient`, "
                . "`patient`.`prenom` AS `prenompatient`, `patient`.`sexe`, `patient`.`age`, `patient`.`etatcivil`, "
                . "`download`.`filename`, `download`.`type`";

        $condition['joins'] = [
            'tables' => ['acte_pose', 'acte', 'category_acte', 'agent', 'fonction', 'patient', 'download'],
            'tableBase' => ['diagnostic', 'acte_pose', 'acte', 'acte_pose', 'agent', 'acte_pose', 'patient'],
            'typeJointure' => ['INNER', 'INNER', 'INNER', 'INNER', 'INNER', 'INNER', 'LEFT'],
            'keys' => ['id', 'id', 'id', 'id', 'idFonction', 'idPatient', 'id_download'],
            'primaryKeys' => ['id_acte', 'id_acte', 'id_category', 'id_agent', 'fonction', 'id_patient', 'id_avatar']
        ];
        if (isset($date) && !empty($date)) {
            $condition['where'] = " WHERE DATE(diagnostic.date) = '" . date("Y-m-d", strtotime($date)) . "'";
        } else {
            $condition['where'] = " WHERE DATE(diagnostic.date) >= '" . date("Y-m-d") . "'";
        }
        $condition['order'] = " diagnostic.date DESC ";
        $r = $this->get("diagnostic", $condition);
        return $r;
    }

    public function searchDiagnostic($motif = "") {
        $condition['fields'] = "``diagnostic`.`id` AS `id_diagnostic`, diagnostic.date as datediagnostic, `diagnostic`.`obs_diagnostic`, `diagnostic`.`id_agent` AS `agentdiagnostic`"
                . " `acte_pose`.`id` AS `idactepose`, `acte_pose`.`id_acte`, `acte_pose`.`id_agent` AS `idagent`,"
                . " `acte_pose`.`id_patient` AS `idpatient`, `acte_pose`.`etape`, `acte`.`lib` AS `acte_pose`, "
                . "`acte`.`id_category` AS `idcategoryacte`, `category_acte`.`lib` AS `category`, `acte_pose`.`date`, "
                . "`agent`.`id`, `agent`.`nom` AS `nomagent`, `agent`.`prenom` AS `prenomagent`, `agent`.`fonction` AS `idfonction`,"
                . " `fonction`.`libelle` AS `fonction`, `patient`.`idPatient`, `patient`.`nom` AS `nompatient`, "
                . "`patient`.`prenom` AS `prenompatient`, `patient`.`sexe`, `patient`.`age`, `patient`.`etatcivil`, "
                . "`download`.`filename`, `download`.`type`";

        $condition['joins'] = [
            'tables' => ['acte_pose', 'acte', 'category_acte', 'agent', 'fonction', 'patient', 'download'],
            'tableBase' => ['diagnostic', 'acte_pose', 'acte', 'acte_pose', 'agent', 'acte_pose', 'patient'],
            'typeJointure' => ['INNER', 'INNER', 'INNER', 'INNER', 'INNER', 'INNER', 'LEFT'],
            'keys' => ['id', 'id', 'id', 'id', 'idFonction', 'idPatient', 'id_download'],
            'primaryKeys' => ['id_acte', 'id_acte', 'id_category', 'id_agent', 'fonction', 'id_patient', 'id_avatar']
        ];
        $condition['where'] = " WHERE patient.nom LIKE '%$motif%' XOR  patient.prenom LIKE '%$motif%' XOR patient.postnom LIKE '%$motif%'";
        return $this->get("consultation", $condition);
    }

    public function customDiagnostic($conditionadditive = []) {
        $condition['fields'] = "`diagnostic`.`id` AS `id_diagnostic`, diagnostic.date as datediagnostic, `diagnostic`.`obs_diagnostic`, `diagnostic`.`id_agent` AS `agentdiagnostic`,"
                . " `acte_pose`.`id` AS `idactepose`, `acte_pose`.`id_acte`, `acte_pose`.`id_agent` AS `idagent`,"
                . " `acte_pose`.`id_patient` AS `idpatient`, `acte_pose`.`etape`, `acte`.`lib` AS `acte_pose`, "
                . "`acte`.`id_category` AS `idcategoryacte`, `category_acte`.`lib` AS `category`, `acte_pose`.`date`, "
                . "`agent`.`id`, `agent`.`nom` AS `nomagent`, `agent`.`prenom` AS `prenomagent`, `agent`.`fonction` AS `idfonction`,"
                . " `fonction`.`libelle` AS `fonction`, `patient`.`idPatient`, `patient`.`nom` AS `nompatient`, "
                . "`patient`.`prenom` AS `prenompatient`, `patient`.`sexe`, `patient`.`age`, `patient`.`etatcivil`, "
                . "`download`.`filename`, `download`.`type`";

        $condition['joins'] = [
            'tables' => ['acte_pose', 'acte', 'category_acte', 'agent', 'fonction', 'patient', 'download'],
            'tableBase' => ['diagnostic', 'acte_pose', 'acte', 'acte_pose', 'agent', 'acte_pose', 'patient'],
            'typeJointure' => ['INNER', 'INNER', 'INNER', 'INNER', 'INNER', 'INNER', 'LEFT'],
            'keys' => ['id', 'id', 'id', 'id', 'idFonction', 'idPatient', 'id_download'],
            'primaryKeys' => ['id_acte', 'id_acte', 'id_category', 'id_agent', 'fonction', 'id_patient', 'id_avatar']
        ];
        $condition = array_merge($condition, $conditionadditive);
        return $this->get("diagnostic", $condition);
    }

    public function addDiagnostic($data = []) {
        extract($data);
        $condition['where'] = " Where id = '$acte_pose'";
        $act = $this->get("acte_pose", $condition);
        if (count($act) < 1) {
            $this->errors[] = "Veuillez sélectionner l'acte d'abord. Si l'erreur persiste c'est être une tentative de piratage. Please veuillez contacter MDE SERVICES IT";
        }
        $this->valideData($obs, "#^.{1,5000}$#s", "Le texte d'àbservation ne doit être vide et doit être composé que des caractères ordinaire minimum 1 maximum 5000 caractères", "Observation", false);
        if (count($this->errors) < 1) {
            $values = new \stdClass();
            $values->id_acte = $acte_pose;
            $values->id_agent = $_SESSION['user']['agent'];
            $values->obs_diagnostic = $obs;

            $rr = $this->input($values, "diagnostic");

            if ($rr != true) {

                return false;
            }
            return $rr;
        } else {
            //var_dump($this->errors);
            return false;
        }
    }

    public function addNursing($data = []) {
        extract($data);
        $condition['where'] = " Where id = '$acte_pose'";
        $act = $this->get("acte_pose", $condition);
        if (count($act) < 1) {
            $this->errors[] = "Veuillez sélectionner l'acte d'abord. Si l'erreur persiste c'est être une tentative de piratage. Please veuillez contacter MDE SERVICES IT";
        }
        unset($condition);
        $condition['where'] = " WHERE id_acte_infirmier = '$actenursing'";
        $flagNursing = $this->get("acte_infirmier", $condition);
        if (count($flagNursing) < 1) {
            $this->errors[] = "Veuillez sélectionner l'acte infirmier d'abord. Si l'erreur persiste c'est être une tentative de piratage. Please veuillez contacter MDE SERVICES IT";
        }
        $this->valideData($obs, "#^.{1,5000}$#s", "Le texte d'àbservation ne doit être vide et doit être composé que des caractères ordinaire minimum 1 maximum 5000caractères", "Observation");
        if (count($this->errors) < 1) {
            $values = new \stdClass();
            $values->id_acte_pose = $acte_pose;
            $values->id_acte_infirmier_fk = $actenursing;
            $values->id_infirmier = $_SESSION['user']['agent'];
            $values->observation = $obs;
            $this->input($values, "traitement_administre");
            return true;
        } else {
            return false;
        }
    }

    function addconsultationinfo($data = []) {
        extract($data);
        $condition['where'] = " WHERE id = '$acte_medical'";
        $act = $this->get("acte_pose", $condition);
        if (count($act) < 1) {
            $this->errors[] = "Veuillez sélectionner l'acte d'abord. Si l'erreur persiste c'est être une tentative de piratage. Please veuillez contacter MDE SERVICES IT";
        }
        $this->valideData($anamnse, "#^.{1,5000}$#s", "Le texte d'anamnese ne doit être vide et doit être composé que des caractères ordinaire minimum 1 maximum 1000 caractères", "Anamnese", false);
        $this->valideData($poids, "#^[\d]{1,3}$#", "Le poids ne doit être vide et doit être composé que des chiffres et le caractère POINT (.) est admis comme étant séparateur des décimaux maximum 5 caractères, l'unité de mesure est le centimètre (cm)", "Poids");
        $this->valideData($temperature, "#^[0-9a-zA-Z.\,/]{1,5}$#", "La température ne doit être vide et doit être composé que des chiffres et le caractère POINT (.) est admis comme étant séparateur des décimaux", "température");
        $this->valideData($tension, "#^[0-9a-zA-Z.\,/]{1,20}$#", "La tension ne doit être vide et doit être composé que des chiffres et le caractère POINT (.) est admis comme étant séparateur des décimaux", "Tension");
        $this->valideData($fr, "#^[0-9A-Za-z.\,/]{1,5}$#", "La Fréquence respiratoire ne doit être vide et doit être composé que des chiffres et le caractère POINT (.) est admis comme étant séparateur des décimaux", "F.R");
        $this->valideData($pouls, "#^[0-9A-Za-z.\,/]{1,5}$#", "Le Pouls ne doit être vide et doit être composé que des chiffres, lettres et le caractère POINT (.) sont admis ", "Pouls");
        $this->valideData($spo, "#^[0-9A-Za-z\.,/]{1,5}$#", "Le SPO2 ne doit être vide et doit être composé que des chiffres, lettres et le caractère POINT (.) sont admis ", "SPO2");
        $this->valideData($taille, "#^[\d]{1,3}$#", "La taille ne doit être vide et doit être composé que des chiffres et le caractère POINT (.) est admis comme étant séparateur des décimaux", "Taille");
        if (count($this->errors) > 0) {
            return false;
        } else {
            $values = new \stdClass();
            $values->id_acte = $acte_medical;
            $values->anamnese = $anamnse;
            $values->tension = $tension;
            $values->temp = $temperature;
            $values->taille = $taille;
            $values->fr = $fr;
            $values->spo = $spo;
            $values->pouls = $pouls;
            $values->poids = $poids;
            $this->input($values, "consultation");
            return true;
        }
    }

    public function getDiagnostic($id) {
        
    }

    public function getDiagnosticInfo($id) {
        $condition['fields'] = "`diagnostic`.`id`, `diagnostic`.`id_acte`, `diagnostic`.`obs_diagnostic`, `diagnostic`.`id_agent`, "
                . "`diagnostic`.`date`, `acte_pose`.`id_acte` AS `idacte`, `acte_pose`.`id_patient`, `acte_pose`.`date` AS `dateacte`,"
                . " `acte`.`lib` AS `acte`, `acte`.`id_category`, `category_acte`.`id` AS `idcategory`, `category_acte`.`lib` AS `category`, "
                . "`patient`.`idPatient`, `patient`.`nom`, `patient`.`postnom`, `patient`.`prenom`, `patient`.`sexe`, `patient`.`age`,"
                . " `patient`.`etatcivil`, `patient`.`id_avatar`, `download`.`filename`, `download`.`type`, `agent`.`nom` AS `nomagent`, "
                . "`agent`.`prenom` AS `prenomagent`, `agent`.`fonction` AS `idfonction`, `fonction`.`libelle` AS `fonction`";
        $condition['joins'] = [
            'tables' => ['acte_pose', 'acte', 'category_acte', 'agent', 'fonction', 'patient', 'download'],
            'tableBase' => ['diagnostic', 'acte_pose', 'acte', 'acte_pose', 'agent', 'acte_pose', 'patient'],
            'typeJointure' => ['INNER', 'INNER', 'INNER', 'INNER', 'INNER', 'INNER', 'LEFT'],
            'keys' => ['id', 'id', 'id', 'id', 'idFonction', 'idPatient', 'id_download'],
            'primaryKeys' => ['id_acte', 'id_acte', 'id_category', 'id_agent', 'fonction', 'id_patient', 'id_avatar']
        ];
    }

    public function getListExamen($id = "") {
        if (isset($id) && !empty($id)) {
            $condition['where'] = " WHERE id = '$id'";
            $r = $this->get("examens", $condition);
        } else {
            $r = $this->get("examens");
        }
        return $r;
    }

    public function getCustomExamen($conditionadditive = "") {
        $sql = "SELECT COUNT(`examen_recommand`.`id_diagnostic`) as nExam,`examen_recommand`.`id` AS `idexamenrecommand`, `examen_recommand`.`id_diagnostic`, `examen_recommand`.`id_examen`, 
            `examen_recommand`.`observation`, `examen_recommand`.`resultat`, `examen_recommand`.`id_agent_labo`, `examen_recommand`.`fait`, 
            `diagnostic`.`id_acte`, `diagnostic`.`obs_diagnostic`, `diagnostic`.`id_agent` AS `medecin`, `diagnostic`.`date` AS `datediagnostic`, 
            `examen_recommand`.`daterecommande`, `examen_recommand`.`datefait`, `acte_pose`.`id` AS `idactepose`, 
            `acte_pose`.`id_patient` AS `id_patient`, `acte_pose`.`id_agent`, `acte_pose`.`id_acte`, `acte_pose`.`etape`,
             `acte_pose`.`date` AS `dateacte`, `acte`.`lib` AS `acte`, `acte`.`prix_prive`, `acte`.`prix_conventionne`, `acte`.`prix_affilier`,
              `acte`.`prix`, `acte`.`id_category`, `category_acte`.`lib` AS `category`, `agent`.`id` AS `idmedecin`, `agent`.`nom` AS `nommedecin`,
               `agent`.`prenom` AS `prenommedecin`, `agent`.`fonction` AS `idfonction`, `fonction`.`idFonction` AS `fonction`, 
               `agentlabo`.`id` AS `idlaboratin`, `agentlabo`.`nom` AS `nomlaboratin`, `agentlabo`.`prenom` AS `prenomlaboratin`, 
               `agent`.`fonction` AS `idfonctionlaboratin`, `fonction`.`libelle` AS `fonctionlaboratin`, `patient`.`idPatient`, 
               `patient`.`nom` AS `nompatient`, `patient`.`postnom` AS `postnompatient`, `patient`.`prenom` AS `prenompatient`, `patient`.`sexe`,
                `patient`.`age`, `patient`.`id_avatar`, `download`.`filename`, `download`.`type` 
                FROM examen_recommand 
                INNER JOIN examens ON examens.id = examen_recommand.id_examen 
                INNER JOIN diagnostic ON diagnostic.id = examen_recommand.id_diagnostic 
                INNER JOIN acte_pose ON acte_pose.id = diagnostic.id_acte 
                INNER JOIN acte ON acte.id = acte_pose.id_acte 
                INNER JOIN category_acte ON category_acte.id = acte.id_category 
                INNER JOIN agent ON agent.id = diagnostic.id_agent 
                INNER JOIN fonction ON fonction.idFonction = agent.fonction 
                LEFT JOIN agent as agentlabo ON agentlabo.id = examen_recommand.id_agent_labo 
                INNER JOIN patient ON patient.idPatient = acte_pose.id_patient                 
                LEFT JOIN download ON download.id_download = patient.id_avatar ";
        if (isset($conditionadditive)) {
            $sql .= $conditionadditive;
        }

        $sql .= " GROUP BY examen_recommand.id_diagnostic ";
        $sql .= " ORDER BY diagnostic.date DESC ";
        try {
            $stm = $this->cnx->query($sql);
            $r = $stm->fetchAll(\PDO::FETCH_OBJ);
            return $r;
        } catch (\PDOException $exc) {
            throw new MDEException($exc);
        }
        //$condition = array_merge($condition, $conditionadditive);
        return $this->get("examen_recommand", $condition);
    }

    public function getCustomExamenItem($conditionadditive = "") {
        $sql = "SELECT `examen_recommand`.`id` AS `idexamenrecommand`,examens.lib as libexamen, examens.prixprive as prixexamen, `examen_recommand`.`id_diagnostic`, `examen_recommand`.`id_examen`, 
            `examen_recommand`.`observation`, `examen_recommand`.`resultat`, `examen_recommand`.`id_agent_labo`, `examen_recommand`.`fait`, 
            `diagnostic`.`id_acte`, `diagnostic`.`obs_diagnostic`, `diagnostic`.`id_agent` AS `medecin`, `diagnostic`.`date` AS `datediagnostic`, 
            `examen_recommand`.`daterecommande`, `examen_recommand`.`datefait`, `acte_pose`.`id` AS `idactepose`, 
            `acte_pose`.`id_patient` AS `id_patient`, `acte_pose`.`id_agent`, `acte_pose`.`id_acte`, `acte_pose`.`etape`,
             `acte_pose`.`date` AS `dateacte`, `acte`.`lib` AS `acte`, `acte`.`prix_prive`, `acte`.`prix_conventionne`, `acte`.`prix_affilier`,
              `acte`.`prix`, `acte`.`id_category`, `category_acte`.`lib` AS `category`, `agent`.`id` AS `idmedecin`, `agent`.`nom` AS `nommedecin`,
               `agent`.`prenom` AS `prenommedecin`, `agent`.`fonction` AS `idfonction`, `fonction`.`idFonction` AS `fonction`, 
               `agentlabo`.`id` AS `idlaboratin`, `agentlabo`.`nom` AS `nomlaboratin`, `agentlabo`.`prenom` AS `prenomlaboratin`, 
               `agent`.`fonction` AS `idfonctionlaboratin`, `fonction`.`libelle` AS `fonctionlaboratin`, `patient`.`idPatient`, 
               `patient`.`nom` AS `nompatient`, `patient`.`postnom` AS `postnompatient`, `patient`.`prenom` AS `prenompatient`, `patient`.`sexe`,
                `patient`.`age`, `patient`.`id_avatar`, `download`.`filename`, `download`.`type` 
                FROM examen_recommand 
                INNER JOIN examens ON examens.id = examen_recommand.id_examen 
                INNER JOIN diagnostic ON diagnostic.id = examen_recommand.id_diagnostic 
                INNER JOIN acte_pose ON acte_pose.id = diagnostic.id_acte 
                INNER JOIN acte ON acte.id = acte_pose.id_acte 
                INNER JOIN category_acte ON category_acte.id = acte.id_category 
                INNER JOIN agent ON agent.id = diagnostic.id_agent 
                INNER JOIN fonction ON fonction.idFonction = agent.fonction 
                LEFT JOIN agent as agentlabo ON agentlabo.id = examen_recommand.id_agent_labo 
                INNER JOIN patient ON patient.idPatient = acte_pose.id_patient 
                LEFT JOIN download ON download.id_download = patient.id_avatar ";
        if (isset($conditionadditive)) {
            $sql .= $conditionadditive;
        }
        try {
            $stm = $this->cnx->query($sql);
            $r = $stm->fetchAll(\PDO::FETCH_OBJ);
            return $r;
        } catch (\PDOException $exc) {
            throw new \composants\MDEException($exc);
        }
        //$condition = array_merge($condition, $conditionadditive);
        return $this->get("examen_recommand", $condition);
    }

    public function addExamen($data = []) {
        extract($data);
        $condition['where'] = " WHERE id = '$iddiagnostic'";
        $diagnostic = $this->get("diagnostic", $condition);
        //$agent = $_SESSION['user']['agent'];
        $conditions['where'] = " WHERE id = '$examen'";
        $flaxExam = $this->get("examens", $conditions);
        unset($condition);
        $condition['where'] = " WHERE examen_recommand.id_diagnostic = '$iddiagnostic' AND id_examen = '$examen'";

        $flag = $this->get("examen_recommand", $condition);
        if (count($flag) > 0) {
            $this->errors[] = "Examen déjà ajouté, On ne peut pas ajouter un examen plus d'une fois";
            return false;
        }
        if (count($diagnostic) < 1) {
            $this->errors[] = "Veuillez sélectionner le diagnostic lequel vous voulez associer cet examen. Si l'erreur persiste c'est être une tentative de piratage. Please veuillez contacter MDE SERVICES IT";
        }
        if (count($flaxExam) < 1) {
            $this->errors[] = "Veuillez sélectionner l'examen lequel vous voulez recommander au patient. Si l'erreur persiste c'est être une tentative de piratage. Please veuillez contacter MDE SERVICES IT";
        }
        $this->valideData($observation, "#^(.){1,1000}$#", "Le texte d'observation ne doit être vide et doit être composé que des caractères ordinaire minimum 1 maximum 1000caractères", "observation", false);

        if (count($this->errors) > 0) {
            return false;
        } else {
            $values = new \stdClass();
            $values->id_diagnostic = $iddiagnostic;
            $values->observation = $observation;
            $values->id_examen = $examen;
            $values->id_hopital_er = $_SESSION['user']['idhopital'];
            $this->input($values, "examen_recommand");
            return true;
        }
    }

    /*
      @$id  = identifiant du diagnostique
     */

    public function getRecommandExamForExam($id = "") {
        $condition['fields'] = " examen_recommand.id, examen_recommand.id_diagnostic AS idexamen, "
                . "examen_recommand.id_examen, examen_recommand.observation AS obs, examen_recommand.resultat,"
                . " examen_recommand.id_agent_labo, examen_recommand.fait, examens.id AS idexamen, "
                . "examen_recommand.id_diagnostic, examens.lib AS examen, examens.prixprive, "
                . "examens.prixconventionne, examens.prixaffilier, examens.description ";
        $condition['joins'] = [
            'tables' => ['examens'],
            'tableBase' => ['examen_recommand'],
            'typeJointure' => ['INNER'],
            'keys' => ['id'],
            'primaryKeys' => ['id_examen']
        ];
        if (isset($id) && !empty($id)) {
            $condition['where'] = " WHERE id_diagnostic = '$id'";
            $r = $this->get("examen_recommand", $condition);
        } else {
            $r = $this->get("examen_recommand", $condition);
        }
        return $r;
    }

    public function getPrelevementExamForExam($id = "") {
        $condition['fields'] = " examen_recommand.id, examen_recommand.id_diagnostic AS idexamen, "
                . "examen_recommand.id_examen, examen_recommand.observation AS obs, examen_recommand.resultat,"
                . " examen_recommand.id_agent_labo, examen_recommand.fait, examens.id AS idexamen, "
                . "examen_recommand.id_diagnostic, examens.lib AS examen, examens.prixprive, "
                . "examens.prixconventionne, examens.prixaffilier, examens.description, prevelement_labo.id as idprelever, prevelement_labo.label , prevelement_labo.date_prelevement, prevelement_labo.id_user as userprev, prevelement_labo.id_examen_recommand as idexamenred  ";
        $condition['joins'] = [
            'tables' => ["examen_recommand", 'examens'],
            'tableBase' => ["prevelement_labo", 'examen_recommand'],
            'typeJointure' => ["INNER", 'INNER'],
            'keys' => ["id", 'id'],
            'primaryKeys' => ["id_examen_recommand", 'id_examen']
        ];
        if (isset($id) && !empty($id)) {
            $condition['where'] = " WHERE examen_recommand.id = '$id' ";
            $r = $this->get("prevelement_labo", $condition);
        } else {
            $r = $this->get("prevelement_labo", $condition);
        }
        return $r;
    }

    public function removerecomamandexamen($id) {
        if (isset($id)) {
            $r = $this->delete("id", $id, "examen_recommand");
            if ($r == true) {
                return true;
            }
        }
        $this->errors = ["une erreur est surgie lors de la suppression de l'examen"];
        return false;
    }

    public function getListActe($id = "") {

        $condition['fields'] = "`acte_pose`.`id` AS `idactepose`, `acte_pose`.`id_acte`, `acte_pose`.`date`, `acte`.`lib` AS `acte`,"
                . " `acte`.`description`, `acte`.`prix_prive`, `acte`.`prix_conventionne`, `acte`.`prix_affilier`, acte.prix, `acte`.`id` AS `idacte`,"
                . " `category_acte`.`lib` AS `category`,`agent`.`id` AS `idagent`, `agent`.`nom` AS `nomagent`, `agent`.`prenom` AS `prenomagent`, "
                . "`fonction`.`libelle` AS `fonctionagent`, `patient`.`idPatient`, `patient`.`nom` AS `nompatient`, "
                . "`patient`.`prenom` AS `prenompatient`, `patient`.`postnom` AS `postnompatient`, `patient`.`sexe` AS `sexepatient`,"
                . " `patient`.`age` AS `agepatient`, `patient`.`etatcivil`, `download`.`filename`, `download`.`type`, patient.nu, patient.numinterne, patient.statut";
        $condition['joins'] = [
            'tables' => ['acte', "category_acte", "agent", "fonction", "patient", "download"],
            'tableBase' => ['acte_pose', "acte", "acte_pose", "agent", "acte_pose", "patient"],
            'typeJointure' => ['INNER', "INNER", "INNER", "INNER", "INNER", "LEFT"],
            'keys' => ['id', "id", "id", "idFonction", "idPatient", "id_download"],
            'primaryKeys' => ['id_acte', "id_category", "id_agent", "fonction", "id_patient", "id_avatar"]
        ];
        $condition['order'] = " acte_pose.date DESC";
        if (isset($id) && !empty($id)) {
            $condition['where'] = " WHERE acte_pose.id = '$id' AND  acte_pose.id_hopital = " . htmlentities($_SESSION['user']['idhopital']) . " ";
            $r = $this->get("acte_pose", $condition);
        } else {
            $condition['where'] = " WHERE acte_pose.id_hopital = " . htmlentities($_SESSION['user']['idhopital']) . " ";
            $r = $this->paginate("acte_pose", $condition, 50);
        }
        return $r;
    }

    public function doExamen($data = []) {
        extract($data);
        if (isset($data['examen']) && !empty($data['examen'])) {

            $condition['where'] = " WHERE id ='" . $data['examen'] . "' AND examen_recommand.id_hopital_er = '" . htmlentities($_SESSION['user']['idhopital']) . "' ";

            $r = $this->get("examen_recommand", $condition);

            if (count($r) > 0) {
                
            } else {
                array_push($this->errors, "Examen non trouvé dans la fiche de recommandation diagnostique du patient. ");
                return 0;
            }
            $this->valideData($data['resultat'], "#^.{1,500}$s#", "Le resultat ne peut être vide et doit contenir les caractères ordinaires", "resultat");
            if (count($this->errors) > 0) {
                return false;
            } else {
                $values = new \stdClass();
                $values->resultat = $resultat;
                $values->id_acte = $id_acte;
                $values->fait = "1";
                $values->id_hopital_er = $_SESSION['user']['idhopital'];
                $this->update($condition, $values, "examen_recommand");
                return true;
            }
        }
    }

    public function doPrelever($data = []) {
        extract($data);
        if (isset($data['examen']) && !empty($data['examen'])) {
            $condition['where'] = " WHERE id ='" . $data['examen'] . "'";
            $r = $this->get("examen_recommand", $condition);

            if (count($r) > 0) {
                
            } else {
                array_push($this->errors, "Examen non trouvé dans la fiche de recommandation diagnostique du patient. ");
                return 0;
            }
            $this->valideData($data['label'], "#^.{1,500}$s#", "Le resultat ne peut être vide et doit contenir les caractères ordinaires", "resultat");
            if (count($this->errors) > 0) {
                return false;
            } else {
                $values = new \stdClass();
                $values->label = $label;
                $values->id_examen_recommand = $data['examen'];
                $values->id_user = $_SESSION['user']['id_user'];
                $values->id_acte = $r[0]->id_acte;
                //$values->id_hopital_er = $_SESSION['user']['idhopital'];
                try {
                    return $this->input($values, "prevelement_labo");
                } catch (\Exception $e) {
                    $e->getTraceAsString();
                    return false;
                }
            }
        }
    }

    public function getPrescriptions($conditionadditive = []) {
        $condition['fields'] = "`prescription`.`id` AS `idPrescription`, `prescription`.`datePrescrit`, `prescription`.`idActe`, "
                . "`prescription`.`observation`, `acte_pose`.`id` AS `idactepose`, `acte_pose`.`etape`, `acte_pose`.`date`, "
                . "`acte`.`id` AS `id_acte`, `acte`.`id_category`, `acte`.`lib` AS `acte`, `acte`.`id_category`, "
                . "`category_acte`.`lib` AS `category`, `acte`.`prix_prive`, `acte`.`prix_conventionne`, `acte`.`prix_affilier`, "
                . "`agent`.`id` AS `idagent`, `agent`.`nom` AS `nomagent`, `agent`.`prenom` AS `prenomagent`, `agent`.`fonction` AS `idfonction`, "
                . "`fonction`.`libelle` AS `fonction`, `patient`.`idPatient`, `patient`.`nom` AS `nompatient`, "
                . "`patient`.`postnom` AS `postnompatient`, `patient`.`prenom` AS `prenompatient`, `patient`.`sexe` AS `sexepatient`, "
                . "`patient`.`age` AS `agepatient`, `patient`.`etatcivil`, `patient`.`typePatient`, `download`.`filename`, `download`.`type`";
        $condition['joins'] = [
            'tables' => ['acte_pose', 'acte', "category_acte", "agent", "fonction", "patient", "download"],
            'tableBase' => ['prescription', "acte_pose", 'acte', "acte_pose", "agent", 'acte_pose', "patient"],
            'typeJointure' => ['INNER', "INNER", "INNER", "INNER", "INNER", "INNER", "LEFT"],
            'keys' => ['id', "id", "id", "id", "idFonction", "idPatient", "id_download"],
            'primaryKeys' => ['idActe', "id_acte", 'id_category', "id_agent", "fonction", "id_patient", "id_avatar"]
        ];
        if (is_array($conditionadditive) && count($conditionadditive) > 0) {
            $condition = array_merge($condition, $conditionadditive);
        }
        return $this->get("prescription", $condition);
    }

    public function getElementPrescritByPrescritionId($conditionadditive = []) {
        $condition['fields'] = "`element_prescrit`.`id` AS `idelementprescrit`, `element_prescrit`.`id_prescription` AS `ele_idprescription`, "
                . "`element_prescrit`.`element`, `element_prescrit`.`mode_emploi`, `element_prescrit`.`observation` AS `elem_observation`,"
                . "`prescription`.`id` AS `idPrescription`, `prescription`.`datePrescrit`, `prescription`.`idActe`, `prescription`.`observation`, "
                . "`acte_pose`.`id_acte` AS `idactepose`, `acte_pose`.`etape`, `acte_pose`.`date`, `acte`.`id` AS `id_acte`, `acte`.`id_category`, "
                . "`acte`.`lib` AS `acte`, `acte`.`id_category`, `category_acte`.`lib` AS `category`, `acte`.`prix_prive`, `acte`.`prix_conventionne`, "
                . "`acte`.`prix_affilier`, `agent`.`id` AS `idagent`, `agent`.`nom` AS `nomagent`, `agent`.`prenom` AS `prenomagent`, "
                . "`agent`.`fonction` AS `idfonction`, `fonction`.`libelle` AS `fonction`, `patient`.`idPatient`, `patient`.`nom` AS `nompatient`, "
                . "`patient`.`postnom` AS `postnompatient`, `patient`.`prenom` AS `prenompatient`, `patient`.`sexe` AS `sexepatient`, "
                . "`patient`.`age` AS `agepatient`, `patient`.`etatcivil`, `patient`.`typePatient`, `download`.`filename`, `download`.`type`";
        $condition['joins'] = [
            'tables' => ['prescription', 'acte_pose', 'acte', "category_acte", "agent", "fonction", "patient", "download"],
            'tableBase' => ['element_prescrit', 'prescription', "acte_pose", 'acte', "acte_pose", "agent", 'acte_pose', "patient"],
            'typeJointure' => ['INNER', 'INNER', "INNER", "INNER", "INNER", "INNER", "INNER", "LEFT"],
            'keys' => ["id", 'id', "id", "id", "id", "idFonction", "idPatient", "id_download"],
            'primaryKeys' => ['id_prescription', "idActe", "id_acte", 'id_category', "id_agent", "fonction", "id_patient", "id_avatar"]
        ];
        if (is_array($conditionadditive) && count($conditionadditive) > 0) {
            $condition = array_merge($condition, $conditionadditive);
        }
        return $this->get("element_prescrit", $condition);
    }

    public function getElementPrescritWithCount($conditionadditive = []) {
        $condition['fields'] = "COUNT(`element_prescrit`.`id`) AS nElement, `element_prescrit`.`id` AS `idelementprescrit`, `element_prescrit`.`id_prescription` AS `ele_idprescription`, "
                . "`element_prescrit`.`element`, `element_prescrit`.`mode_emploi`, `element_prescrit`.`observation` AS `elem_observation`,"
                . "`prescription`.`id` AS `idPrescription`, `prescription`.`datePrescrit`, `prescription`.`idActe`, `prescription`.`observation`, "
                . "`acte_pose`.`id_acte` AS `idactepose`, `acte_pose`.`etape`, `acte_pose`.`date`, `acte`.`id` AS `id_acte`, `acte`.`id_category`, "
                . "`acte`.`lib` AS `acte`, `acte`.`id_category`, `category_acte`.`lib` AS `category`, `acte`.`prix_prive`, `acte`.`prix_conventionne`, "
                . "`acte`.`prix_affilier`, `agent`.`id` AS `idagent`, `agent`.`nom` AS `nomagent`, `agent`.`prenom` AS `prenomagent`, "
                . "`agent`.`fonction` AS `idfonction`, `fonction`.`libelle` AS `fonction`, `patient`.`idPatient`, `patient`.`nom` AS `nompatient`, "
                . "`patient`.`postnom` AS `postnompatient`, `patient`.`prenom` AS `prenompatient`, `patient`.`sexe` AS `sexepatient`, "
                . "`patient`.`age` AS `agepatient`, `patient`.`etatcivil`, `patient`.`typePatient`, `download`.`filename`, `download`.`type`";
        $condition['joins'] = [
            'tables' => ['element_prescrit', 'acte_pose', 'acte', "category_acte", "agent", "fonction", "patient", "download"],
            'tableBase' => ['prescription', 'prescription', "acte_pose", 'acte', "acte_pose", "agent", 'acte_pose', "patient"],
            'typeJointure' => ['INNER', 'INNER', "INNER", "INNER", "INNER", "INNER", "INNER", "LEFT"],
            'keys' => ["id_prescription", 'id', "id", "id", "id", "idFonction", "idPatient", "id_download"],
            'primaryKeys' => ['id', "idActe", "id_acte", 'id_category', "id_agent", "fonction", "id_patient", "id_avatar"]
        ];
        if (is_array($conditionadditive) && count($conditionadditive) > 0) {
            $condition = array_merge($condition, $conditionadditive);
        }
        $condition['groupBy'] = "   element_prescrit.id_prescription ";
        return $this->get("prescription", $condition);
    }

    public function removeelementfromprescrire($id) {
        $condition['where'] = " WHERE id = $id";
        $elem = $this->get("element_prescrit", $condition);
        if (count($elem) > 0) {
            return $this->delete("id", $id, "element_prescrit");
        } else {
            return false;
        }
    }

    public function addElemenToPrescription($data = []) {
        extract($data);
        $condition['where'] = " WHERE prescription.id = '$idprescription'";
        $act = $this->get("prescription", $condition);
        if (count($act) < 1) {
            $this->errors[] = "Veuillez sélectionner la référence prescription qui vous conduirait au fourmilaire ajout élément prescription. Si l'erreur persiste c'est être une tentative de piratage. Please veuillez contacter MDE SERVICES IT";
        }
        $this->valideData($element, "#^.{2,100}$#", "L'élément ne doit être vide et doit être composé que des caractères ordinaire minimum 2 maximum 90 caractères", "element");
        $this->valideData($modeemploi, "#^.{2,100}$#", "Le mode d'emploi ne doit être vide et doit être composé que des caractères ordinaire minimum 2 maximum 90 caractères", "Mode d'emploi");
        $this->valideData($observation, "#^(.){2,1000}$#s", "L'observation peut être vide mais doit être composé que des caractères ordinaire minimum 2 maximum 90 caractères", "Observation", false);

        if (count($this->errors) > 0) {
            return false;
        } else {
            $values = new \stdClass();
            $values->id_prescription = $idprescription;
            $values->element = $element;
            $values->mode_emploi = $modeemploi;
            $values->observation = $observation;
            $this->input($values, "element_prescrit");
            return true;
        }
    }

    public function initPrescription($data = []) {
        extract($data);
        $condition['where'] = " Where id = '$idactepose'";
        if (!isset($data['idactepose']) || !empty($data['idactepose'])) {
            
        }
        $act = $this->get("acte_pose", $condition);
        if (count($act) < 1) {
            $this->errors[] = "Veuillez sélectionner l'acte d'abord. Si l'erreur persiste c'est être une tentative de piratage. Please veuillez contacter MDE SERVICES IT";
        }
        $this->valideData($observation, "#^(.){1,1000}$s#", "Le texte d'observation peut doit être vide et doit être composé que des caractères ordinaire minimum 1 maximum 1000caractères", "Observation", false);
        if (count($this->errors) > 0) {
            return false;
        } else {
            $values = new \stdClass();
            $values->idActe = $idactepose;
            $values->observation = $observation;
            $this->input($values, "prescription");
            return true;
        }
    }

    public function getLits($conditionadditive = []) {
        $condition['fields'] = "`lit`.`id` AS `idlit`, `lit`.`id_chambre`, busy,`lit`.`lib` AS `lit`, `chambre`.`id` AS `idchambre`, 
            `chambre`.`lib` AS `chambre`, `chambre`.`prix`, `chambre`.`category`
            ";
        $condition['joins'] = [
            'tables' => ['chambre'],
            'tableBase' => ['lit'],
            'typeJointure' => ['INNER'],
            'keys' => ["id"],
            'primaryKeys' => ['id_chambre']
        ];
        if (is_array($conditionadditive) && count($conditionadditive) > 0) {
            $condition = array_merge($condition, $conditionadditive);
        }

        return $this->get("lit", $condition);
    }

    public function getChambre($conditionadditive = []) {
        $condition['fields'] = "`lit`.`id` AS `idlit`, `lit`.`id_chambre`, busy,`lit`.`lib` AS `lit`, `chambre`.`id` AS `idchambre`, 
            `chambre`.`lib` AS `chambre`, `chambre`.`prix`, `chambre`.`category`
            ";
        $condition['joins'] = [
            'tables' => ['lit'],
            'tableBase' => ['chambre'],
            'typeJointure' => ['LEFT'],
            'keys' => ["id_chambre"],
            'primaryKeys' => ['id']
        ];
        if (is_array($conditionadditive) && count($conditionadditive) > 0) {
            $condition = array_merge($condition, $conditionadditive);
        }
        $condition['groupBy'] = " chambre.id";
        return $this->get("chambre", $condition);
    }

    public function getHospitalisation($conditionadditive = []) {
        $condition['fields'] = "`hospitalisation`.`id` AS `idhospitalisation`, `hospitalisation`.`id_acte` AS `id_acte`, "
                . "`hospitalisation`.`date_entree`, `hospitalisation`.`id_agent`, `hospitalisation`.`id_lit`, `hospitalisation`.`etat`, "
                . "hospitalisation.date_sortie,`lit`.`id` AS `idlitheberger`, `lit`.`lib` AS `nomlitheberge`, `chambre`.`lib` AS `nomchambreheberge`, "
                . "`chambre`.`category` AS `categorychamber`, `chambre`.`prix` AS `prixchambre`, `acte_pose`.`id` AS `id_actepose`, "
                . "`acte_pose`.`id_patient` AS `id_patient_heberge`, `acte_pose`.`id_agent`, `acte`.`id` AS `id_acte`, `acte`.`id_category`, "
                . "`acte`.`lib` AS `actepose`, `category_acte`.`id` AS `id_category_acte`, `agent`.`nom` AS `nomagent`, "
                . "`agent`.`postnom` AS `postnomagent`, `agent`.`prenom` AS `prenomagent`, `agent`.`fonction` AS `idfonction`, "
                . "`fonction`.`libelle` AS `fonction`, `patient`.`idPatient`, `patient`.`nom` AS `nompatient`, "
                . "`patient`.`postnom` AS `postnompatient`, `patient`.`prenom` AS `prenompatient`, `patient`.`sexe`, `patient`.`age`, "
                . "`patient`.`typePatient`, `patient`.`id_avatar`, `download`.`filename`, `download`.`type`, hospitalisation.observation as obshosp, hospitalisation.destination, hospitalisation.statut statuthosp, hospitalisation.id_download_file";

        $condition['joins'] = [
            'tables' => ['lit', 'chambre', 'acte_pose', "acte", "category_acte", "agent", "fonction", "patient", "download"],
            'tableBase' => ['hospitalisation', 'lit', "hospitalisation", "acte_pose", 'acte', "acte_pose", "agent", 'acte_pose', "patient"],
            'typeJointure' => ['INNER', 'INNER', "INNER", "INNER", "INNER", "INNER", "INNER", 'INNER', "LEFT"],
            'keys' => ["id", 'id', "id", "id", "id", "id", "idFonction", "idPatient", "id_download"],
            'primaryKeys' => ['id_lit', "id_chambre", "id_acte", "id_acte", 'id_category', "id_agent", "fonction", "id_patient", "id_avatar"]
        ];

        if (is_array($conditionadditive) && count($conditionadditive) > 0) {
            $condition = array_merge($condition, $conditionadditive);
        }
        $condition['order'] = " hospitalisation.date_entree DESC ";
        return $this->paginate("hospitalisation", $condition, 50);
    }

    public function hospitaliser($data) {
        extract($data);
        $condition['where'] = " WHERE id ='" . $data['id_actepose'] . "'";
        $acte = $this->get("acte_pose", $condition);
        unset($condition);
        $condition['where'] = " WHERE id ='" . $data['id_lit'] . "'";
        $litExist = $this->get("lit", $condition);
        if (count($acte) < 1) {
            array_push($this->errors, "Aucun acte n'a été trouvé, si cette erreur persiste, veuillez contacter MDE Services pour sa fixation");
        }
        if (count($litExist) < 1) {
            array_push($this->errors, "Aucun lit n'a été trouvé ou sélectionné, si cette erreur persiste, veuillez contacter MDE Services pour sa fixation");
        }

        if ($litExist[0]->busy == 1) {
            array_push($this->errors, "Ce lit est déjà occupé par un autre patient, hospitalisation annulée,... Si vous tenez vraiment à hospitaliser un patient là, veuillez d'abord libérer ce lit");
        }
        if (count($this->errors) > 0) {
            return false;
        } else {
            $values = new \stdClass();
            $values->id_acte = $id_actepose;
            $values->id_lit = $id_lit;
            $values->id_agent = $_SESSION['user']['agent'];
            $values->id_hopital = $_SESSION['user']['idhopital'];
            $this->input($values, "hospitalisation");
            return true;
        }
    }

    public function transfererhospitaliser($id = "") {
        $condition['where'] = " WHERE id ='" . $id . "'";
        $acte = $this->get("acte_pose", $condition);
        unset($condition);
        $condition['where'] = " WHERE hospitalisation.id_acte = '$id'";
        if (count($acte) < 1) {
            array_push($this->errors, "Aucun acte n'a été trouvé, si cette erreur persiste, veuillez contacter MDE Services pour sa fixation");
        }
        $hospi = $this->getHospitalisation($condition)['results'][0];

        if (count($this->errors) > 0) {
            return false;
        } else {
            $values = new \stdClass();
            $values->date_sortie = date("Y-m-d H:i:s");
            $values->etat = 1;
            unset($condition);
            $condition['where'] = " WHERE hospitalisation.id = '" . $hospi->idhospitalisation . "'";
            $this->startTransaction();
            $this->update($condition, $values, "hospitalisation");
            $datas['id_lit'] = $hospi->idlitheberger;
            $this->updateLit($datas, 0);

            $this->commitTransaction();
            return true;
        }
    }

    public function deshospitaliser($datas) {
        extract($datas);
        try {
            $this->startTransaction();
            $condition['where'] = " WHERE id ='" . $id . "'";
            $acte = $this->get("acte_pose", $condition);
            unset($condition);
            $condition['where'] = " WHERE hospitalisation.id_acte = '$id'";

            if (count($acte) < 1) {
                array_push($this->errors, "Aucun acte n'a été trouvé, si cette erreur persiste, veuillez contacter le support pour sa fixation");
            }
            $hospi = $this->getHospitalisation($condition)['results'];

            if (count($this->errors) > 0) {
                return false;
            } else {
            if ($hospi != null && count($hospi) > 0 && $hospi[0]->statuthosp ==  0) {
                    $hospi = $hospi[0];
                    $values = new \stdClass();
                    $values->date_sortie = date("Y-m-d H:i:s");
                    $values->statut = 1; //Sortie
                    $values->observation = $observation;
                    if (isset($_FILES['file']) && isset($_FILES['file']['name']) > 0 && strlen($_FILES['file']['name'][0]) > 0) {
                        $imgController = new \composants\Download(ROOT . DS . "img/");
                        $s = $imgController->addFiles($_FILES, "file");
                        $values->id_download_file = $s['ids'][0];
                        
                    }
                    
                    //$values->etat = 1;
                    unset($condition);
                    $condition['where'] = " WHERE hospitalisation.id = '" . $hospi->idhospitalisation . "'";
                    
                    $this->update($condition, $values, "hospitalisation");
                    $datas['id_lit'] = $hospi->idlitheberger;
                    $this->updateLit($datas, 0);
                    $this->commitTransaction();
                    return true;
                } else {
                    array_push($this->errors, "l'Hospitalisation n'a été trouvée ou elle a été libérée ou transférée");
                    return false;
                }
            }
        } catch (\Exception $e) {
            try {
                $this->rollback();
            } catch (Exception $ex) {
                
            }
            return false;
        }
    }

    public function transferer($datas) {
        extract($datas);
        
        try {
            $this->startTransaction();
            $condition['where'] = " WHERE id ='" . $id . "'";
            $acte = $this->get("acte_pose", $condition);
            unset($condition);
            $condition['where'] = " WHERE hospitalisation.id_acte = '$id'";

            if (count($acte) < 1) {
                array_push($this->errors, "Aucun acte n'a été trouvé, si cette erreur persiste, veuillez contacter le support pour sa fixation");
            }
            $hospi = $this->getHospitalisation($condition)['results'];

            if (count($this->errors) > 0) {
                return false;
            } else {
            if ($hospi != null && count($hospi) > 0 && ($hospi[0]->statuthosp ==  0 || $hospi[0]->statuthosp ==  1)  ) {
                    $hospi = $hospi[0];
                    $values = new \stdClass();
                    $values->date_sortie = date("Y-m-d H:i:s");
                    $values->destination = $destination;
                    $values->observation = $observation;
                    $values->statut = 2; //Sortie
                 
                    if (isset($_FILES['file']) && isset($_FILES['file']['name']) > 0 && strlen($_FILES['file']['name'][0]) > 0) {
                        $imgController = new \composants\Download(ROOT . DS . "img/");
                        $s = $imgController->addFiles($_FILES, "file");
                        $values->id_transfere_doc = $s['ids'][0];
                        
                    }
                    //\composants\Utilitaire::debug($s, true);
                    //$values->etat = 1;
                    unset($condition);
                    $condition['where'] = " WHERE hospitalisation.id = '" . $hospi->idhospitalisation . "'";
                    
                    $this->update($condition, $values, "hospitalisation");
                    $datas['id_lit'] = $hospi->idlitheberger;
                    $this->updateLit($datas, 0);
                    $this->commitTransaction();
                    return true;
                } else {
                    array_push($this->errors, "l'Hospitalisation n'a été trouvée ou elle a été libérée ou transférée");
                    return false;
                }
            }
        } catch (\Exception $e) {
            try {
                $this->rollback();
            } catch (Exception $ex) {
                
            }
            return false;
        }
    }

    
    public function updateLit($data, $busy = 1) {
        extract($data);
        $condition['where'] = " WHERE id ='" . $data['id_lit'] . "'";
        $litExist = $this->get("lit", $condition);
        if (count($litExist) < 1) {
            array_push($this->errors, "Aucun lit n'a été trouvé ou sélectionné, si cette erreur persiste, veuillez contacter MDE Services pour sa fixation");
        }
        if (count($this->errors) > 0) {
            return false;
        } else {
            $values = new \stdClass();
            if ($busy != 1) {
                $values->busy = 0;
            } else {
                $values->busy = 1;
            }

            $this->update($condition, $values, "lit");
            return true;
        }
    }

    public function getExamenPrices($motif = "") {
        $condition['fields'] = "`examens`.`id` AS `idexamen`, `examens`.`lib` AS `examen`, `examens`.`idcategory` AS `idcategory`, "
                . "`examens`.`prixprive`, `examens`.`prixconventionne`, `examens`.`prixaffilier`, `examens`.`description`, "
                . "`category_examen`.`id` AS `idcategory_examen`, `category_examen`.`lib` AS `category`";

        $condition['joins'] = [
            'tables' => ['category_examen'],
            'tableBase' => ['examens'],
            'typeJointure' => ['INNER'],
            'keys' => ['id'],
            'primaryKeys' => ['idcategory']
        ];
        $condition['order'] = "  category_examen.lib ASC, examens.lib ASC";
        if (isset($motif) && !empty($motif)) {
            $condition['where'] = " WHERE (examens.lib LIKE '%$motif%' OR examens.id LIKE '%$motif%'  OR category_examen.lib LIKE '%$motif%') AND examens.id_hopital = " . htmlentities($_SESSION['user']['idhopital']) . " ";
        } else {
            $condition['where'] = " WHERE examens.id_hopital = " . htmlentities($_SESSION['user']['idhopital']) . " ";
        }
        return $this->get("examens", $condition);
    }

    public function facturer($data = []) {
        extract($data);
        $condition['where'] = " WHERE acte_pose.id = $acte ";
        $flag = $this->get("acte_pose", $condition);
        if (count($flag) < 0) {
            array_push($this->errors, "Acte non trouvé dans la base de donnée");
        }
        $this->valideData($percu, "#^[\d.]{1,}$#", "Le réel perçu chez le client ne correspond pas à la norme. Si cette erreur prière d'en signaler l'administrateur du système pour la résolution et la sécurité du système", " Réel perçu", false);
        $this->valideData($netpay, "#^[\d.]{1,}$#", "Le net à payer ne correspond pas à la norme. Si cette erreur prière d'en signaler l'administrateur du système pour la résolution et la sécurité du système", "Net à payer");

        if (count($this->errors) > 0) {
            return false;
        }
        if ($percu == 0) {
            $percu = $netpay;
        }
        $values = new \stdClass();
        $values->id_acte_pose = $acte;
        $values->id_agent = $_SESSION['user']['agent'];
        $values->montant = $netpay;
        $values->percu = $percu;
        $values->tauxapplique = Pharmacy::getTaux();
        $this->input($values, "facture_acte");
        return true;
    }

    public function getFacture($conditionadditive = []) {
        $condition['fields'] = "`facture_acte`.`id` AS `idfacture`, `facture_acte`.*, `agent`.`id` AS `idagent`, `agent`.`nom`, `agent`.`postnom`, "
                . "`agent`.`genre`, agent.prenom, `agent`.`fonction`, `acte_pose`.`id` AS `actepose`, `acte`.`id` AS `idacte`, `acte`.`lib` AS `libactepose`, "
                . "`fonction`.`libelle` AS `libfonction`";
        $condition['joins'] = [
            'tables' => ['agent', 'acte_pose', 'acte', 'fonction'],
            'tableBase' => ['facture_acte', 'facture_acte', 'acte_pose', 'agent'],
            'typeJointure' => ['INNER', 'INNER', 'INNER', 'INNER'],
            'keys' => ['id', 'id', 'id', 'idFonction'],
            'primaryKeys' => ['id_agent', 'id_acte_pose', 'id_acte', 'fonction']
        ];
        $condition = array_merge($condition, $conditionadditive);
        $condition['order'] = "  facture_acte.date_facture DESC ";
        return $this->get('facture_acte', $condition);
    }

    public function getFactureTotal($conditionadditive = []) {
        $condition['fields'] = "`facture_acte`.`id` AS `idfacture`, `facture_acte`.*, `agent`.`id` AS `idagent`, `agent`.`nom`, `agent`.`postnom`, "
                . "`agent`.`genre`, `agent`.`fonction`, `acte_pose`.`id` AS `actepose`, `acte`.`id` AS `idacte`, `acte`.`lib` AS `libactepose`, "
                . "`fonction`.`libelle` AS `libfonction`, SUM(facture_acte.percu) as totalpercu  , COUNT(facture_acte.percu) as npercu , SUM(montant) as totaldu , COUNT(montant) as totaldu ";
        $condition['joins'] = [
            'tables' => ['agent', 'acte_pose', 'acte', 'fonction'],
            'tableBase' => ['facture_acte', 'facture_acte', 'acte_pose', 'agent'],
            'typeJointure' => ['INNER', 'INNER', 'INNER', 'INNER'],
            'keys' => ['id', 'id', 'id', 'idFonction'],
            'primaryKeys' => ['id_agent', 'id_acte_pose', 'id_acte', 'fonction']
        ];
        $condition = array_merge($condition, $conditionadditive);
        $condition['order'] = "  facture_acte.date_facture DESC ";
        return $this->get('facture_acte', $condition);
    }

    public function delfacture($id = "") {
        if (isset($id) && !empty($id)) {
            $this->delete("facture_acte.id", $id, "facture_acte");
            return true;
        }
        return false;
    }

    public function addExtra($data, $acte_medical) {
        extract($data);
        $condition['where'] = " Where id = '$acte_medical'";
        $act = $this->get("acte_pose", $condition);

        if (count($act) == 0 || $act == null) {
            $this->errors = ['Acte non trouvé'];
            return false;
        }
        $daoExt = $this->InstanceExtra();
        $r = $daoExt->add($data);
        if ($r == false) {
            $this->errors = $daoExt->getErrors();
        }
        return $r;
    }

    public function getRecommandListExtra($acte_medical) {

        $daoExt = $this->InstanceExtra();
        $r = $daoExt->getRecommandListExtra($acte_medical);
        if ($r == null) {
            $this->errors = $daoExt->getErrors();
        }
        return $r;
    }

    public function getRecommandExtra($acte_medical) {

        $daoExt = $this->InstanceExtra();
        $r = $daoExt->getRecommandExtra($acte_medical);
        if ($r == null) {
            $this->errors = $daoExt->getErrors();
        }
        return $r;
    }

}
