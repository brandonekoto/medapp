<?php


namespace model;

interface DaoInterface {
    public function add($data=[]) ;
    public function del($id) ;
    public function edit($id, $data=[]) ;
}
