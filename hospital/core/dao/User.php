<?php

namespace hospital\core\dao;

use model\Model;

class User extends Model {

    public $lastUser = null;

    public function add($data, $type) {
        $category = $type;
        $sscat = null;

        extract($data);
        $controller = null;
        $userInfo = null;
        $hopi = null;

        $identifiant = null;
        //$this->valideData($username, "#^[a-z]+[a-z0-9._]{5,60}$#", "Le username ne doit être vide et doit respecter le format suivant : être composé des caractères (minimum 8 et maximum 60) suivant :( [a-z] 0-9 .  _ ), commençant toujours par une lettre et suivi des lettres et d'autres caractèrs autorisés", "Username");
        //$this->valideData($pwd, "#^[a-zA-Z]+[a-zA-Z0-9._]{5,60}$#", "Le mot de passe ne doit être vide et doit respecter le format suivant : Débuter par une lettre majuscule suivi de ( [a-zA-Z0-9 .  _ ) (minimum 8 et maximum 60)", "Password");
        switch ($type) {
            case "agent":
                $controller = new \controls\Agent();
                $daoHopital = new \hospital\core\dao\DaoHopital();
                $userInfo = $controller->get($id);

                //$identifiant = $userInfo;
                if (count($userInfo) > 0) {
                 
                    if (is_null($userInfo[0]->iduser)) {
                        $conditions['where'] = " WHERE ID='" . $userInfo[0]->id_hopital . "' ";
                        $hopi = $daoHopital->get("hopital", $conditions);

                        if ($hopi != null && count($hopi) > 0) {
                            $sscat = $userInfo[0]->fonction;

                            $identifiant = ucfirst(strtolower(substr($userInfo[0]->nom, 0, 3)));
                            $identifiant .= ucfirst(strtolower(substr($userInfo[0]->prenom, 0, 3)));
                            $fonction = $userInfo[0]->fonction;
                            $conditions['where'] = " WHERE idfonction='$fonction' ";
                            $fonction = $daoHopital->get("fonction", $conditions);

                            if ($fonction != null && count($fonction) > 0) {
                                $identifiant .= "." . ucfirst(substr($fonction[0]->libelle, 0, 3));
                                $identifiant .= "." . ucfirst(substr($hopi[0]->denomination, 0, 3));
                                $identifiant .= (count($this->get("user")) != null && is_numeric(count($this->get("user"))) ? count($this->get("user")) + 1 : 1);
                            } else {
                                $identifiant = null;
                                array_push($this->errors, "Fonction non trouvé");
                            }
                        } else {
                            array_push($this->errors, "Hopital non trouvé");
                        }
                    } else {
                        array_push($this->errors, "Cet utilisateur a déjà un compte");
                    }
                } else {
                    array_push($this->errors, "Personne non trouvée ");
                }
                break;
            case "user":
                //$controller = new \controls\Patient();
                break;

            default:
                array_push($this->errors, "Type non reconnu");
                break;
        }

        if (count($this->errors) > 0) {
            return false;
        } else {
            $values = new \stdClass();
            $values->username = \composants\Utilitaire::translateCharacter($identifiant);
            $values->pwd = password_hash("123456", PASSWORD_BCRYPT);
            $values->category = $category;
            $values->sous_category = $sscat;
            $values->code = self::genereToken();
            $values->id_hopital = $_SESSION['user']['idhopital'];
            $values->allowed = 1;
            try {
                $r = $this->input($values, "user");
                if ($r == true) {
                    
                    $this->lastUser = $userInfo[0]->id;
                    return $controller->dao->updateUser($id, $this->lastId());
                }
            } catch (\PDOException $ex) {
                array_push($this->errors, $ex->getMessage());
                return false;
            }
        }
    }

    public function getById($id) {
     
        $condition['where'] = " WHERE user.username ='$id' XOR user.id = '$id'";
        return $this->get("user", $condition);
    }

    public function getList() {
        $condition['order'] = " user.username ASC";
        return $this->get("user");
    }

    public function userComplete($id) {
        $condition['fields'] = " `user`.*, `agent`.*, `fonction`.*, `hopital`.`id` AS `idhopital`, `hopital`.*,  `download`.*, hopital.id_province, agent.id as agent, groupe.id as idgroup";
        $condition['where'] = " WHERE user.id='$id' XOR user.username = '$id' ";
        $condition['joins'] = [
            'tables' => ['agent', 'fonction', 'download', 'hopital', 'groupe'],
            'tableBase' => ['user', 'agent', 'agent', 'user', 'hopital'],
            'typeJointure' => ['LEFT', 'INNER', 'LEFT', 'INNER', 'LEFT'],
            'keys' => ['id_user', 'idFonction', 'id_download', 'id', 'id'],
            'primaryKeys' => ['id', 'fonction', 'id_avatar', 'id_hopital', 'id_groupe']
        ];
        
        return $this->get("user", $condition);
    }

    public function changerPwd($data = []) {
        extract($data);
        $user = $this->userComplete($_SESSION['user']['username']);
        if (count($user) < 1 || $user === false) {
            array_push($this->errors, "Utilisateur non trouvé");
        }
        $id = $_SESSION['user']['username'];
        $this->valideData($password, "#^[a-zA-Z]+[a-zA-Z0-9._]{6,60}$#", "Le mot de passe ne doit être vide et doit respecter le format suivant : Débuter par une lettre majuscule suivi de ( [a-zA-Z0-9 .  _ ) (minimum 8 et maximum 60)", "Password");
        if ($repassword !== $password) {
            array_push($this->errors, "Les deux mot de passe de se conforment, Please veuillez recommencer. S'assurez-vous que vous les avez bien saisi ");
        }
        if (count($this->errors) > 0) {
            return false;
        } else {
            $values = new \stdClass();
            $values->pwd = password_hash($password, PASSWORD_BCRYPT);
            $values->allowed = "0";
            $condition['where'] = " WHERE user.username = '$id' ";
            $this->update($condition, $values, "");
            return true;
        }
    }

}
