<?php

namespace hospital\core\dao;


class Consultation extends \model\Model implements \model\DaoInterface{
    
    public function add($data = array()) {
        
        extract($data);
        $this->valideData($anamnese, "#^\w{2,5000}$#", "L'anamnese nom ne doit être vide et ne peut contenir que des caractères ordinaires maximum 30 caractères", "Nom");
        $this->valideData($poids, "#^([0-9]){1,3}$#", "Le poids ne doit être vide et ne doit contenir des chiffres maximum 3 autorisés il est présenté en cm comme unité", "Poids");
        $this->valideData($taille, "#^[0-9]{1,3}$#", "La Taille ne doit être vide et ne doit contenir des chiffres maximum 3 autorisés il est présenté en Kilogramme comme unité", "Poids");
        $this->valideData($temperature, "#^([0-9]){1,3}$#", "La Température ne doit être vide et ne doit contenir des chiffres maximum 3 autorisés il est présenté en centimetre de mercure (cmHg) comme unité",  "Température");
        $this->valideData($tension, "#^([0-9]){1,3}$#", "La tension arterièle ne doit être vide et ne doit contenir des chiffres maximum 3 autorisés il est présenté en celcius comme unité",  "Tension");
        $condition['where'] = " WHERE id=1";
        
        $r = $this->get("acte_pose", $condition);
        $condition['where'] = " WHERE idPatient = $patient";
        if(count($r) < 1){
            array_push($this->errors, "Aucun acte n'est associé à cette consultation que vous voulez créer...");
        }
        $r = $this->get("patient", $condition);
        if(count($r) < 1){
            array_push($this->errors, "Vous avez sélectionné Aucun Patient pour une consultation, veuillez le sélectionner");
        }
        $acte = 1;
        if(count($this->errors)>0){
            
            return false;
        }else{
            $values = new \stdClass();
            $values->taille = $taille;
            $values->poids = $poids;
            $values->temp = $temperature;
            $values->tension = $tension;
            $values->anamnese = $anamnese;
            $values->id_patient = $patient;
            $values->id_acte = $acte;            
            $this->input($values, "consultation");
            
            return true;
        }
        
    }
    
    public function getConsultations($id) {
        
        if(!empty($id)){
            
            $condition['where'] = " WHERE consultation.id = $id";
        }else{
            
        }
    }
    public function del($id) {
        
    }

    public function edit($id, $data = array()) {
        
    }

}
