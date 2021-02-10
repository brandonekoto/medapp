<?php
    class UserDao{

        public function setUser($user){ 

            echo "password:::".$user->getPassword();
            $fullname=$user->getFullName();
            $username=$user->getUsername();
            $email=$user->getEmail();
            $tel=$user->getTel();
            $password=$user->getPassword();

            $rep=0;
            try {
                $url="mysql:host=localhost;dbname=tkbd";
                $us="root";
                $pw="";
                $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
                $bd=new PDO($url,$us,$pw,$pdo_options);

                $ps=$bd->query("insert into user(fullname,username,email,tel,password) values('$fullname','$username','$email','$tel','$password')");
                $rep=1;
            } catch (Exception $ex) {
                echo $ex;
                $rep=0;
            }

            return $rep;
        }

        public function checkUsername($username){
            $rep=0;
            try {
                $url="mysql:host=localhost;dbname=tkbd";
                $us="root";
                $pw="";
                $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
                $bd=new PDO($url,$us,$pw,$pdo_options);

                $ps=$bd->query("select username from user");
                while ($rs=$ps->fetch()) {
                    if($rs["username"]==$username){
                        $rep=1;
                        break;
                    }
                }
                
            } catch (Exception $ex) {
                $rep=0;
            }

            return $rep;
        }

        public function checkAccount($username,$password){
            $rep=0;
            try {
                $url="mysql:host=localhost;dbname=tkbd";
                $us="root";
                $pw="";
                $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
                $bd=new PDO($url,$us,$pw,$pdo_options);

                $ps=$bd->query("select * from user");
                while ($rs=$ps->fetch()) {
                    echo "username=".$rs["username"]." password=".$rs["password"]."\n";
                    if($rs["username"]==$username){
                        
                        if($rs["password"]==$password){
                            $rep=$rs["idUser"];
                            break;
                        }else{
                            $rep=10;
                            break;
                        }
                        
                    }
                }
                
            } catch (Exception $ex) {
                $rep=0;
                echo $ex;
            }

            return $rep;
        }

        public function checkUserById($id){
            $rep="";
            try {
                $url="mysql:host=localhost;dbname=tkbd";
                $us="root";
                $pw="";
                $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
                $bd=new PDO($url,$us,$pw,$pdo_options);
                $ps=$bd->query("select * from user where idUser=$id");
                while ($rs=$ps->fetch()) {
                    if($rs["idUser"]==$id){
                        $rep=$rs["username"];
                        break;
                    }
                }
                
            } catch (Exception $ex) {

            }

            return $rep;
        }
    }
?>