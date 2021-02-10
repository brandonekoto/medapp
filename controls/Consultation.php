<?php

    namespace controls;
    class Consultation extends ControlBase{
        public function setBeans() {
            
        }

        public function setDao() {
            $this->dao = new \hospital\core\dao\Consultation();
        }

        public function view($id) {
            
        }
        public function add($data =[]) {            
            $this->setDao();
            $r = $this->dao->add($this->data);
            if($r == true){
                $this->session->setFlash("Consultation créée avec succèss");
                $this->redirect("/public/consultation.php?action=add&id=".$this->dao->lastId());
            }else{
                $this->session->setFlash("Une erreur est surgie");
                $this->redirect("/public/consultation.php?action=add&id=".$this->dao->lastId());
            }
        }
        
        public function get($data=[]) {
            extract($data);
            $this->setDao();
            $condition['fields'] =  " `consultation`.`id` AS `idConsultation`, `consultation`.`taille`, `consultation`.`anamnese`,"
                        . " `consultation`.`poids`, `consultation`.`temp`, `consultation`.`tension`, `consultation`.`date` AS `dateConsultation`, `consultation`.`obs`,  `acte`.`id` AS `idacte`, `acte`.`lib` AS `acte`, `acte`.`id_category` AS `id_cate`, "
                            . "`acte`.`prix_prive`, `acte`.`prix_conventionne`, `acte`.`prix_affilier`, `acte`.`prix`, pouls, fr, spo,"
                            . "`agent`.`id` AS `id_agent`, `agent`.`nom` AS `nomagent`, `agent`.`prenom` AS `prenomagent`, "
                            . "`agent`.`fonction`, `category_acte`.`lib` AS `categorie`, `patient`.`idPatient` AS `idPatient`, "
                            . "`patient`.`typePatient`, `patient`.`id_avatar` AS `imgpatient`, `patient`.`nom` AS `nompatient`, "
                            . "`patient`.`prenom` AS `prenompatient`, `patient`.`sexe` AS `sexepatient`, `patient`.`age` AS `agepatient`,"
                            . " `acte_pose`.`id` AS `idactepose`, `acte_pose`.`etape`, `acte_pose`.`date` AS `dateactepose`, download.filename, download.type as typeimg";
                 $condition['joins'] =  [
                        'tables' => ["acte_pose",'acte', 'patient', 'agent', 'category_acte', 'download'],
                        'tableBase' => ["consultation",'consultation', 'acte_pose', 'acte_pose','acte', 'patient'],
                        'typeJointure' => ["inner", 'INNER', 'LEFT', 'LEFT', 'INNER', 'INNER'],
                        'keys' => ["id",'id', 'idPatient', 'id','id', 'id_download'],
                        'primaryKeys' => ["id_acte",'id_acte', 'id_patient', 'id_agent','id_category','id_avatar']
                    ];
            if(isset($id) && !empty($id)){          
                   
                 $condition['where'] = " WHERE consultation.id = $id";
                 $r = ($this->dao->get('consultation', $condition));
            }else{
                $r = ($this->dao->get('consultation', $condition));
            }
            return $r;
        }

    public function after() {
        
    }

    public function before() {
        
    }

}
