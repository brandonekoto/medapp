<?php 
    namespace hospital\core\dao;
    use PDO;
    class BDConnect {
        protected $sgbd="mysql";
        protected $host="localhost";
        protected $dbname="managehospital";
        protected $username="root";
        protected $password="";
        protected $db;

        function _construct(){

        }

        public function connection(){
            try {
                $this->db=new PDO($this->sgbd.":host=".$this->host.";dbname=".$this->dbname.";charset=utf8",$this->username,$this->password);
            } catch (PDOException $ex) {
                echo $ex;
            }

            return $this->db;
        }

        public function request($type){
            
        }
    }
?>