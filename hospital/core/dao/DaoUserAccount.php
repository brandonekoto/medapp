<?php

include_once("BDConnect.php");

class DaoUserAccount extends BDConnect {

    public function setAccount($idAgent, $username, $password, $modules, $priv) {
        $respond = false;

        try {
            $db = $this->connection();

            $persoIsFind = false;
            $ps = $db->prepare("select * from agent where idAgent=?");
            $ps->execute(array($idAgent));
            $idUseraccount = null;

            while ($rs = $ps->fetch()) {
                $persoIsFind = true;
                $ps = $db->prepare("insert into useraccount(username,password,modules,privileges) values(?,?,?,?)");
                $respond = $ps->execute(array($username, $password, $modules, $priv));

                $idUseraccount = $db->lastInsertId();
                if ($respond === true) {
                    $ps = $db->prepare("insert into agent_useraccount(idAgent,idUseraccount) values(?,?)");
                    $resp = $ps->execute(array($idAgent, $idUseraccount));

                    if ($resp) {
                        $ps = $db->prepare("delete from useraccount where idUseraccount=?)");
                        $ps->execute(array($idUseraccount));
                    }
                }
                break;
            }
            if (!$persoIsFind) {

                return "nonePerso";
            }
        } catch (Exception $ex) {
            $respond = false;
            if (!$persoIsFind) {
                return "nonePerso";
            }
        }
        return $respond;
    }

    public function getAllAccounts() {
        $respond = "";
        try {
            $db = $this->connection();
            $ps = $db->query("select * from useraccount uc "
                    . "join agent_useraccount auc on uc.idUseraccount=auc.idUseraccount "
                    . "join agent ag on ag.idAgent=auc.idAgent");

            while ($rs = $ps->fetch()) {
                $respond .= '<tr>'
                        . '<td>' . $rs["idUseraccount"] . '</td>'
                        . '<td>' . $rs["idAgent"] . '</td>'
                        . '<td>' . $rs["username"] . '</td>'
                        . '<td>' . $rs["modules"] . '</td>'
                        . '<td colspan="2">'
                        . '<div style="width: 120%; margin:auto;">'
                        . '<a href="index.php?type=remove&id=' . $rs["idUseraccount"] . '" style="margin-right:7px">'
                        . '<span class="glyphicon glyphicon-trash"></span>'
                        . '</a>'
                        . '</div>'
                        . '</td>';
            }
        } catch (Exception $ex) {
            
        }
        return $respond;
    }

    public function findAccount($username, $password) {
        $UserAccount = null;
        try {
            $db = $this->connection();
            $ps = $db->query("select * from useraccount where username='" . $username . "' and password='" . $password . "'");

            while ($rs = $ps->fetch()) {
                $account = array("username" => $rs["username"], "password" => $rs["password"], "confirm" => "true", "modules" => $rs["modules"],"privileges" => $rs["privileges"]);
                $UserAccount = json_encode($account);
            }
        } catch (Exception $ex) {
            
        }

        return $UserAccount;
    }

    public function remove($id) {
        $respond = null;
        try {
            $db = $this->connection();
            $ps = $db->prepare("delete from useraccount where idUseraccount=?");
            $respond = $ps->execute(array($id));
        } catch (Exception $ex) {
            
        }

        return $respond;
    }

}

?>