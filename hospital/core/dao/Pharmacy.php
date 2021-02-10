<?php

namespace hospital\core\dao;

class Pharmacy extends \model\Model {

    public $idFacture;
    static public $TAUX;

    const TVA = 16;

    public function __construct($options = array()) {
        parent::__construct($options);
        self::getTaux();
    }

    static function getTaux() {
        $condition['order'] = " taux.date DESC ";
        $model = \model\Model::getInstance();
        self::$TAUX = $model->get("taux", $condition)[0]->taux;
        unset($model);
        return self::$TAUX;
    }

    public function add($datas = []) {
        extract($datas);
        $this->valideData($lib, "#^\w{2,50}$#", "La désignation ne peut être vide et doit contenir au minimum 2 et au maximum 50 caractères", "La désignation produit");
        //$this->valideData($quantite, "#^(\d){1,11}$#", "La quantité de produit à ajouter ne  doit être vide et ne peut contenir que suivi chiffres ", "Quantité");
        $this->valideData($qtealert, "#^[\d.]{1,11}$#", "La quantité alert de produit à ajouter ne  doit être vide et ne peut contenir que suivi chiffres ", "Quantité alerte");
        //$this->valideData($prixachat, "#^(\d){1,}$#", "Le prix de produit à ajouter ne  doit être vide et ne peut contenir que des chiffres ", "Le prix d'achat");
        $this->valideData($valunite, "#^(\d){1,}$#", "La valeur par unité de consommation du produit à ajouter ne  doit être vide et ne peut contenir que des chiffres ", "Unite par consommation", 'prix');
        $this->valideData($prixvente, "#^[\d.]{1,}$#", "Le prix de vente de produit à ajouter ne  doit être vide et ne peut contenir que des chiffres ", "le Prix de vente");
        $this->valideData($dateFab, "#^[0-9]{4}-(0[1-9]| 1[0-2])-[0-9]{2}$#", "La date de fabrication ne doit être vide et doit respecter le format (AAAA/MM/JJ) Ex: 2019,10,15", "date de fabrication");
        $this->valideData($dateExp, "#^[0-9]{4}-(0[1-9]| 1[0-2])-[0-9]{2}$#", "La date de fabrication ne doit être vide et doit respecter le format (AAAA/MM/JJ) Ex: 2019,10,15", "date de fabrication");
        $this->valideData($codebar, "#^[0-9]{2,}$#", "Le codebar doit être vide et ne doit  contenir que des chiffres", "Code bar", false);
        if (strlen($category) > 0) {
            $flag = $this->getCategory(" WHERE category_produit.id ='" . $category . "'");
            if (count($flag) < 1) {
                array_push($this->errors, "Catégorie produit non trouvée");
            }
        } else {
            array_push($this->errors, "Vous n'avez pas choisi Catégorie produit");
        }
        if (isset($conservation) && strlen($conservation) > 0) {
            $condition['where'] = " WHERE id=$conservation ";
            $flag = $this->getConservation($condition);
            if (count($flag) < 1) {
                array_push($this->errors, "Le condionnement du produit choisi n'est pas retrouvé dans le système, please de réessayer et cette erreur persiste prière de signaler l'administrateur du système");
            }
            unset($condition);
        } else {
            $condition = [];
            array_push($this->errors, "Vous n'avez pas choisi le condionnement du produit");
        }
        if (strlen($unite) > 0 && isset($unite)) {
            $condition['where'] = " WHERE id=$unite ";
            $flag = $this->getUniteConsommation($condition);
            unset($condition);
            if (count($flag) < 1) {
                array_push($this->errors, "L'unité de consommation choisie n'est pas retrouvé dans le système, please de réessayer et cette erreur persiste prière de signaler l'administrateur du système");
            }
        } else {
            $condition = [];
            array_push($this->errors, "Vous n'avez pas choisi l'unité de consommation du produit");
        }


        if (count($this->errors) > 0) {
            return false;
        } else {
            $data = new \stdClass();
            $data->lib = $lib;
            $data->unite = $unite;
            $data->forme = $forme;
            $data->valunite = $valunite;
            $data->conservation = $conservation;
            $data->prixvente = $prixvente;
            //$data->prixachat = $prixachat;
            $data->codebar = $codebar;
            $data->dateFab = $dateFab;
            $data->dateExp = $dateExp;
            $data->category = $category;
            $data->qtealert = $qtealert;
            if (isset($imgproduit) && !empty($imgproduit)) {
                $data->idimg = $imgproduit;
            }
            $this->input($data, "produit");
            return true;
        }
    }

