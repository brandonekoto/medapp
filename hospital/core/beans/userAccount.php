<?php

class user {

    private $idUseraccount;
    private $username;
    private $password;
    private $privileges;

    function getIdUseraccount() {
        return $this->idUseraccount;
    }

    function getUsername() {
        return $this->username;
    }

    function getPassword() {
        return $this->password;
    }

    function getPrivileges() {
        return $this->privileges;
    }

    function setIdUseraccount($idUseraccount) {
        $this->idUseraccount = $idUseraccount;
    }

    function setUsername($username) {
        $this->username = $username;
    }

    function setPassword($password) {
        $this->password = $password;
    }

    function setPrivileges($privileges) {
        $this->privileges = $privileges;
    }

}

?>