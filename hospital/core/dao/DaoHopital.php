<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace hospital\core\dao;

/**
 * Description of DaoHopital
 *
 * @author brandonekoto
 */
class DaoHopital extends \model\Model{
    //put your code here
    public function __construct(array $params = array()) {
        parent::__construct($params);
        $this->table = "hopital";
    }
}