    public function edit($datas = []) {
        extract($datas);
        $this->valideData($lib, "#^.{2,50}$#", "La désignation ne peut être vide et doit contenir au minimum 2 et au maximum 50 caractères", "La désignation produit");
        //$this->valideData($quantite, "#^(\d){1,11}$#", "La quantité de produit à ajouter ne  doit être vide et ne peut contenir que suivi chiffres ", "Quantité");
        $this->valideData($qtealert, "#^(\d){1,11}$#", "La quantité alert de produit à ajouter ne  doit être vide et ne peut contenir que suivi chiffres ", "Quantité alerte");
        //$this->valideData($prixachat, "#^(\d){1,}$#", "Le prix de produit à ajouter ne  doit être vide et ne peut contenir que des chiffres ", "Le prix d'achat");
        $this->valideData($prixvente, "#^[\d.]{1,}$#", "Le prix de vente de produit à ajouter ne  doit être vide et ne peut contenir que des chiffres ", "le Prix de vente");
        $this->valideData($dateFab, "#^[0-9]{4}-(0[1-9]| 1[0-2])-[0-9]{2}$#", "La date de fabrication ne doit être vide et doit respecter le format (AAAA/MM/JJ) Ex: 2019,10,15", "date de fabrication");
        $this->valideData($dateExp, "#^[0-9]{4}-(0[1-9]| 1[0-2])-[0-9]{2}$#", "La date de fabrication ne doit être vide et doit respecter le format (AAAA/MM/JJ) Ex: 2019,10,15", "date de fabrication");
        $this->valideData($codebar, "#^[0-9]{2,}$#", "Le codebar doit être vide et ne doit  contenir que des chiffres", "Code bar", false);
        $this->valideData($valunite, "#^(\d){1,}$#", "La valeur par unité de consommation du produit à ajouter ne  doit être vide et ne peut contenir que des chiffres ", "Unite par consommation", 'prix');

        if (strlen($category) > 0) {
            $flag = $this->getCategory(" WHERE category_produit.id ='" . $category . "'");
            if (count($flag) < 1) {
                array_push($this->errors, "Catégorie produit non trouvée");
            }
        } else {
            array_push($this->errors, "Vous n'avez pas choisi Catégorie produit");
        }
        if (isset($conservation) && strlen($conservation) > 0) {
            $condition['where'] = " WHERE id=$conservation ";
            $flag = $this->getConservation($condition);
            if (count($flag) < 1) {
                array_push($this->errors, "Le condionnement du produit choisi n'est pas retrouvé dans le système, please de réessayer et cette erreur persiste prière de signaler l'administrateur du système");
            }
            unset($condition);
        } else {
            $condition = [];
            array_push($this->errors, "Vous n'avez pas choisi le condionnement du produit");
        }
        if (strlen($unite) > 0 && isset($unite)) {
            $condition['where'] = " WHERE id=$unite ";
            $flag = $this->getUniteConsommation($condition);
            unset($condition);
            if (count($flag) < 1) {
                array_push($this->errors, "L'unité de consommation choisie n'est pas retrouvé dans le système, please de réessayer et cette erreur persiste prière de signaler l'administrateur du système");
            }
        } else {
            $condition = [];
            array_push($this->errors, "Vous n'avez pas choisi l'unité de consommation du produit");
        }
        if (count($this->errors) > 0) {
            return false;
        } else {
            $data = new \stdClass();
            $data->lib = $lib;
            $data->unite = $unite;
            $data->forme = $forme;
            $data->valunite = $valunite;
            $data->conservation = $conservation;
            $data->prixvente = $prixvente;
            $data->codebar = $codebar;
            $data->dateFab = $dateFab;
            $data->dateExp = $dateExp;
            $data->category = $category;
            $data->qtealert = $qtealert;

            if (isset($imgproduit) && !empty($imgproduit)) {
                $data->idimg = $imgproduit;
            }
            $condition['where'] = " WHERE produit.id = '" . $datas['idproduit'] . "'";
            $this->update($condition, $data, "produit");
            return true;
        }
    }

    public function del($id) {
        $condition['where'] = " WHERE id = $id";
        $prod = $this->get("produit", $condition);
        if (count($prod) > 0) {
            return $this->delete("id", $id, "produit");
        } else {
            return false;
        }
    }

    public function delvente_ligne($id) {
        $condition['where'] = " WHERE id_approvisionner = $id";
        $prod = $this->get("approvisionnement_ligne", $condition);
        if (count($prod) > 0) {
            return $this->delete("id_approvisionner", $id, "approvisionnement_ligne");
        } else {
            return false;
        }
    }

    public function dellivraison_ligne($id) {
        $condition['where'] = " WHERE idlivraison = $id";
        $prod = $this->get("livraison_ligne", $condition);
        if (count($prod) > 0) {
            return $this->delete("idlivraison", $id, "livraison_ligne");
        } else {
            return false;
        }
    }

    public function delApprov($id) {
        $condition['where'] = " WHERE id = $id";
        $this->startTransaction();
        $prod = $this->get("approvisionner", $condition);
        if (count($prod) > 0) {
            $r = $this->delvente_ligne($id);
            $this->delete("id", $id, "produit");
            $this->commitTransaction();
            return true;
        } else {
            $this->rollback();
            return false;
        }
    }

    public function delLivraison($id) {
        $condition['where'] = " WHERE id_livraison = $id";
        $this->startTransaction();
        $prod = $this->get("livraison", $condition);
        if (count($prod) > 0) {
            $r = $this->dellivraison_ligne($id);
            $this->delete("id_livraison", $id, "livraison");
            $this->commitTransaction();
            return true;
        } else {
            $this->rollback();
            return false;
        }
    }

