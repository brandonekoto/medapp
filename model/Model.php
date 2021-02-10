<?php

namespace model;

use composants;
use \PDO;

class Model {

    public $table;
    public $cnx;
    public $Model;
    public $datas;
    public $errors = [];
    public $results;
    public $primaryKey = "id";
    static $lastId;
    static $instance;

    public function __construct($options = []) {
        $this->cnx = \composants\DBProvider::getInstace();
        $this->setTable_and_Model();
    }

    public function setTable_and_Model($table = "") {
        if (isset($table) && !empty($table)) {
            $table = strtolower($table);
            $this->table = $table;
        } else {
            $table = explode("\\", strtolower(get_class($this)));
            $this->table = end($table);
        }
    }

    public function get($table = null, array $conditions = null, $prepare = false, array $valuesOfPrepare = []) {
        $query = "SELECT ";
        if (is_null($this->cnx)) {
            new Model();
        }
        if (isset($conditions['fields'])) {
            $query .= (is_array($conditions['fields'])) ? implode(' , ', $conditions['fields']) : $conditions['fields'];

            $pos = strrpos($query, ',');
            $query = trim($query, ',');
            //$query = substr($query, 0, $pos - 1);
        } else {
            $query .= ' * ';
        }

        if (!is_null($table) && isset($table)) {

            $query .= ' FROM ' . ' ' . $table;
        } else {
            $query .= ' FROM ' . ' ' . $this->table;
        }
        if (isset($conditions['joins'])) {
            $joins = [];
            for ($i = 0; $i < count($conditions['joins']['tables']); $i++) {
                $tB = (isset($conditions['joins']['tableBase'][$i])) ? $tB = $conditions['joins']['tableBase'][$i] : $table;
                $tJ = $conditions['joins']['typeJointure'][$i];
                $tbJ = $conditions['joins']['tables'][$i];
                $r = strpos($conditions['joins']['tables'][$i], 'as');
                $s = strpos($conditions['joins']['tableBase'][$i], 'as');
                $r = str_replace('as', '', substr($conditions['joins']['tables'][$i], $r));
                $s = str_replace('as', '', substr($conditions['joins']['tableBase'][$i], $s));
                $k = $conditions['joins']['keys'][$i];
                $pK = $conditions['joins']['primaryKeys'][$i];
                if (isset($conditions['joins']['tableBase'])) {
                    $joins[] = "  $tJ JOIN $tbJ ON $r.$k = $s.$pK";
                } else {
                    $joins[] = " $tJ JOIN  $tbJ ON $r.$k = $this->table.$pK";
                }
            }
            $query .= implode(' ', $joins);
        }
        $condWhere = [];
        if (isset($conditions['where'])) {

            if (is_array($conditions['where'])) {
                $query .= ' WHERE ';

                for ($i = 0; $i < count($conditions['where']['term1']); $i++) {
                    $t1 = $conditions['where']['term1'][$i];
                    $s = $conditions['where']['comparateur'][$i];
                    if (stristr($s, 'IN')) {
                        $t2 = "";
                    } elseif (stristr($s, 'BETWEEN')) {
                        $t2 = "";
                    } else {
                        $t2 = (is_string($conditions['where']['term2'][$i])) ? "'"
                                . addslashes($conditions['where']['term2'][$i]) . "'" : $conditions['where']['term2'][$i];
                    }
                    $condition = "$t1 $s $t2";
                    $condWhere[] = $condition;
                }
                $query .= implode(' AND ', $condWhere);
            } else {
                $query .= $conditions['where'];
            }
        }
        if (isset($conditions['groupBy'])) {
            if (is_array($conditions['groupBy'])) {
                $groups = [];
                foreach ($conditions['groupBy'] as $k => $v) {
                    $groups[] = $v;
                }
                $query .= ' GROUP BY ' . implode(' , ', $groups);
            } else {
                $query .= ' GROUP BY ' . $conditions['groupBy'];
            }
        }

        if (isset($conditions['order'])) {
            if (is_array($conditions['order'])) {
                $order = [];
                foreach ($conditions['order'] as $k => $v) {
                    $order[] = $v;
                }
                $query .= ' ORDER BY ' . implode(' ,', $order);
            } else {
                $query .= ' ORDER BY ' . $conditions['order'];
            }
        }

        if (isset($conditions['having'])) {
            $query .= ' HAVING ';
            if (is_array($conditions['having'])) {
                $havings = [];
                foreach ($conditions['having'] as $k => $v) {
                    $havings[] = $v;
                }
                $query .= implode(' ,', $havings);
            } else {
                $query .= $conditions['having'];
            }
        }
        if (isset($conditions['limit'])) {
            if (isset($conditions['offset'])) {
                $query .= " LIMIT " . $conditions['offset'] . "," . $conditions['limit'];
            } else {
                $query .= " LIMIT " . $conditions['limit'];
            }
        }

        //var_dump($query);  
        try {
            if ($prepare !== false && count($valuesOfPrepare) > 0 && (count($conditions['where']) === count($valuesOfPrepare))) {
                $req = $this->cnx->prepare($query);
                $req->execute($valuesOfPrepare);
            } else {
                $req = $this->cnx->query($query);
            }
        } catch (\PDOException $exc) {
            throw new \Exception($exc);
        }

        if (!is_bool($req) and!is_null($req)) {
            $results = $req->fetchAll(PDO::FETCH_OBJ);
        } else {
            return false;
        }

        return $results;
    }

