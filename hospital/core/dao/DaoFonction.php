<?php 
    namespace hospital\core\dao;
    class DaoFonction extends \model\Model{
        public function __construct($options = array()) {
            parent::__construct($options);
        }
        public function getFonctions(){
            $result="";
            try {
                
                $ps=$db->cnx->prepare("select * from Fonction");
                $ps->execute();

                $result=json_encode($ps->fetchAll(PDO::FETCH_ASSOC));

            } catch (Exception $th) {
                echo $th;
            }
            return $result;
           
        }
        public function getFonctionName($id){
            $respond=null;
            try {
                $ps= $this->cnx->query("select * from fonction where idFonction=$id");
                $respond=$ps->fetch()["libelle"];
            } catch (Exception $th) {
                
            }

            return $respond;
            }
 
    }
?>