    public function addFournisseur($data = []) {
        extract($data);
        $this->valideData($nomfournisseur, "#^.{2,50}$#", "Le nom du fournisseur ne peut être vide et doit contenir au minimum 2 et au maximum 50 caractères", "Nom fournieeur");
        $this->valideData($tel, "#^\+(\d){1,4}(\d){10}$#", "Le numéro de téléphone doit être vide et doit respecter le format (+CODE CCCCCCCCCC) suivi des chiffres ", "Téléphone");
        $this->valideData($email, "#^[\w-._]+@[\w.-]+\.[a-z]{2,}$#i", "L'Adresse email doit être vide et doit respecter le format ([a-z] host.domaine) Exemple  : exemple@exemple.com", "Adresse email", false);
        $this->valideData($adresse, "#^(.{1,100})$#", "L'adresse ne doit être vide et doit contenir que les lettres [A-Za-z0-9] ces caractères - _ , / ", "Adresse");
        if (count($this->errors) > 0) {
            return false;
        } else {
            $data = new \stdClass();
            $data->nomfournisseur = $nomfournisseur;
            $data->email = $email;
            $data->tel = $tel;
            $data->adresse = $adresse;
            $this->input($data, "fournisseur");
            return true;
        }
    }

    public function addCategory($data = []) {
        extract($data);
        $this->valideData($lib, "#^.{2,50}$#", "Le libellé ne peut être vide et doit contenir au minimum 2 et au maximum 50 caractères", "Libellé");
        if (count($this->errors) > 0) {
            return false;
        } else {
            $data = new \stdClass();
            $data->lib = $lib;
            $this->input($data, "category_produit");
            return true;
        }
    }

    public function getCategory($conditionaddivitive = "") {
        $sql = "SELECT `produit`.*, `category_produit`.`lib` AS `catprod`, COUNT(produit.category) as nProd, category_produit.id as idcategory, category_produit.lib as category
                FROM `category_produit`
                LEFT JOIN `produit` ON `produit`.`category` = `category_produit`.`id`";
        if (isset($conditionaddivitive) && !empty($conditionaddivitive)) {
            $sql .= $conditionaddivitive;
        }
        $sql .= " GROUP BY category_produit.id";
        $stm = $this->cnx->query($sql);
        return $stm->fetchAll(\PDO::FETCH_OBJ);
    }

    public function getUniteConsommation($conditionaddivitive = []) {
        $condition = [];
        if (count($conditionaddivitive) > 0) {
            $condition = array_merge($condition, $conditionaddivitive);
        }
        $condition['order'] = " id ASC ";
        return $this->get('unite_consommation', $condition);
    }

    public function getForme($conditionaddivitive = []) {
        $condition = [];
        if (count($conditionaddivitive) > 0) {
            $condition = array_merge($condition, $conditionaddivitive);
        }
        $condition['order'] = " id ASC ";
        return $this->get('forme', $condition);
    }

    public function getConservation($conditionaddivitive = []) {
        $condition = [];
        if (count($conditionaddivitive) > 0) {

            $condition = array_merge($condition, $conditionaddivitive);
        }
        $condition['order'] = " lib ASC ";
        return $this->get('conservation', $condition);
    }

    public function getFournisseur($conditionadditive = []) {
        $condition['order'] = " fournisseur.nomfournisseur ASC";
        $condition = array_merge($condition, $conditionadditive);
        return $this->get("fournisseur", $condition);
    }

    public function getProduct($conditionadditive = []) {
        $condition['fields'] = "`produit`.*, `category_produit`.`id` AS `idcategory`, `category_produit`.`lib` AS `libcategory`, "
                . "`download`.`filename`, `download`.`type`, unite_consommation.lib AS libunite,unite_consommation.id idunite, "
                . "conservation.lib AS libconservation, conservation.id as idconservation, forme.lib as forme, forme.id as idforme ";
        $condition['joins'] = [
            'tables' => ['download', 'category_produit', 'unite_consommation', 'conservation', 'forme'],
            'tableBase' => ['produit', 'produit', 'produit', 'produit', 'produit'],
            'typeJointure' => ['LEFT', 'LEFT', 'LEFT', 'LEFT', 'LEFT'],
            'keys' => ['id_download', 'id', 'id', 'id', 'id'],
            'primaryKeys' => ['idimg', 'category', 'unite', 'conservation', 'forme']
        ];
        if (count($conditionadditive) > 0) {
            $condition = array_merge($condition, $conditionadditive);
        }

        $condition['order'] = " produit.lib ASC";
        return $this->paginate("produit", $condition, 50);
    }

    public function Product($Id = "") {
        $condition['fields'] = "`produit`.*, `category_produit`.`id` AS `idcategory`, `category_produit`.`lib` AS `libcategory`, "
                . "`download`.`filename`, `download`.`type`, unite_consommation.lib AS libunite,unite_consommation.id idunite, "
                . "conservation.lib AS libconservation, conservation.id as idconservation, forme.lib as forme, forme.id as idforme ";
        $condition['joins'] = [
            'tables' => ['download', 'category_produit', 'unite_consommation', 'conservation', 'forme'],
            'tableBase' => ['produit', 'produit', 'produit', 'produit', 'produit'],
            'typeJointure' => ['LEFT', 'LEFT', 'LEFT', 'LEFT', 'LEFT'],
            'keys' => ['id_download', 'id', 'id', 'id', 'id'],
            'primaryKeys' => ['idimg', 'category', 'unite', 'conservation', 'forme']
        ];
        $condition['where'] = " WHERE produit.id = '$Id'";
        $condition['order'] = " produit.lib ASC";
        return $this->get("produit", $condition);
    }