    public function getLast($table = null, array $conditions = null, $prepare = false, $valuesOfprepare = array()) {
        $result = $this->get($table, $conditions, $prepare, $valuesOfprepare);
        return end($result);
    }

    public function getFirst($table = null, array $conditions = null, $prepare = false, $valuesOfprepare = array()) {
        $result = $this->get($table, $conditions, $prepare, $valuesOfprepare);
        return $result[0];
    }

    public function input(\stdClass $data, $table = null, $transactionnal = false) : bool {
        $fields = $values = $tmp = [];
        foreach ($data as $k => $v) {
            $fields[] = $k;
            $tmp[] = ':' . $k;
            $values[':' . $k] = htmlentities($v, ENT_IGNORE, "UTF-8");
        }

        $fields = "(" . implode(',', $fields) . ")";
        $tmp = "(" . implode(',', $tmp) . ")";
        if ($table == null) {
            $table = $this->table;
        }
        $sql = 'INSERT INTO ' . $table . ' ' . $fields . ' VALUES ' . $tmp;
        try {
            if ($transactionnal == true) {
                $this->cnx->beginTransaction();
            }
            $pdost = $this->cnx->prepare($sql);
            return $pdost->execute($values);
            
        } catch (\PDOException $e) {
            $this->errors = $e;
            if ($transactionnal == true) {
                $this->cnx->rollBack;
            }
            return false;
            //throw new  \PDOException($e->getMessage() ."\n " );
        }
    }

    public function update($conditions, \stdClass $data, $table = null) {
        if (method_exists($this, "beforeSave")) {
            $this->beforeSave($this->data);
        }
        $values = $tmp = [];
        foreach ($data as $d => $v) {
            $values[':' . $d] = htmlentities($v, ENT_QUOTES, "UTF-8");
            $tmp[] = $d . "=:" . $d;
        }
        $tmp = implode(',', $tmp);
        if ($table == null) {
            $table = $this->table;
        }

        $sql = 'UPDATE ' . $table . ' SET ' . $tmp;
        if (isset($conditions['where'])) {
            if (is_array($conditions['where'])) {
                $sql .= ' WHERE ';
                for ($i = 0; $i < count($conditions['where']['term1']); $i++) {
                    $t1 = $conditions['where']['term1'][$i];
                    $s = $conditions['where']['comparateur'][$i];
                    if (stristr($s, 'IN')) {
                        $t2 = "";
                    } elseif (stristr($s, 'BETWEEN')) {
                        $t2 = "";
                    } else {
                        $t2 = (is_string($conditions['where']['term2'][$i])) ? "'"
                                . addslashes($conditions['where']['term2'][$i]) . "'" : $conditions['where']['term2'][$i];
                    }
                    $condition = "$t1 $s $t2";
                    $condWhere[] = $condition;
                }
                $sql .= implode(' AND ', $condWhere);
            } else {
                $sql .= $conditions['where'];
            }
        }
        try {
            $pdost = $this->cnx->prepare($sql);
            $pdost->execute($values);
            return true;
        } catch (\PDOException $e) {
            throw new \composants\MDEException($e->getMessage());
        }
    }

