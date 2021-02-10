<?php
    namespace hospital\core\dao;
    use model\Model;
    use model\DaoInterface;
    class Accounting extends Model{
        public function __construct($options = array()) {
            parent::__construct($options);
        }        
        public function add($data=[]) {
            extract($data);
            $this->valideData($type, "#1|2#", "Veuillez choisir le bon type, soit ENTREE soit SORTIE", "type");
            $this->valideData($montant, "#^[0-9.]$#", "Veuillez saisir le montant de l'opération soit pourrait être un nombre entier ou décimal. Le séparateur de décimal est la virgule et le millier n'a pas de séparateur", "montant");
            $this->valideData($motif, "#^.{1,50}#", "Veuillez saisir le motif de l'opération, ca doit être un text valide dont le maximum est 50 caractères", "motif");
            $this->valideData($observation, "#^.*$#s", "L'observation n'est pas obligatoire mais si vous l'ecrivez elle ne doit dépenser 1000caractères", "Observation", false);
            if(isset($agent_from) && !empty($agent_from)){
                $condition['where'] = " WHERE id=$agent_from ";
                $flag = $this->get("agent", $condition);
                if(count($flag)< 1){
                    array_push($this->errors, "Aucun agent n'a été retrouvé");
                }
            }            
            if(count($this->errors) > 0){
                return false;
            }
            $values = new \stdClass();
            $values->type = $type;
            $values->montant = $montant;
            $values->id_agent = $_SESSION['user']['agent'];
            $values->motif = $motif;
            $values->observation = $observation;
            $values->id_agent_from = $agent_from;
            $values->tauxapplique = $_SESSION['TAUX'];
            $this->input($values, 'operation');
            return true;
        }
        public function listOperation($conditionadditive="") {
            $sql =  "SELECT `operation`.*,operation.type as typeoperation, `agent`.`id` AS `idagent`, `agent`.`nom`, `agent`.`postnom`, `agent`.`prenom`, `prov`.`id` AS `fromid`, `prov`.`nom` AS `fromnom`, 
                `prov`.`prenom` AS `fromprenom`, `agent`.`id_avatar`, `prov`.`id_avatar` AS fromavatar, download.filename, download.type, prov.filename as file , prov.type as typeimg
                    FROM `operation`
                    LEFT JOIN agent ON operation.id_agent = agent.id
                    LEFT JOIN download ON agent.id_avatar = download.id_download
                    LEFT JOIN (SELECT filename, type, nom, prenom, postnom, id, id_avatar FROM agent LEFT JOIN download as down ON agent.id_avatar = down.id_download) as prov ON prov.id = operation.id_agent_from ";
            if(isset($conditionadditive) && !empty($conditionadditive)){
                $sql .= $conditionadditive;
            }
            try {                
                $stm = $this->cnx->query($sql);
                return $stm->fetchAll(\PDO::FETCH_OBJ);
            } catch (\PDOException $exc) {                
                throw new \composants\MDEException($exc);
            }
        }
    }
