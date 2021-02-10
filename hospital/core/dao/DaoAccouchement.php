<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace hospital\core\dao;

/**
 * Description of DaoAccouchement
 *
 * @author brandonekoto
 */
class DaoAccouchement extends \model\Model {

    private $daoActe;
    private $daoPatient;

    //put your code here
    public function __construct($options = array()) {
        parent::__construct($options);
        $this->daoActe = new DaoActe();
        $this->daoPatient = new DaoPatient();
    }

    public function init($datas) {
        extract($datas);
        $condition['where'] = " Where id = '$acte_medical'";
        try {
            $act = $this->get("acte", $condition);
            unset($condition);
            $condition['where'] = " Where idPatient ='$patient'";
            $p = $this->get("patient", $condition);
            //\composants\Utilitaire::debug([$datas, $act, $p], true);
            $this->startTransaction();
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
                $r = $this->input($values, "acte_pose");
                if ($r == true) {
                    $acc = new \stdClass();
                    $acc->fk_accoucheuse = $patient;
                    $acteid = $this->lastId();
                    $acc->fk_acte = $acteid;
                    $rr = $this->input($acc, "accouchement");
                    //\
                    if ($rr == true) {
                        $i = ($this->lastId());
                        $this->commitTransaction();
                        return $acteid;
                    } else {
                        return false;
                    }
                } else {
                    $this->rollback();
                    array_push($this->errors, "Une erreur est surgie");
                    return false;
                }
            } else {
                $this->errors[] = "Veuillez sélectionner le patient et l'acte à conjuguer. Si l'erreur persiste c'est être une tentative de piratage. Please veuillez contacter MDE SERVICES IT";
                return false;
            }
        } catch (\Exception $e) {
            $this->rollback();
            array_push($this->errors, $e->getMessage());
            \composants\Utilitaire::debug($e);
            die();
            return false;
        }
    }

    public function add() {
        $body = json_decode(file_get_contents('php://input'));
        if (count(get_object_vars($body)) > 0) {
            if (property_exists($body, "acte")) {
                
            } else {
                array_push($this->errors, "Veuillez sélectionner l'acte");
            }
            if (property_exists($body, "babies") && count($body->babies) > 0) {
                
            } else {
                array_push($this->errors, "Veuillez ajouter au moins un bébé");
            }
            if (count($this->errors) == 0) {
                $this->startTransaction();

                //$accouchement->
                try {
                    $actes = $this->daoActe->getListActe($body->acte);
                    $conditions["where"] = " WHERE accouchement.fk_acte = '" . htmlentities($body->acte) . "'";
                    $act = $this->get("accouchement", $conditions);

                    if (count($actes) > 0 && count($act) > 0) {
                        $actes = $actes[0];
                        if ($actes->id_acte == 106) {

                            foreach ($body->babies as $b) {

                                extract((array) $b);
                                //\composants\Utilitaire::debug($urogen);
                                $this->valideData(trim($nom), "#^[A-Za-z\s-]{2,30}$#", "Le nom ne doit être vide et doit commencer par une Majuscule suivi des lettres miniscules maximum 30 caractères", "Nom");
                                $this->valideData(trim($postnom), "#^[A-Za-z\s-]{2,30}$#", "Le postnom ne doit être vide et doit commencer par une Majuscule suivi des lettres miniscules maximum 30 caractères", "Nom");
                                $this->valideData(trim($prenom), "#^[A-Za-z\s-]{2,30}$#", "Le prenom ne doit être vide et doit commencer par une Majuscule suivi des lettres miniscules maximum 30 caractères", "Nom");
                                $this->valideData($sexe, "#^M|F$#", "Le sexe ne doit être vide et Veuillez sélectionner un parmi ces choix (Masculin ou Féminin", "Sexe");
                                $this->valideData($autres, "#^.{1,5000}$#s", "Le texte d'anamnese ne doit être vide et doit être composé que des caractères ordinaire minimum 1 maximum 1000 caractères", "Anamnese", false);
                                $this->valideData($poids, "#^[\d]{1,3}$#", "Le poids ne doit être vide et doit être composé que des chiffres et le caractère POINT (.) est admis comme étant séparateur des décimaux maximum 5 caractères, l'unité de mesure est le centimètre (cm)", "Poids");
                                $this->valideData($t, "#^[0-9a-zA-Z.\,/]{1,5}$#", "La température ne doit être vide et doit être composé que des chiffres et le caractère POINT (.) est admis comme étant séparateur des décimaux", "température");
                                $this->valideData($fr, "#^[0-9A-Za-z.\,/]{1,5}$#", "La Fréquence respiratoire ne doit être vide et doit être composé que des chiffres et le caractère POINT (.) est admis comme étant séparateur des décimaux", "F.R");
                                $this->valideData($apgar, "#^[0-9A-Za-z.\,/]{1,5}$#", "L'APGAR ne doit être vide et doit être composé que des chiffres, lettres et le caractère POINT (.) sont admis ", "APGAR");
                                $this->valideData($pc, "#^[0-9A-Za-z\.,/]{1,5}$#", "Le PC ne doit être vide et doit être composé que des chiffres, lettres et le caractère POINT (.) sont admis ", "SPO2");
                                $this->valideData($taille, "#^[\d]{1,3}$#", "La taille ne doit être vide et doit être composé que des chiffres et le caractère POINT (.) est admis comme étant séparateur des décimaux", "Taille");
                                $this->valideData($groupe_sang, "#A|B|AB|O#i", "Le groupe sanguin n'est pas inséré ou n'est pas valide", "Groupe Sanguin", false);
                                $this->valideData($mode, "#^0|1$#", "Le mode ne doit être vide et Veuillez sélectionner un parmi ces choix (Normal ou Césarienne", "Mode");
                                $this->valideData($dureAccouchement, "#^(?:1[012]|0[0-9]):[0-5][0-9]$/#", "La durée doit respecter le format suivant HH:MM", "Durée de l'accouchement");
                                $this->valideData($heureAccouchement, "#^(?:1[012]|0[0-9]):[0-5][0-9]$/#", "La durée doit respecter le format suivant HH:MM", "Heure de l'accouchement");
                                $this->valideData($gestite, "#^.{1,5000}$#s", "La gestité ne doit être vide et doit être composé que des caractères ordinaire minimum 1 maximum 1000 caractères", "Gestité");
                                $this->valideData($parite, "#^.{1,5000}$#s", "La parité ne doit être vide et doit être composé que des caractères ordinaire minimum 1 maximum 1000 caractères", "Parité");
                                $this->valideData($diabete, "#^0|1$#", "Le diabète ne doit être vide et Veuillez sélectionner un parmi ces choix (Oui ou Non)", "Diabète");
                                $this->valideData($glycemie, "#^[0-9A-Za-z.\,/]{1,5}$#", "La glycémie ne doit être vide et doit être composé que des chiffres, lettres et le caractère POINT (.) sont admis ", "Glycémie");
                                $this->valideData($hta, "#^[0-9a-zA-Z.\,/]{1,20}$#", "Le HTA ne doit être vide et doit être composé que des chiffres et le caractère POINT (.) est admis comme étant séparateur des décimaux", "HTA");
                                $this->valideData($ta, "#^[0-9a-zA-Z.\,/]{1,20}$#", "Le ta ne doit être vide et doit être composé que des chiffres et le caractère POINT (.) est admis comme étant séparateur des décimaux", "TA");
                                $this->valideData($tbc, "#^[0-9a-zA-Z.\,/]{1,20}$#", "Le TBC ne doit être vide et doit être composé que des chiffres et le caractère POINT (.) est admis comme étant séparateur des décimaux", "TBC");
                                $this->valideData($tp, "#^[0-9a-zA-Z.\,/]{1,20}$#", "Le TP ne doit être vide et doit être composé que des chiffres et le caractère POINT (.) est admis comme étant séparateur des décimaux", "TP");
                                $this->valideData($t, "#^[0-9a-zA-Z.\,/]{1,20}$#", "Le T ne doit être vide et doit être composé que des chiffres et le caractère POINT (.) est admis comme étant séparateur des décimaux", "T");
                                $this->valideData($ddr, "#^[0-9a-zA-Z.\,/]{1,20}$#", "Le DDR ne doit être vide et doit être composé que des chiffres et le caractère POINT (.) est admis comme étant séparateur des décimaux", "DDR");
                                $this->valideData($cpn, "#^.{1,5000}$#s", "Le CPN ne doit être vide et doit être composé que des caractères ordinaire minimum 1 maximum 1000 caractères", "CPN");
                                $this->valideData($la, "#^.{1,5000}$#s", "Le texte d'anamnese ne doit être vide et doit être composé que des caractères ordinaire minimum 1 maximum 1000 caractères", "LA");
                                $this->valideData($urogen, "#^.{1,5000}$#s", "L'urogen ne doit être vide et doit être composé que des caractères ordinaire minimum 1 maximum 1000 caractères", "UROGEN");
                                $this->valideData($echo, "#^.{1,5000}$#s", "L'écho ne doit être vide et doit être composé que des caractères ordinaire minimum 1 maximum 1000 caractères", "ECHO");
                                $this->valideData($rpm, "#^.{1,5000}$#s", "Le RPM ne doit être vide et doit être composé que des caractères ordinaire minimum 1 maximum 1000 caractères", "RPM");
                                $this->valideData($teint, "#^[0-9a-zA-Z.\,/]{1,20}$#", "Le tein ne doit être vide et doit être composé que des chiffres et le caractère POINT (.) est admis comme étant séparateur des décimaux", "TEINT");
                                $this->valideData($conjonctives, "#^.{1,5000}$#s", "Les conjonctives ne doit être vide et doit être composé que des caractères ordinaire minimum 1 maximum 1000 caractères", "Les conjonctives");
                                $this->valideData($fc, "#^[0-9a-zA-Z.\,/]{1,20}$#", "La FC ne doit être vide et doit être composé que des chiffres et le caractère POINT (.) est admis comme étant séparateur des décimaux", "FC");
                                //$this->valideData($tension, "#^[0-9a-zA-Z.\,/]{1,20}$#", "La tension ne doit être vide et doit être composé que des chiffres et le caractère POINT (.) est admis comme étant séparateur des décimaux", "Tension");
                                $this->valideData($abdomen, "#^.{1,5000}$#s", "L'abdomen ne doit être vide et doit être composé que des caractères ordinaire minimum 1 maximum 1000 caractères", "Abdomen");
                                $this->valideData($ogf, "#^.{1,5000}$#s", "Les OGF ne doivent être vide et doit être composé que des caractères ordinaire minimum 1 maximum 1000 caractères", "Les OGF");
                                $this->valideData($vigilance, "#^.{1,5000}$#s", "La vigilance ne doit être vide et doit être composé que des caractères ordinaire minimum 1 maximum 1000 caractères", "Vigilance");
                                $this->valideData($motilite, "#^.{1,5000}$#s", "La motilité ne doit être vide et doit être composé que des caractères ordinaire minimum 1 maximum 1000 caractères", "Motilité");
                                $this->valideData($eri, "#^.{1,5000}$#s", "L'ERI ne doit être vide et doit être composé que des caractères ordinaire minimum 1 maximum 1000 caractères", "Eri");
                                $this->valideData($tonus_passif, "#^.{1,5000}$#s", "Le tonus passif ne doit être vide et doit être composé que des caractères ordinaire minimum 1 maximum 1000 caractères", "Le tonus passif");
                                $this->valideData($tonus_actif, "#^.{1,5000}$#s", "Le tonus actif ne doit être vide et doit être composé que des caractères ordinaire minimum 1 maximum 1000 caractères", "Le tonus actif");
                                $this->valideData($succion, "#^.{1,5000}$#s", "La succion deglutition ne doit être vide et doit être composé que des caractères ordinaire minimum 1 maximum 1000 caractères", "La succion deglutition");
                                $this->valideData($grasping, "#^.{1,5000}$#s", "Le grasping ne doit être vide et doit être composé que des caractères ordinaire minimum 1 maximum 1000 caractères", "Grasping");
                                $this->valideData($moro, "#^.{1,5000}$#s", "Le moro ne doit être vide et doit être composé que des caractères ordinaire minimum 1 maximum 1000 caractères", "Le moro");
                                $this->valideData($extension_croisee, "#^.{1,5000}$#s", "L'extension croisée ne doit être vide et doit être composé que des caractères ordinaire minimum 1 maximum 1000 caractères", "L'extension croisée");
                                $this->valideData($galand_incurvation, "#^.{1,5000}$#s", "Le galand d'incurvation ne doit être vide et doit être composé que des caractères ordinaire minimum 1 maximum 1000 caractères", "Galand incurvation");
                                //$this->valideData($urogen, "#^.{1,5000}$#s", "L'urogen ne doit être vide et doit être composé que des caractères ordinaire minimum 1 maximum 1000 caractères", "Urogen");
                                //\composants\Utilitaire::debug($_SESSION['user']['province']);
                                if (count($this->errors) > 0) {
                                    \composants\Utilitaire::debug($this->errors);
                                    $this->rollback();
                                    http_response_code(500);
                                    echo json_encode($this->errors);
                                    return false;
                                } else {
                                    $patient = new \stdClass();

                                    $patient->postnom = $postnom;
                                    $patient->prenom = $prenom;
                                    $patient->sexe = $sexe;

                                    $patient->age = $dateNaiss;
                                    $patient->typePatient = 0;
                                    $patient->etatCivil = "c";
                                    $patient->group_sanguin = $groupe_sang;
                                    $patient->id_hopital = $_SESSION['user']['idhopital'];
                                    $patient->id_property = $_SESSION['user']['property'];
                                    $patient->id_province = 'kin';
                                    $patient->statut = $statut;
                                    //$patient->groupe_sang = $groupe_sang;
                                    $nu = null;
                                    $nu .= strrev(ucfirst(substr(explode("-", $patient->age)[0], 0, 4)));
                                    $nu .= ucfirst(substr(explode("-", $patient->age)[1], 0, 2));
                                    $nu .= ucfirst(substr(explode("-", $patient->age)[2], 0, 2));
                                    $nu .= $this->translateInAsciiCode($nom);
                                    $nu .= $this->translateInAsciiCode($prenom);

                                    //$nu .= ucfirst(substr($data->nom, 0, 3));
                                    //$nu .= ucfirst(substr($data->prenom, 0, 3));


                                    $nu .= "-" . ucfirst(substr($_SESSION['user']['hopital'], 0, 3));
                                    $nu .= ucfirst(($_SESSION['user']['idhopital']));

                                    $nu .= "/" . (count($this->get("patient")) != null && is_numeric(count($this->get("patient"))) ? count($this->get("patient")) + 1 : 1);
                                    $nu .= "/" . ucfirst(substr(date("Y"), 0, -2));
                                    $patient->nu = $nu;

                                    $condition['fields'] = " max(numinterne) as max ";
                                    $condition['where'] = " where patient.nom LIKE '%" . substr($nom, 0, 1) . "' ";
                                    $maxp = $this->get("patient", $condition);
                                    if ($maxp != null && count($maxp) > 0) {
                                        $patient->numinterne = ($maxp[0]->max) + 1;
                                    } else {
                                        $patient->numinterne = 1;
                                    }

                                    $r = $this->input($patient, "patient");

                                    if ($r == true) {
                                        \composants\Utilitaire::debug([$act]);
                                        $baby = new \stdClass();
                                        $baby->fk_accouchement = $act[0]->id_accouchement;
                                        $baby->taille = $taille;
                                        $baby->apgar = $apgar;
                                        $baby->fk_patient_enf = $this->lastId();
                                        $baby->pc = $pc;
                                        $baby->poids = $poids;

                                        $baby->mode = $mode;
                                        $baby->heure = $heureAccouchement;
                                        $baby->duree = $dureAccouchement;
                                        $baby->gestite = $gestite;
                                        $baby->parite = $parite;
                                        $baby->sexe = $sexe;
                                        $baby->diabete = $diabete;
                                        $baby->glycemie = $glycemie;
                                        $baby->hta = $hta;
                                        $baby->ta = $ta;
                                        $baby->hiv = $hiv;
                                        //$baby->ivg = $ivg;
                                        $baby->tbc = $tbc;
                                        $baby->tp = $tp;
                                        $baby->t_num = $t;
                                        $baby->ddr = $ddr;
                                        $baby->cpn = $cpn;
                                        $baby->la = $la;
                                        $baby->urogen = $urogen;
                                        $baby->echo = $echo;
                                        $baby->rpm = $rpm;
                                        $baby->teint = $teint;
                                        $baby->conjonctives = $conjonctives;
                                        $baby->fc = $fc;
                                        $baby->fr = $fr;
                                        $baby->abdomen = $abdomen;
                                        $baby->ogf = $ogf;
                                        $baby->autres = $autres;
                                        $baby->vigilance = $vigilance;
                                        $baby->motilite = $motilite;
                                        $baby->eri = $eri;
                                        $baby->tonus_passif = $tonus_passif;
                                        $baby->tonus_actif = $tonus_actif;
                                        $baby->succion = $succion;
                                        $baby->grasping = $grasping;
                                        $baby->moro = $moro;
                                        $baby->extension_croisee = $extension_croisee;
                                        $baby->galand_incurvation = $galand_incurvation;
                                        $rb = $this->input($baby, "enfant_accouche");
                                        if ($rb != true) {
                                            array_push($this->errors, "Une erreur a surgi.");
                                            $this->rollback();
                                            //http_response_code(500);
                                            header('HTTP/1.1 500 Une erreur a surgi');
                                            echo json_encode($this->errors);
                                            return;
                                        }
                                    } else {
                                        array_push($this->errors, "Une erreur a surgi. ");
                                        $this->rollback();
                                        //http_response_code(500);
                                        header('HTTP/1.1 500 Une erreur a surgi');
                                        echo json_encode($this->errors);
                                    }
                                }
                            }
                            if (count($this->errors) > 0) {
                                array_push($this->errors, "Une erreur a surgi. ");
                                $this->rollback();
                                //http_response_code(500);
                                header('HTTP/1.1 500 Une erreur a surgi');
                                echo json_encode($this->errors);
                            } else {
                                $this->commitTransaction();
                            }
                        } else {
                            array_push($this->errors, "l'acte sélectionné n'est pas un acte d'accouchement");
                            //http_response_code(500);
                            header('HTTP/1.1 500 Une erreur a surgi');
                            echo json_encode($this->errors);
                            return;
                        }
                    } else {
                        array_push($this->errors, "Aucun n'acte n'a été trouvé. veuillez vous assurer que vous avez bien initialisé un acte d'accouchement");
                        //http_response_code(500);
                        header('HTTP/1.1 500 Une erreur a surgi');
                        echo json_encode($this->errors);
                        return;
                    }
                } catch (\Exception $e) {
                    \composants\Utilitaire::debug($e);
                    $this->rollback();
                    header('HTTP/1.1 500 ' . $e->getMessage());
                    return;
                }
            } else {
                
            }
        } else {
            
        }
    }

    public function getList() {
        $sql = "SELECT `id_accouchement`, `fk_accoucheuse`, `date_accouchee`, `fk_parent_declare`, `fk_medecin_accouche`, `fk_acte`, `nbre_enfant`, COALESCE(nbr, 0) as nbr, ap.*, acte.*, acte.id as idacte, p.*, `agent`.`id` AS `idagent`, `agent`.`nom` AS `nomagent`, `agent`.`prenom` AS `prenomagent`, "
                . "`fonction`.`libelle` AS `fonctionagent`
                FROM accouchement ac
                LEFT JOIN (
                        SELECT count(*) as nbr, enfant_accouche.fk_accouchement FROM enfant_accouche  GROUP BY fk_accouchement   
                ) as ea ON ea.fk_accouchement = ac.id_accouchement
                INNER JOIN acte_pose ap ON ap.id = ac.fk_acte
                INNER JOIN acte ON acte.id = ap.id_acte
                INNER JOIN patient p ON p.idpatient = ac.fk_accoucheuse INNER JOIN agent ON agent.id = ap.id_agent INNER JOIN fonction ON fonction.idfonction = agent.fonction ORDER BY ac.id_accouchement DESC";
        $req = $this->cnx->query($sql);
        return $req->fetchAll(\PDO::FETCH_OBJ);
    }
    
    public function getDetailByDetail($idacte) {
        $sql = "SELECT `id_accouchement`, `fk_accoucheuse`, `date_accouchee`, `fk_parent_declare`, `fk_medecin_accouche`, `fk_acte`, `nbre_enfant`, COALESCE(nbr, 0) as nbr, ap.*, acte.*, acte.id as idacte, p.*, `agent`.`id` AS `idagent`, `agent`.`nom` AS `nomagent`, `agent`.`prenom` AS `prenomagent`, "
                . "`fonction`.`libelle` AS `fonctionagent`
                FROM accouchement ac
                LEFT JOIN (
                        SELECT count(*) as nbr, enfant_accouche.fk_accouchement FROM enfant_accouche  GROUP BY fk_accouchement   
                ) as ea ON ea.fk_accouchement = ac.id_accouchement
                INNER JOIN acte_pose ap ON ap.id = ac.fk_acte
                INNER JOIN acte ON acte.id = ap.id_acte
                INNER JOIN patient p ON p.idpatient = ac.fk_accoucheuse INNER JOIN agent ON agent.id = ap.id_agent INNER JOIN fonction ON fonction.idfonction = agent.fonction WHERE ac.fk_acte = $idacte ORDER BY ac.id_accouchement DESC";
        $req = $this->cnx->query($sql);
        return $req->fetchAll(\PDO::FETCH_OBJ);
    }

    public function translateInAsciiCode($str) {

        $new = "";
        if (isset($str) && !empty($str)) {
            for ($i = 0; $i < strlen($str); $i++) {
                $new .= ord($str[$i]);
            }
        }

        return $new;
    }
    
    public function getEnfantByAccouchement($accouchement) {
        $condition['joins'] = [
                'tables' => ['download', 'enfant_accouche'],
                'tableBase' => ['patient', 'patient'],
                'typeJointure' => ['INNER', 'INNER'],
                'keys' => ['id_download', 'fk_patient_enf'],
                'primaryKeys' => ['id_avatar', "idpatient"]
            ];
        if(isset($accouchement) && !empty($accouchement)){
            $condition['where'] = " WHERE fk_accouchement = $accouchement AND id_hopital = " . htmlentities($_SESSION['user']['idhopital']) . " ";
        }else{
            $condition['where'] = " WHERE id_hopital = " . htmlentities($_SESSION['user']['idhopital']) . " ";
        }
        $condition['order'] = " patient.nom ASC ";
        return $this->get("patient", $condition);
    }
}
