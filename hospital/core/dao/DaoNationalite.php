<?php 
    header('Content-Type: application/json');
    include_once("BDConnect.php");
    class DaoNationalite extends \model\Model{

        public function getNationalites(){
            $result="";

            try {
                
                $ps= $this->cnx->prepare("select * from nationalite");
                $ps->execute();

                $result=json_encode($ps->fetchAll(PDO::FETCH_ASSOC));
            } catch (Exception $th) {
                echo $th;
            }
            return $result;
           
        }

        public function getNation($id){
            $respond=null;
            try {
                $db=$this->connection();
                $ps=$db->query("select * from nationalite where idNationalite=$id");
                $respond=json_encode($ps->fetch(PDO::FETCH_ASSOC));

            } catch (Exception $th) {
                
            }

            return $respond;
            }
 
    }
?>