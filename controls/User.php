<?php

namespace controls;

class User extends ControlBase {

    public $img;

    public function __construct() {
        parent::__construct();
        $this->img = new \composants\Download();
    }

    public function setBeans() {
        
    }

    public function setDao() {
        $this->dao = new \hospital\core\dao\User();
    }

    public function view($id) {
        
    }

    public function add($data = []) {
        $this->setDao();
        if ($_SESSION['user']['idFonction'] == 0) {
            $r = $this->dao->add($this->data, $this->data['type']);
            if ($r == true) {
                $this->session->setFlash('Utilisateur créé avec succès');
                $this->redirect("/public/personnel.php?action=view&id=" . $this->dao->lastUser);
            } else {
                $this->session->setFlash($this->dao->errors, "danger");
                $this->session->write("userdata", $this->data);
                $this->redirect("/public/users.php?action=add");
            }
        } else {
            $this->session->setFlash("Vous n'avez pas de privilège d'executer cette opération");
            $this->redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function getById($data = []) {
        extract($data);

        if (isset($username)) {
            return $this->dao->getById($username);
        }
        return false;
    }
    public function get($data = []) {
        $this->setDao();
        extract($data);

        if (isset($username)) {
            return $this->dao->userComplete($username);
        }
        return null;
    }

    public function getList() {
        $this->setDao();
        return $this->dao->getList();
    }

    public function login() {
        $this->setDao();
        extract($this->data);
        
        if (isset($username) && isset($pwd)) {
            $r = $this->dao->getById($username);
        
            if (count($r) > 0) {
                $hash = $r[0]->pwd;
                if (password_verify($pwd, $hash) == true) {
                    $condition['where'] = " WHERE id_user = " . $r[0]->id;
                    //$user = $this->dao->get("agent",$condition)[0];
                    $user = $this->dao->userComplete($username)[0];
                   
                    $_SESSION['user'] = [
                        'username' => $username,
                        'category' => $r[0]->category,
                        'idFonction' => $user->fonction,
                        'fonction' => $user->libelle,
                        'allowed' => $r[0]->allowed,
                        'time' => time(),
                        'agent' => $user->agent,
                        'url' => $user->filename . "." . $user->type,
                        'idhopital' => $user->idhopital,
                        "hopital" => $user->denomination,
                        "province" => $user->id_province,
                        "property" => $user->id_property,
                        "idgroupe" => $user->idgroup,
                        "id_user" => $r[0]->id
                    ];
                   
                    $this->session->setFlash("Bienvenue Mr, Mlle " . $user->nom);
                    $this->session->write("expiresession", time() + 60 * 10);

                    $this->redirect("/public/");
                } else {
                    $this->session->setFlash("Mot de passe incorrect", "danger");
                    $this->redirect("/");
                }
            } else {
                $this->session->setFlash("Aucune information associée à cet identifiant indiqué ", "danger");
                $this->redirect("/");
            }
        } else {
            $this->session->setFlash("Veuillez vérifiez les données saisies", "danger");
            $this->redirect("/");
        }
    }

    public function logout() {
        if (isset($_SESSION['user'])) {
            unset($_SESSION['user']);
            unset($_SESSION['expiresession']);
        }
        $this->session->setFlash("Vous êtes déconnecté");
        $this->redirect("/");
    }

    public function checkConnectivity() {
        /*echo '<pre>';
        var_dump($_SESSION['user']);
        echo '</pre>';*/
        if (isset($_SESSION['user'])) {

            if (isset($_SESSION['expiresession'])) {
                if (($_SESSION['expiresession'] - time()) > 0) {
                    $this->session->write("expiresession", time() + 60 * 10);
                } else {
                    $this->logout();
                }
            } else {
                
            }

            if ($_SERVER["REQUEST_URI"] == "/") {
                header("Location:/public");
            }
        } else {
                //header("Location:/");
            
              if($_SERVER["REQUEST_URI"] != "/"){
                    //header("Location:/");
              }else{
                //header("Location:/");
              } 
        }
    }

    public function update() {
        $this->setDao();
        $r = $this->dao->changerPwd($this->data);
        if ($r === true) {
            $this->session->setFlash(["Votre mot de passé a été modifier avec succès", "Ceci vous déconnecte directement pour raison de sécurité.", "Veuillez vous connecté à nouveau"]);
            $this->logout();
        } else {
            $this->session->setFlash($this->dao->errors);
            $this->redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function after() {
        
    }

    public function before() {
        
    }

}
