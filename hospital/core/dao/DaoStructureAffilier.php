<?php

namespace hospital\core\dao;

class DaoStructureAffilier extends \model\Model {

    public function setStructure(StructureAffilier $str) {
        $respond = false;
        try {

            $ps = $this->cnx->prepare("insert into structureAffilier(libelle,adresse,contacts) value(?,?,?)");
            $respond = $ps->execute(array($str->getLibelle(), $str->getAdresse(), $str->getContacts()));
        } catch (Exception $ex) {
            $respond = false;
        }
        return $respond;
    }

    public function getStructures() {
        $respond = null;

        try {

            $ps = $this->cnx->query("select * from structureAffilier");
            $respond = json_encode($ps->fetchAll(PDO::FETCH_ASSOC));
        } catch (Exception $th) {
            
        }

        return $respond;
    }

    public function getPersonnels($idStructure) {
        $respond = null;

        try {
            $ps = $this->cnx->prepare("select * from personnelstructureaffilier ps"
                    . " join structureAffilier sa on ps.idStructure=sa.idStructureAffil where sa.idStructureAffil=?");
            $ps->execute(array($idStructure));
            $respond = json_encode($ps->fetchAll(PDO::FETCH_ASSOC));
        } catch (Exception $th) {
            
        }

        return $respond;
    }

    public function getPersonnelStructureAffil($idPersonnelStructureAffil) {
        $respond = null;

        try {
            $ps = $this->cnx->prepare("select * from personneaffilierexterne where idPersonnelStructureAffilier=?");
            $ps->execute(array($idPersonnelStructureAffil));
            $respond = json_encode($ps->fetchAll(PDO::FETCH_ASSOC));
        } catch (Exception $th) {
            
        }

        return $respond;
    }

    public function getPersonnelByName($idStructure, $person) {
        $respond = null;

        try {
            $ps = $this->cnx->prepare("select * from personnelstructureaffilier ps"
                    . " join structureAffilier sa on ps.idStructure=sa.idStructureAffil where sa.idStructureAffil=? and ps.nom like('" . $person . "%')");
            $ps->execute(array($idStructure));
            $respond = json_encode($ps->fetchAll(PDO::FETCH_ASSOC));
        } catch (Exception $th) {
            
        }

        return $respond;
    }

    public function findStructure($str) {
        $respond = null;

        try {
            $ps = $this->cnx->prepare("select * from structureAffilier where libelle like('" . $str . "%')");
            $ps->execute();
            $respond = json_encode($ps->fetchAll(PDO::FETCH_ASSOC));
        } catch (Exception $th) {
            
        }

        return $respond;
    }

    public function add($data = [0]) {
        extract($data);
        $this->valideData($responsable, "#^[A-Z][A-Za-z-\s]{2,90}$#", "Le nom du responsable ne doit être vide et doit commencer par une Majuscule suivi des lettres miniscules maximum 30 caractères", "Responsable");
        $this->valideData($raisonSociale, "#^[A-Z][A-Za-z-\s]{2,50}$#", "La raison sociale ne doit être vide et doit commencer par une Majuscule suivi des lettres miniscules maximum 30 caractères", "Raison sociale");
        $this->valideData($telephone, "#^\+(\d){1,4}(\d){10}$#", "Le numéro de téléphone doit être vide et doit respecter le format (+CODE CCCCCCCCCC) suivi des chiffres ", "Téléphone");
        $this->valideData($email, "#^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$#i", "L'Adresse email ne doit être vide et doit respecter le format ([a-z] host.domaine) Exemple  : exemple@exemple.com", "Adresse email", false);
        //$this->valideData($email, "#^[\w-._]+@[\w.-]+\.[a-z]{2,}$#i", "L'Adresse email doit être vide et doit respecter le format ([a-z] host.domaine) Exemple  : exemple@exemple.com", "Adresse email", false);
        $this->valideData($adresse, "#^(\w){1,100}$#", "L'adresse ne doit être vide et doit contenir que les lettres [A-Za-z0-9] ces caractères - _ , / ", "Adresse");


        if (count($this->errors) > 0) {
            return false;
        } else {
            $data = new \stdClass();
            $data->responsable = $responsable;
            $data->raisonsociale = $raisonSociale;
            $data->adresse = $adresse;
            $data->contact = $telephone;
            return $this->input($data, "structureaffilier");
        }
    }

    public function addActes($data = []) {
        extract($data);

        if (count($this->errors) > 0) {

            return false;
        } else {
            if (isset($actes) && !empty($actes)) {
                $actArr = json_decode($actes);

                $condition['where'] = " where structureaffilier.id = " . $id;

                $structure = $this->get("structureaffilier", $condition);
                if ($structure != null && count($structure) > 0) {
                    $this->errors = [];
                    $this->startTransaction();


                    $condition['fields'] = " acte.id, category_acte.id as id_cat, category_acte.lib as category, acte.lib as acte, acte.prix, acte.prix_prive, acte.prix_conventionne, acte.prix_affilier ";
                    $condition['order'] = " category_acte.id";
                    $condition['joins'] = [
                        'tables' => ['category_acte', "structure_actes"],
                        'tableBase' => ['acte', "acte"],
                        'typeJointure' => ['INNER', 'INNER'],
                        'keys' => ['id', 'acte_id'],
                        'primaryKeys' => ['id_category', 'id']
                    ];

                    $acts = $condition['where'] = " WHERE structure_id = '" . $motif . "' AND acte.id_hopital_ac = " . htmlentities($_SESSION['user']['idhopital']) . " ";
                    if ($acts != null && count($acts) > 0) {
                        foreach ($acts as $act) {
                            if(in_array($act->id_act, $actArr)) {
                                array_search($act->id_act, $actArr);
                                
                            }
                        }
                    } else {
                        foreach ($actArr as $value) {
                            $data = new \stdClass();
                            $data->structure_id = $id;
                            $data->acte_id = $value;
                            $this->input($data, "structure_actes");
                        }
                        if ($this->errors != null && count($this->errors)) {
                            $this->rollback();
                            return false;
                        }
                    }
                    return $this->commitTransaction();
                } else {
                    array_push($this->errors, "Aucune structure n'a pas été trouvée");
                    return false;
                }
            }
        }
    }

    public function getMembers($conditionadditive = []) {
        $condition['joins'] = [
            'tables' => ['patient'],
            'tableBase' => ['structureaffilier'],
            'typeJointure' => ['LEFT',],
            'keys' => ['idStructure'],
            'primaryKeys' => ['id']
        ];
        $condition = array_merge($condition, $conditionadditive);
        return $this->paginate("structureaffilier", $condition);
    }

    public function del($id) {
        
    }

    public function edit($id, $data = array()) {
        
    }

}