    public function searchProduct($motif = "") {
        $condition['fields'] = "`produit`.*, `category_produit`.`id` AS `idcategory`, `category_produit`.`lib` AS `libcategory`, "
                . "`download`.`filename`, `download`.`type`, unite_consommation.lib AS libunite,unite_consommation.id idunite, "
                . "conservation.lib AS libconservation, conservation.id as idconservation, forme.lib as forme, forme.id as idforme ";
        $condition['joins'] = [
            'tables' => ['download', 'category_produit', 'unite_consommation', 'conservation', 'forme'],
            'tableBase' => ['produit', 'produit', 'produit', 'produit', 'produit'],
            'typeJointure' => ['LEFT', 'LEFT', 'LEFT', 'LEFT', 'LEFT'],
            'keys' => ['id_download', 'id', 'id', 'id', 'id'],
            'primaryKeys' => ['idimg', 'category', 'unite', 'conservation', 'forme']
        ];
        $condition['where'] = " WHERE produit.id LIKE '%$motif%' OR produit.lib LIKE '%$motif%' OR category_produit.lib LIKE '%$motif%' OR category_produit.id LIKE '%$motif%' ";
        $condition['order'] = " produit.lib ASC";
        return $this->get("produit", $condition);
    }

    public function initApprov($data = []) {
        extract($data);
        $this->valideData($refdoc, "#^.{1,}$#", "La référence document (facture fournisseur, bon de livraison ou d'autres pieces justificatives ne  doit être vide et ne peut contenir que les lettres & chiffres ", "Référence documents");
        $this->valideData($date, "#^[0-9]{4}-(0[1-9]| 1[0-2])-[0-9]{2}$#", "La date d'aprovisionnement ne doit être vide et doit respecter le format (AAAA/MM/JJ) Ex: 2019,10,15", "date d'aprovisionnement");
        $condition['where'] = " WHERE fournisseur.id ='" . $idfournisseur . "'";
        $flag = $this->getFournisseur($condition);
        if (count($flag) < 1) {
            array_push($this->errors, "Fournisseur non trouvé, veuillez vérifier que vous l'avez bien sélectionné");
        }
        if (count($this->errors) > 0) {
            return false;
        } else {
            $data = new \stdClass();
            $data->date = $date;
            $data->idfournisseur = $idfournisseur;
            $data->refdoc = $refdoc;
            $data->tauxapplique = $_SESSION['TAUX'];
            $this->input($data, "approvisionner");
            return true;
        }
    }

    public function initLivraison($data = []) {
        extract($data);

        //\composants\Utilitaire::debug($data, true);
        $condition['where'] = " WHERE agent.id ='" . $idagent . "'";
        $flag = $this->get("agent", $condition);
        if (count($flag) < 1) {
            array_push($this->errors, "Agent non trouvé, veuillez vérifier que vous l'avez bien sélectionné");
        }
        if ($selectdestination == 1) {
            if (!isset($acte_medical) || empty($acte_medical)) {
                array_push($this->errors, "Vous n'avez pas sélectionner un acte qui identifie le patient où les produits seront partis ");
            }
        }
        if (count($this->errors) > 0) {
            return false;
        } else {
            try {
                $datas = new \stdClass();
                $datas->id_agent = $idagent;
                 if ($selectdestination == 1) {
                     $datas->destination = $selectdestination;
                 }
                
                $datas->tauxapplique = $_SESSION['TAUX'];
                $datas->id_hopital = $_SESSION['user']['idhopital'];
                $datas->froms = $_SESSION['user']['agent'];
                $this->startTransaction();
                $r = $this->input($datas, "livraison");

                $lid = $this->lastId();
                \composants\Utilitaire::debug($lid);
                if ($selectdestination == 1) {
                    if ($r == true && $lid != null) {
                        $datLivPatient = new \stdClass();
                        $datLivPatient->fk_acte = $acte_medical;
                        $datLivPatient->fk_agent_pharmacie = $_SESSION['user']['agent'];
                        $datLivPatient->fk_agent_receveur = $idagent;
                        $datLivPatient->fk_hopital = $_SESSION['user']['idhopital'];
                        $datLivPatient->fk_patient = $patient;
                        $datLivPatient->observation = $observation;
                        $datLivPatient->fk_livraison = $lid;
                        $rr = $this->input($datLivPatient, "livraison_patient");
                        if ($rr == true) {
                            $this->commitTransaction();
                            return $lid;
                        } else {
                            $this->rollback();
                        }
                    }
                } else {
                    $this->commitTransaction();
                }

                return $lid;
            } catch (\Exception $ex) {
                \composants\Utilitaire::debug($ex, true);
                try {
                    $this->rollback();
                } catch (\Exception $eee) {
                    
                }
                array_push($this->errors, $ex->getMessage());
                return null;
            }
        }
    }

