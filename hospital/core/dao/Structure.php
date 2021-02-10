<?php

namespace hospital\core\dao;

class Structure extends \model\Model{
    public function __construct($options = array()) {
        parent::__construct($options);
    }
    
    public function getStructure($conditionadditive = []) {
        
    }
    
    public function getStructurePatient($conditionadditive=[]) {
        $condition['fields'] = "`patient`.*, `structureaffilier`.`id` AS `idstructure`, `structureaffilier`.`raisonsociale`, `structureaffilier`.`responsable`, `structureaffilier`.`adresse` AS `adressestructure`, `structureaffilier`.`contact` AS `contractstructure`, `download`.`filename`, `download`.`type`";
        $condition['joins'] =  [
            'tables' => ['download'],
            'tableBase' => ['patient'],
            'typeJointure' => ['INNER'],
            'keys' => ['id_download'],
            'primaryKeys' => ['id_avatar']
        ];
    }
    public function bind($data=[]) {
        extract($data);
        if(isset($idStructure) && !empty($idStructure)){
            $condition['where'] = " WHERE id = '$idStructure'";
            $flagStructure = $this->get("structureaffilier", $condition);
        }
        
        if(count($flagStructure) <  1){
            array_push($this->errors, "Structure non trouvée, veuillez sélectionner une structure à laquelle vous voulez rattacher un patient");
        }
        
        if(isset($idpatient) && !empty($idpatient)){
            unset($condition);
            $condition['where'] = " WHERE idPatient = '$idpatient'";
            $flagPatient = $this->get("patient", $condition);
        }
        if(count($flagPatient) <  1){
            array_push($this->errors, "Patient non trouvé, veuillez respecter la logique pour arriver ici... Si cette erreur resiste, c'est une tentative de piratage, veuillez signaler MDE Services pour en résoudre");
        }
               
        if(count($this->errors) > 0){
            return false;
        }else{
            $values = new \stdClass();
            $values->idStructure = $idStructure;
            $this->update($condition, $values, "patient");
            return true;
        }
    }
    public function getMembers($idStructure="") {        
        $condition['joins'] =  [
                'tables' => ['patient' ],
                'tableBase' => ['structureaffilier' ],
                'typeJointure' => ['LEFT', ],
                'keys' => ['idStructure'],
                'primaryKeys' => ['id']
        ];
        $condition['where'] = " structureaffilier.id ='$idStructure'";
        return $this->paginate("structure", $condition);
    }
}
