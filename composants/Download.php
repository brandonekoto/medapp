<?php
    namespace composants;
    use composants\dbProvider;
                
    class Download extends \model\Model
    {
        private $id;
        private $fileName ;
        private $idUser;
        private $type;
        private $size;
        private $date;
        public $table;
        private $fileFolder;
        public  $ids = array();
        public $errors = array();
        static $authorizedTypes = array(
            'pdf', 'doc', 'docx', 'jpeg','jpg','png','gif', 'txt'
        );
       
        public function __construct($folder = "img/")
        {              
            parent::__construct();
             if (!isset($_SESSION)) {
                session_start();
            }
            $this->fileFolder = $folder;
            $this->idUser = (isset($_SESSION['users']['id'])) ?$_SESSION['users']['id']: "" ;
        }
    
        public function  addFiles($files, $boxFiles){
         
            if (isset($files) && count($files[$boxFiles]['name']) > 0) {
                foreach ($files[$boxFiles]['name'] as $k=>$v){
                    if ($files[$boxFiles]['error'][$k] !== 0) {
                        array_push($this->errors,"Une erreur lors du téléchargment du fichier :  $v, veuillez la r&eacutet&eacutel&eacutecharger ");
                    }else {
                        $type = explode("/", $files[$boxFiles]['type'][$k])[1];                        
                        if (in_array($type, self::$authorizedTypes)) {
                            if ($files[$boxFiles]['size'][$k] > (1024 * 1024 * 5)) {
                                array_push($this->errors,"Le fichier $v ne peut être acceptée parce que sa taille est sup�rieure � 5Mo,Vous devriez recommencer l'operation");
                            }else {
                                try {
                                    $this->type = $type;  
                                    
                                    $this->fileName .= "zF";
                                    $this->fileName .= microtime() * 1000;                                    
                                    $this->idUser = $this->idUser = (isset($_SESSION['users']['id'])) ?$_SESSION['users']['id']: "1" ;
                                    $type = explode("/", $type);
                                    $type = $type[0];
                                    $name = $this->fileName;                                    
                                    if (isset($this->fileFolder) && !empty($this->fileFolder)) {
                                        $url = $this->fileFolder;
                                    }else{
                                        $url = "files/";
                                    }                                    
                                    $this->fileName .= ".$type";
                                    $url .= $this->fileName;                                     
                                    try {
                                        move_uploaded_file($files[$boxFiles]['tmp_name'][$k], $url);
                                    }catch (\Exception $e){
                                        throw new \PDOException($e);
                                        var_dump($e);
                                        die();
                                    }
                                    
                                    $url =  "";
                                    $r = $this->inputIntoDB($name, $this->idUser, $this->type, $files[$boxFiles]['size'][$k]);                                    
                                    $this->name = "";
                                    $this->fileName = "";
                                    $name = null;
                                    array_push($this->ids, $r);
                                } catch (\Exception $e) {
                                    var_dump($e);
                                    array_push($this->errors,"Une erreur est surgie lors de l'enregistrement du fichier $v");
                                }                        
                            }
                        }else{
                            array_push($this->errors, "On n'accepte pas ce type de format sur l'image". $files[$boxFiles]['name'][$k] ."dans notre serveur, raison de s�curit�");
                        }
                    } 
                }
                $return = array(
                    'error' =>$this->errors,
                    'ids'=>$this->ids
                );
                
                if (count($this->errors)>0) {
                    return $return;
                }
                $return = array(
                    'ids' => $this->ids
                );
                return $return;
            }else{
                return false;
            }
        }
        
        public function inputIntoDB($name, $author, $type, $w) {
            if ((!isset($w) || empty($w))) {
                $this->errors = "Taille du fichier abscente, veuillez l'ins�rer";
            }
            
            if ((!isset($name) || empty($name))) {
                $this->errors = "Le fichier  doit toujours avoir un nom, veuillez l'ins�rer";
            }
            if ((!isset($author) || empty($author))) {
                $this->errors = "Chaque image doit avoir un auteur, veuillez l'ins�rer";
            }
            
            if ((!isset($type) || empty($type))) {
                $this->errors = "Type non retrouv�, veuillez recommencer ";
            }
            
            if (count($this->errors) > 0){
                return false;
            }else {
                $sql = "INSERT INTO download(filename,id_user,type, size) VALUES(:filename, :user,:type,:size)";
                try {
                    $stm = $this->cnx->prepare($sql);
                    $params = array(
                        ':filename' => $name,
                        ':user'=> $author,
                        ':type'=>$type,
                        ':size' => $w                       
                    );
                    $r = $stm->execute($params);
                    if ($r !== FALSE) {
                        return $this->cnx->lastInsertId();
                    }else {
                        return false;
                    }
                    
                }
                catch (\PDOException $e){
                    var_dump($e);
                }
            }
        }
        
        public function getFilesInfo($ids, $user=null, $filename=null) {
            if (isset($ids)){
                if (is_array($ids)){
                    $ids = implode(",",$ids);                   
                }
                $params = array();
                if(!is_null($user) && !is_null($filename)){
                    $sql = "SELECT id_download, filename, id_user, download.type as typeFile, size, , id_users, username, noms, download.date 
                        FROM download
                        INNER JOIN users ON download. id_user= users.id_users
                        WHERE users.id_users = :id_user AND download.filename :filename ";
                    $params  = array(
                        ':filename'=>$filename,
                        ':id_user' =>$user
                    );
                }elseif(!is_null($user)){
                    $sql = "SELECT id_download, filename, id_user, download.type as typeFile, size, download.date  id_users, username, noms 
                        FROM download
                        INNER JOIN users ON download. id_user= users.id_users
                        WHERE users.id_users = :id_user AND download.id_download IN($ids)";
                    $params  = array(                        
                        ':id_user' =>$user
                    );
                }else{
                     $sql = "SELECT id_download, filename, id_user, download.type as typeFile, size, download.date , id_users, username, noms
                            FROM download
                            INNER JOIN users ON download. id_user = users.id_users
                            WHERE download.id_download IN($ids)";
                }                               
                
                try {
                    
                    $stm = $this->cnx->prepare($sql);                    
                    if (count($params) > 0){
                        $stm->execute($params);   
                    }else{
                        $stm->execute();
                    }               
                    $r = $stm->fetchAll(\PDO::FETCH_OBJ);
                    return $r;
                } catch (Exception $exc) {
                    echo $exc->getTraceAsString();
                }
                        
                
            }else{
                
            }
        }
        
        
    }