    public function getApprovionnement($conditionadditive = []) {
        $condition['fields'] = " approvisionner.*, fournisseur.id as idfournis, nomfournisseur, adresse, tel, email";
        $condition['joins'] = [
            'tables' => ['fournisseur'],
            'tableBase' => ['approvisionner'],
            'typeJointure' => ['INNER'],
            'keys' => ['id'],
            'primaryKeys' => ['idfournisseur']
        ];
        $condition = array_merge($condition, $conditionadditive);
        return $this->get("approvisionner", $condition);
    }

    public function getLivraison($conditionadditive = []) {
        $condition['fields'] = " `livraison`.`id_livraison`, `agent`.`id`, `agent`.`nom`, `agent`.`prenom`, `agent`.`postnom`, tauxapplique, "
                . "`agent`.`fonction` AS `idfonction`, `fonction`.`libelle` AS `fonction`, `livraison`.`datelivraison`, "
                . "`livraison`.`id_agent` AS `agentlivre`, livraison.destination, livraison.id_hopital as hopliv, livraison_patient.id  as idlip, livraison_patient.date_Create as datelivp, livraison_patient.fk_agent_pharmacie, livraison_patient.fk_agent_receveur as receveur, livraison_patient.fk_livraison, livraison_patient.fk_acte, livraison_patient.statut statuliv, livraison_patient.date_payement ";
        $condition['joins'] = [
            'tables' => ['agent', 'fonction', 'livraison_patient'],
            'tableBase' => ['livraison', 'agent', 'livraison'],
            'typeJointure' => ['INNER', 'INNER', 'LEFT'],
            'keys' => ['id', 'idFonction', 'fk_livraison'],
            'primaryKeys' => ['id_agent', 'fonction',  'id_livraison']
        ];
        $condition = array_merge($condition, $conditionadditive);
        return $this->get("livraison", $condition);
    }

    public function getListLivraison($conditionadditive = []) {
        $condition['fields'] = " `livraison`.`id_livraison`, `agent`.`id`, `agent`.`nom`, `agent`.`prenom`, `agent`.`postnom`, tauxapplique, "
                . "`agent`.`fonction` AS `idfonction`, `fonction`.`libelle` AS `fonction`, `livraison`.`datelivraison`, "
                . "`livraison`.`id_agent` AS `agentlivre`";
        $condition['joins'] = [
            'tables' => ['agent', 'fonction'],
            'tableBase' => ['livraison', 'agent'],
            'typeJointure' => ['INNER', 'INNER'],
            'keys' => ['id', 'idFonction'],
            'primaryKeys' => ['id_agent', 'fonction']
        ];
        $condition['order'] = " livraison.datelivraison DESC";
        $condition = array_merge($condition, $conditionadditive);
        return $this->paginate("livraison", $condition);
    }

    public function searchLivraison($motif = "") {
        $condition['fields'] = " `livraison`.`id_livraison`, `agent`.`id`, `agent`.`nom`, `agent`.`prenom`, `agent`.`postnom`, tauxapplique, "
                . "`agent`.`fonction` AS `idfonction`, `fonction`.`libelle` AS `fonction`, `livraison`.`datelivraison`, "
                . "`livraison`.`id_agent` AS `agentlivre`";
        $condition['joins'] = [
            'tables' => ['agent', 'fonction'],
            'tableBase' => ['livraison', 'agent'],
            'typeJointure' => ['INNER', 'INNER'],
            'keys' => ['id', 'idFonction'],
            'primaryKeys' => ['id_agent', 'fonction']
        ];
        $condition['where'] = " WHERE livraison.id_livraison LIKE '%$motif%' OR agent.id LIKE '%$motif%' ";
        $condition['order'] = " livraison.datelivraison DESC";
        return $this->get("livraison", $condition);
    }

    public function getListApprovisionnement($conditionadditive = []) {
        $condition['fields'] = " `approvisionner`.`id` AS `idapprovisionner`, `approvisionner`.`date`, `approvisionner`.`idfournisseur`, "
                . "`approvisionner`.`refdoc`, `approvisionnement_ligne`.*, `fournisseur`.`nomfournisseur`, `produit`.`lib` AS `designation`, "
                . "`produit`.`quantite` AS `qtestock`, `produit`.`category` AS `idcategory`, `produit`.`prixachat` AS `coutachat`, "
                . "`produit`.`prixvente` AS `pvente`, `produit`.`dateFab`, `produit`.`dateExp`, COUNT(approvisionnement_ligne.id) as nProduit";
        $condition['joins'] = [
            'tables' => ['fournisseur', 'approvisionnement_ligne', "produit", "category_produit"],
            'tableBase' => ['approvisionner', 'approvisionner', 'approvisionnement_ligne', "produit"],
            'typeJointure' => ['INNER', "LEFT", 'INNER', 'INNER'],
            'keys' => ['id', 'id_approvisionner', "id", 'id'],
            'primaryKeys' => ['idfournisseur', "id", "id_produit", "category"]
        ];
        $condition = array_merge($condition, $conditionadditive);
        $condition['order'] = " approvisionner.date DESC";
        return $this->get("approvisionner", $condition);
    }