    public function delete($id, $val, $table = null) {

        if (method_exists($this, "beforeDelete")) {
            //$this->beforeDelete($this->data);
        }
        if ($table == null) {
            $table = $this->table;
        }
        try {
            $this->cnx->query("DELETE FROM " . $table . " WHERE $id=$val");
            return true;
        } catch (\PDOException $ex) {

            throw new \composants\MDEException($ex->getMessage());
            return false;
        }


        if (method_exists($this, "afterDelete")) {
            $this->afterDelete($this->data);
        }
    }

    public function paginate($table = null, array $conditions = null, $nbPerPage = 5) {
        if (!isset($_GET['page']) || $_GET['page'] < 1 || !is_numeric($_GET['page'])) {
            $_GET['page'] = 1;
        }
        $total = $this->count($table);
        $d['nbPages'] = $total;
        if ($_GET['page'] > $d['nbPages'] && $d['nbPages'] != 0) {
            $_GET['page'] = $d['nbPages'];
        }
        $conditions['offset'] = $nbPerPage * ($_GET['page'] - 1);
        $conditions['limit'] = $nbPerPage;
        $tt = $this->get($table);
        $d['total'] = count($tt != null && is_array($tt)? $tt: []);
        $d['results'] = $this->get($table, $conditions);
        return $d;
    }

    public static function getInstance() { {
            if (is_null(self::$instance)) {
                self::$instance = new Model();
            }
            return self::$instance;
        }
    }

    public function lastId() {
        if (is_null($this->cnx)) {
            self::$instance = self::getInstance();
        }
        return $this->cnx->lastInsertId();
    }

    public function logout() {
        $this->cnx = null;
    }

    public function paginated($table = null, array $conditions = null, $nbPerPage) {
        if (!isset($_GET['page']) || $_GET['page'] < 1 || !is_numeric($_GET['page'])) {
            $_GET['page'] = 1;
        }
        $total = $this->count();
        $d['nbPages'] = ceil($total / $nbPerPage);
        if ($_GET['page'] > $d['nbPages'] && $d['nbPages'] != 0) {
            $_GET['page'] = $d['nbPages'];
        }
        $conditions['offset'] = $nbPerPage * ($_GET['page'] - 1);
        $conditions['limit'] = $nbPerPage;
        $d['results'] = $this->get($table, $conditions);
        return $d;
    }

    public function count($table = null, array $joins = null) {
        $count = $this->getFirst($table, ['fields' => "COUNT(*) as count"], $joins);
        return $count->count;
    }

    public function valideData($data, $regExp, $msg, $champ, $required = true) {

        if ($required === true) {
            if (!isset($data) || strlen($data) < 1) {
                array_push($this->errors, "Ce champ $champ ne peut être vide, Veuillez l'insérer svp");
                return false;
            }
        } else {
            if (preg_match($regExp, $data) === false) {
                array_push($this->errors, $msg);
                return false;
            }
            return true;
        }

        if (preg_match($regExp, $data) === false) {
            array_push($this->errors, $msg);
            return false;
        }
        return true;
    }

    static public function genereToken() {
        $str = str_shuffle(str_repeat("ABCDEFGHIJKLMNOPQRSTVWXYZabcdefghijklmnopqrstvwxyz0123456789", 2));
        strlen($str);
        return $str;
    }

    public function startTransaction() {
        try {
            return $this->cnx->beginTransaction();
        } catch (Exception $e) {
            return false;
        }
    }

    public function commitTransaction() {
        try {
            return  $this->cnx->commit();
        } catch (Exception $e) {
            return false;
        }
       
    }

    public function rollback() {
        try {
            return $this->cnx->rollback();
        } catch (Exception $e) {
            return false;
        }
        
    }

    function getErrors() {
        return $this->errors;
    }

}