    public function searchSale($motif = "") {
        $sql = "SELECT `vente`.`id` AS `idvente`, `vente`.`date` AS `datevente`, `vente_ligne`.`id_vente_ligne`, "
                . "(vente_ligne.qte * produit.prixvente) AS total, `vente_ligne`.`id_vente`, `vente_ligne`.`id_product` AS `idproductbuy`, "
                . "`vente_ligne`.`qte` AS `qtebuy`, `produit`.`prixachat` AS `coutachat`, `produit`.`prixvente`, `produit`.`lib` AS `designation`, "
                . "`produit`.`quantite` AS `stock`, `produit`.`dateExp`, `produit`.`category` AS `idcategory`, "
                . "`category_produit`.`lib` AS `categoryproduit` "
                . "FROM vente INNER JOIN vente_ligne ON vente_ligne.id_vente = vente.id "
                . "INNER JOIN produit ON produit.id = vente_ligne.id_product "
                . "INNER JOIN category_produit ON category_produit.id = produit.category ";

        $sql .= " WHERE vente.id LIKE '%$motif%' ";
        $sql .= " GROUP BY vente_ligne.id_vente ORDER BY vente.date DESC ";
        $stm = $this->cnx->query($sql);
        return $stm->fetchAll(\PDO::FETCH_OBJ);
    }

    public function getApprovisionnementItem($conditionadditive = []) {
        $condition['fields'] = " `approvisionner`.`id` AS `idapprovisionner`, `approvisionner`.`date`, `approvisionner`.`idfournisseur`, approvisionner.tauxapplique,"
                . "`approvisionner`.`refdoc`, `approvisionnement_ligne`.*, `fournisseur`.`nomfournisseur`, `produit`.`lib` AS `designation`, "
                . "`produit`.`quantite` AS `qtestock`, `produit`.`category` AS `idcategory`, `produit`.`prixachat` AS `coutachat`, "
                . "`produit`.`prixvente` AS `pvente`, `produit`.`dateFab`, `produit`.`dateExp`";
        $condition['joins'] = [
            'tables' => ['approvisionner', 'fournisseur', "produit", "category_produit"],
            'tableBase' => ['approvisionnement_ligne', 'approvisionner', 'approvisionnement_ligne', "produit"],
            'typeJointure' => ['INNER', "LEFT", 'INNER', 'INNER'],
            'keys' => ['id', 'id', "id", 'id'],
            'primaryKeys' => ["id_approvisionner", 'idfournisseur', "id_produit", "category"]
        ];
        $condition = array_merge($condition, $conditionadditive);
        $condition['order'] = " approvisionner.date DESC";
        return $this->get("approvisionnement_ligne", $condition);
    }

    public function getlivraisonItem($conditionadditive = []) {
        $condition['fields'] = " `livraison`.`id_livraison`, `livraison`.`datelivraison`, `livraison`.`id_agent` AS `agentlivre`, `"
                . "livraison_ligne`.`id_produit` AS `idproduitlivre`, `livraison_ligne`.`qtelivre`, `livraison_ligne`.`idlivraison`, "
                . "`produit`.`lib` AS `produitlivre`, `produit`.`prixachat` AS `coutachat`, `produit`.`prixvente`, "
                . "`produit`.`quantite` AS `qtestock`, `produit`.`dateExp`, `produit`.`category`, `category_produit`.`lib` AS `category`, livraison_ligne.statut as statutprov";
        $condition['joins'] = [
            'tables' => ['livraison', "produit", "category_produit"],
            'tableBase' => ['livraison_ligne', 'livraison_ligne', "produit"],
            'typeJointure' => ['INNER', 'INNER', 'INNER'],
            'keys' => ['id_livraison', 'id', "id"],
            'primaryKeys' => ["idlivraison", 'id_produit', "category"]
        ];
        $condition = array_merge($condition, $conditionadditive);
        $condition['order'] = " livraison.datelivraison DESC";
        return $this->get("livraison_ligne", $condition);
    }
    
    public function getlivraisonItemByLivraisonByActe($conditionadditive = []) {
        $condition['fields'] = " `livraison`.`id_livraison`, `livraison`.`datelivraison`, `livraison`.`id_agent` AS `agentlivre`, `"
                . "livraison_ligne`.`id_produit` AS `idproduitlivre`, `livraison_ligne`.`qtelivre`, `livraison_ligne`.`idlivraison`, "
                . "`produit`.`lib` AS `produitlivre`, `produit`.`prixachat` AS `coutachat`, `produit`.`prixvente`, "
                . "`produit`.`quantite` AS `qtestock`, `produit`.`dateExp`, `produit`.`category`, `category_produit`.`lib` AS `category`, livraison_ligne.statut as statutprov, livraison_patient.* , livraison_patient.id idlivpat,livraison.tauxapplique ";
        $condition['joins'] = [
            'tables' => ['livraison', "produit", "category_produit", "livraison_patient"],
            'tableBase' => ['livraison_ligne', 'livraison_ligne', "produit", "livraison"],
            'typeJointure' => ['INNER', 'INNER', 'INNER', "INNER"],
            'keys' => ['id_livraison', 'id', "id", "fk_livraison"],
            'primaryKeys' => ["idlivraison", 'id_produit', "category", "id_livraison"]
        ];
        $condition = array_merge($condition, $conditionadditive);
        $condition['order'] = " livraison.datelivraison DESC";
        return $this->get("livraison_ligne", $condition);
    }

    public function addItemToAprovisionnement($id, $items = []) {
        $condition['where'] = " WHERE approvisionner.id = $id";
        $flag = $this->getApprovionnement($condition);
        if (count($flag) < 1) {
            array_push($this->errors, "Approvisionnement non trouvé");
            return false;
        }
        try {
            $sql = "INSERT INTO approvisionnement_ligne(id_produit, qte, prixachat, prixvente, id_approvisionner) VALUES ";
            for ($i = 0; $i < count($items['products']); $i++) {
                $s[] = '(' . $items['products'][$i] . ", " . $items['qteCmd'][$i] . ", " . $items['coutachat'][$i] . ", " . $items['prixvente'][$i] . "," . $id . ")";
            }
            $sql .= implode(", ", $s);
            $this->startTransaction();
            $this->cnx->exec($sql);
            $this->commitTransaction();
            return true;
        } catch (Exception $exc) {
            $this->errors[] = $exc->getMessage();
            $this->rollback();
            return false;
        }
    }

    public function addItemToLivraison($id, $items = []) {
        $condition['where'] = " WHERE livraison.id_livraison = $id";
        $flag = $this->getLivraison($condition);
        if (count($items['products']) < 1) {
            array_push($this->errors, "La carte vide. Veuillez remplir votre carte de livraison en y ajjoutant les produits");
            return false;
        }
        if (count($flag) < 1) {
            array_push($this->errors, "Livraison non trouvée");
            return false;
        }
        try {
            $sql = "INSERT INTO livraison_ligne(id_produit, qtelivre, idlivraison) VALUES ";
            for ($i = 0; $i < count($items['products']); $i++) {
                $s[] = '(' . $items['products'][$i] . ", " . $items['qteCmd'][$i] . "," . $id . ")";
            }
            $sql .= implode(", ", $s);
            $this->startTransaction();
            $this->cnx->exec($sql);
            $this->commitTransaction();
            return true;
        } catch (Exception $exc) {
            $this->errors[] = $exc->getMessage();
            $this->rollback();
            return false;
        }
    }

    public function facturer($items = []) {
        if (isset($items['products']) && count($items['products']) > 0) {
            try {
                $sql = "INSERT INTO vente(id_user, tauxapplique) VALUES ('" . $_SESSION['user']['agent'] . "', " . $_SESSION['TAUX'] . ")";
                $sql2 = " INSERT INTO vente_ligne( id_product, qte,id_vente) VALUES ";
                $this->startTransaction();
                $r = $this->cnx->exec($sql);
                if ($r == true) {
                    $this->idFacture = $this->lastId();
                }
                for ($i = 0; $i < count($items['products']); $i++) {
                    $s[] = '(' . $items['products'][$i] . ", " . $items['qteCmd'][$i] . "," . $this->lastId() . ")";
                }
                $sql2 .= implode(", ", $s);
                $this->cnx->exec($sql2);
                $this->commitTransaction();
                return true;
            } catch (Exception $ex) {
                $this->errors[] = $ex->getMessage();
                $this->rollback();
                return false;
            }
        } else {
            array_push($this->errors, "La carte est vide,... Veuillez d'en remplir avant la facturation");
            return false;
        }
    }

    public function getFactureItems($idFacture = "") {
        $condition['fields'] = "`vente`.`id` AS `idvente`, `vente`.`date` AS `datevente`, `vente_ligne`.`id_vente_ligne`, "
                . "`vente_ligne`.`id_vente`, `vente_ligne`.`id_product` AS `idproductbuy`, `vente_ligne`.`qte` AS `qtebuy`, "
                . "`produit`.`prixachat` AS `coutachat`, `produit`.`prixvente`, `produit`.`lib` AS `designation`, "
                . "`produit`.`quantite` AS `stock`, `produit`.`dateExp`, `produit`.`category` AS `idcategory`, "
                . "`category_produit`.`lib` AS `categoryproduit`";
        $condition['joins'] = [
            'tables' => ['vente', "produit", "category_produit"],
            'tableBase' => ['vente_ligne', 'vente_ligne', "produit"],
            'typeJointure' => ['INNER', "INNER", 'INNER'],
            'keys' => ['id', 'id', "id"],
            'primaryKeys' => ["id_vente", 'id_product', "category"]
        ];


        if (isset($idFacture) && !empty($idFacture)) {
            $condition['where'] = " WHERE vente.id = '$idFacture'";
        }
        return $this->get('vente_ligne', $condition);
    }

    public function getSalesListe($conditionadditive = "") {
        /* $condition['fields'] =  "`vente`.`id` AS `idvente`, `vente`.`date` AS `datevente`, `vente_ligne`.`id_vente_ligne`, "
          . "`vente_ligne`.`id_vente`, `vente_ligne`.`id_product` AS `idproductbuy`, `vente_ligne`.`qte` AS `qtebuy`, "
          . "`produit`.`prixachat` AS `coutachat`, `produit`.`prixvente`, `produit`.`lib` AS `designation`, "
          . "`produit`.`quantite` AS `stock`, `produit`.`dateExp`, `produit`.`category` AS `idcategory`, "
          . "`category_produit`.`lib` AS `categoryproduit`";
          $condition['joins'] = [
          'tables' => ['vente_ligne', "produit", "category_produit" ],
          'tableBase' => ['vente','vente_ligne',  "produit" ],
          'typeJointure' => ['INNER', "INNER",'INNER'],
          'keys' => ['id_vente','id', "id"],
          'primaryKeys' => ["id",'id_product',"category"]
          ];
         */
        $sql = "SELECT `vente`.`id` AS `idvente`, `vente`.`date` AS `datevente`, `vente_ligne`.`id_vente_ligne`, vente.tauxapplique,"
                . "(vente_ligne.qte * produit.prixvente) AS total, `vente_ligne`.`id_vente`, `vente_ligne`.`id_product` AS `idproductbuy`, "
                . "`vente_ligne`.`qte` AS `qtebuy`, `produit`.`prixachat` AS `coutachat`, `produit`.`prixvente`, `produit`.`lib` AS `designation`, "
                . "`produit`.`quantite` AS `stock`, `produit`.`dateExp`, `produit`.`category` AS `idcategory`, "
                . "`category_produit`.`lib` AS `categoryproduit` "
                . "FROM vente INNER JOIN vente_ligne ON vente_ligne.id_vente = vente.id "
                . "INNER JOIN produit ON produit.id = vente_ligne.id_product "
                . "INNER JOIN category_produit ON category_produit.id = produit.category ";
        if (isset($conditionadditive) && !empty($conditionadditive)) {
            $sql .= $conditionadditive;
        }
        $sql .= " GROUP BY vente_ligne.id_vente ORDER BY vente.date DESC ";
        $stm = $this->cnx->query($sql);
        return $stm->fetchAll(\PDO::FETCH_OBJ);
    }

    public function getSalesSum($conditionadditive = []) {
        $condition['fields'] = "`vente`.`id` AS `idvente`, `vente`.`date` AS `datevente`, `vente_ligne`.`id_vente_ligne`, (vente_ligne.qte * produit.prixvente) AS total,"
                . "`vente_ligne`.`id_vente`, `vente_ligne`.`id_product` AS `idproductbuy`, `vente_ligne`.`qte` AS `qtebuy`,vente.tauxapplique, "
                . "`produit`.`prixachat` AS `coutachat`, `produit`.`prixvente`, `produit`.`lib` AS `designation`,"
                . "`produit`.`quantite` AS `stock`, `produit`.`dateExp`, `produit`.`category` AS `idcategory`, "
                . "`category_produit`.`lib` AS `categoryproduit`";
        $condition['joins'] = [
            'tables' => ['vente_ligne', "produit", "category_produit"],
            'tableBase' => ['vente', 'vente_ligne', "produit"],
            'typeJointure' => ['INNER', "INNER", 'INNER'],
            'keys' => ['id_vente', 'id', "id"],
            'primaryKeys' => ["id", 'id_product', "category"]
        ];
        if (isset($conditionadditive) && !empty($conditionadditive)) {
            $condition = array_merge($condition, $conditionadditive);
        }
        $condition['groupBy'] = " vente_ligne.id_product ";
        $condition['order'] = " vente.date DESC ";
        return $this->get('vente', $condition);
    }

    public function getAllSalesListe($conditionadditive = []) {
        $condition['fields'] = "`vente`.`id` AS `idvente`, `vente`.`date` AS `datevente`, `vente_ligne`.`id_vente_ligne`, (vente_ligne.qte * produit.prixvente) AS total,"
                . "`vente_ligne`.`id_vente`, `vente_ligne`.`id_product` AS `idproductbuy`, `vente_ligne`.`qte` AS `qtebuy`,vente.tauxapplique, "
                . "`produit`.`prixachat` AS `coutachat`, `produit`.`prixvente`, `produit`.`lib` AS `designation`, "
                . "`produit`.`quantite` AS `stock`, `produit`.`dateExp`, `produit`.`category` AS `idcategory`, "
                . "`category_produit`.`lib` AS `categoryproduit`";
        $condition['joins'] = [
            'tables' => ['vente_ligne', "produit", "category_produit"],
            'tableBase' => ['vente', 'vente_ligne', "produit"],
            'typeJointure' => ['INNER', "INNER", 'INNER'],
            'keys' => ['id_vente', 'id', "id"],
            'primaryKeys' => ["id", 'id_product', "category"]
        ];
        if (isset($conditionadditive) && !empty($conditionadditive)) {
            $condition = array_merge($condition, $conditionadditive);
        }
        $condition['groupBy'] = " vente_ligne.id_vente ";
        $condition['order'] = " vente.date DESC ";
    }

}
