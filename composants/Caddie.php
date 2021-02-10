<?php

namespace composants;
class Caddie{
    public $product = [];
    public $cmd ;
    public $devise ;
    public $Product ;
    static public  $TAUX;
    const TVA = "16";
    const MONNAIE = ["USD"=>1, "CDF" => 16700 ];
    public function __construct() {
        $this->hasModel = false;       
        if(!isset($_SESSION['caddie'])){
            $this->create();
        }        
        $this->Product =  new \hospital\core\dao\Pharmacy();
        
    }    
    public function addItem($id, $qte=1) {
        $qteDispo ;
        if(!isset($_SESSION['caddie'])){
            $this->create();
        }
        if((isset($id) && !empty($id)) && isset($qte)){
            $item = $this->itemInDb($id);            
            if($item != false && !is_null($item) ){
                $item = $item[0];
                if($this->existItem($id) === false){
                    if($this->salable($id) === true){                      
                        if( strtotime($item->dateExp) - (time()) <= 604800){
                            return 1;
                        }                                       
                        array_push($_SESSION['caddie']['products'], $id);
                        array_push($_SESSION['caddie']['qteCmd'], $qte);
                        array_push($_SESSION['caddie']['coutachat'], $item->prixachat);
                        array_push($_SESSION['caddie']['prixvente'], $item->prixvente);
                        array_push($_SESSION['caddie']['designation'], $item->lib);
                        array_push($_SESSION['caddie']['dateExp'], $item->dateExp);                        
                        return true;
                    }else{
                        return -1;
                    }
                }else{
                    /*$pos = array_search($id, $_SESSION['caddie']['products']);
                    $_SESSION['caddie']['qteCmd'][$pos] =  $qte;
                    $_SESSION['caddie']['coutachat'][$pos] =  $coutachat;
                    $_SESSION['caddie']['prixvente'][$pos] =  $coutachat;*/        
                    return 0;
                }
                return false;
            }
        }
        return false;    
    }
    
    public function delete($id) {
        if(isset($id) && !empty($id)){
            $pos = array_search($id, $_SESSION['caddie']['products']);
            if($pos !==  false){
                unset($_SESSION['caddie']['products'][$pos]);
                unset($_SESSION['caddie']['qteCmd'][$pos]);
                unset($_SESSION['caddie']['coutachat'][$pos]);
                unset($_SESSION['caddie']['prixvente'][$pos]);
                unset($_SESSION['caddie']['designation'][$pos]);
                unset($_SESSION['caddie']['dateExp'][$pos]);
                $_SESSION['caddie']['products'] = array_merge($_SESSION['caddie']['products']);
                $_SESSION['caddie']['qteCmd'] = array_merge($_SESSION['caddie']['qteCmd']);
                $_SESSION['caddie']['coutachat'] = array_merge($_SESSION['caddie']['coutachat']);
                $_SESSION['caddie']['prixvente'] = array_merge($_SESSION['caddie']['prixvente']); 
                $_SESSION['caddie']['designation'] = array_merge($_SESSION['caddie']['designation']); 
                $_SESSION['caddie']['dateExp'] = array_merge($_SESSION['caddie']['dateExp']);
                return true;
            }
            return false;
        }
        return false;     
    }
    public function changequantity($id, $qte=1) {
        if(isset($id) && !empty($id)){
            $pos = array_search($id, $_SESSION['caddie']['products']);
            if($pos !==  false){
                if($this->salable($id, $qte) === true){
                    $_SESSION['caddie']['qteCmd'][$pos] =  $qte;
                    return true;
                }else{
                    return -1;
                }       
            }
            return false;
        }
        return false;
    }
    public function create() {
        $_SESSION['caddie'] = [
            'products'=>[],
            'qteCmd'=>[],
            'coutachat'=>[],
            'prixvente' => [],
            'designation' =>[],
            'dateExp' =>[],
        ];
        $_SESSION['defaultMonnaie'] = ["MONEY" => "USD", "TAUX"  => self::MONNAIE["CDF"]];
    }
    
    public function existItem($id){
        return in_array($id, $_SESSION['caddie']['products']);
    }
    
    public function itemInDb($id) {
        return $this->Product->Product($id);
    }
    public function qteDispo($id) {
        $item = $this->Product->Product($id);
        if(!is_null($item) && count($item) > 0){
            $qteDispo = $item[0]->quantite;
            if($qteDispo > 0){
                return $qteDispo;
            }
            return 0;
        }
        return -1;     
    }
    
    public function calcTVA() {
        return ($this->totalProduct() * self::TVA) / 100;
    }
    
    public function calcDelivery($ShipmentPrice = 0) {
        return ($this->totalProduct() * self::TVA) / 100;
    }
    
    public function calcPort() {
        
    }
    public function salable($id, $qte = 1) {
        $dispo = $this->qteDispo($id);
        if($dispo != 0 && $dispo != -1){
            if($dispo - $qte > 0){
                return true;
            }
            return false;
        }
        return false;
    }
    
    public function clear() {
        if(in_array($_SESSION['caddie'], $_SESSION)){
            $_SESSION['caddie'] =  null;
            unset($_SESSION['caddie']);
        }
        return true;
    }
    
    public function countItem() {
        if($this->exist() && isset($_SESSION['caddie']['products'])){
            return count($_SESSION['caddie']['products']);
        }
        return 0;
    }
    public function countEachItem() {
        $nItem = 0;
        for ($i= 0; $i < count($_SESSION['caddie']['products']); $i++) {
            $pos = array_search($_SESSION['caddie']['products'][$i], $_SESSION['caddie']['products']);
            $nItem += $_SESSION['caddie']['qteCmd'][$pos];
        }
        return $nItem;
    }
    public  function totalProduct() {
        //$productIds = $this->getProductsInDB();
        $productWithPrices = $this->getPrices();
        $total = 0;
        $keys = array_keys($productWithPrices);
        $prices = array_values($productWithPrices);
        if(!is_null($productWithPrices) && count($productWithPrices) == count($_SESSION['caddie']['products'])){
            for ($i = 0; $i < count($_SESSION['caddie']['products']); $i++) {
                if(array_key_exists($_SESSION['caddie']['products'][$i], $productWithPrices)){
                     $total += floatval($prices[$i]) * $_SESSION['caddie']['qteCmd'][$i];                    
                }else{
                    return false;
                }                
            }
            return $total;
        }
        return false;
    }
    public function getPrices() {
      $products = $this->getProductsInDB();
      $pPrices = [];
      foreach ($products as $value) {
        $pPrices[$value->idPiece] = $value->prixUnitVente;
      }
      return $pPrices;
    }
    public function getProductsInDB() {
        $productIds = " WHERE idPiece IN(";
        for ($i = 0; $i< count($_SESSION['caddie']['products']); $i++) {
            $productIds .= $_SESSION['caddie']['products'][$i] .",";
        }
        $productIds = trim($productIds, ",");
        $productIds .= ")";
        $condition['where'] = $productIds;
        return $this->Product->get('produit', $condition);
    }
    public function getItemsInDB() {
        $condition['fields'] =  " piece.idPiece as id, piece.prixUnitVente as pVente, piece.qteStock as qte, piece.prixUnitAchat as pAchat, piece.refProduct as ref, piece.dateFab, piece.codType as type, piece.description, imagesproduct.id as idImg, imagesproduct.idPiece as idPieceImg, imagesproduct.id_download as idDownloadImg,download.id_download, download.filename, download.type, typepieces.codType, typepieces.lib as libType";
        $condition['joins'] = [
            'tables' => ['typepieces','imagesproduct','download'],
            'tableBase' => ['piece','piece','imagesproduct'],
            'typeJointure' => ['INNER', 'LEFT','LEFT'],
            'keys' => ['codType','idPiece','id_download'],
            'primaryKeys' => ['codType','idPiece','id_download']
        ];
        $productIds = " WHERE piece.idPiece IN(";
        for ($i = 0; $i< count($_SESSION['caddie']['products']); $i++) {
            $productIds .= $_SESSION['caddie']['products'][$i] .",";
        }
        $productIds = trim($productIds, ",");
        $productIds .= ")";
        $condition['where'] = $productIds;
        $condition['groupBy'] = "piece.idPiece";
        return $this->Product->get('piece', $condition);
    }
    public function exist() {
        if (!isset($_SESSION['caddie'])) {
            return false;
        }
        return true;
    }
    
    public function isEmpty() {
        if($this->exist() === true && $this->countItem() > 0){
            return false;
        }
        return true;
    }
    
    public function setMonnaie($monnaie="USD") {
        $monnaie = strtoupper($monnaie);
        
        if(key_exists($monnaie, self::MONNAIE) === true){
            $_SESSION['defaultMonnaie']["MONEY"] = $monnaie;
            $_SESSION['defaultMonnaie']["TAUX"] = self::MONNAIE[$monnaie];
            return true;
        }
        return false;
    }
    
    public function reCalculate() {
        if($this->exist() && $this->countItem() > 0){
            for ($i = 0; $i < $this->countItem(); $i++) {
                $_SESSION['caddie']['products'][$i]  = $_SESSION['caddie']['products'][$i] ;
                $_SESSION['caddie']['qteCmd'][$i] =  $_SESSION['caddie']['qteCmd'][$i];    
                $pvent  = $_SESSION['caddie']['prixvente'][$i];
                if($_SESSION['defaultMonnaie']['MONEY'] == "CDF"){
                    $_SESSION['caddie']['prixvente'][$i] =  $pvent * self::MONNAIE['CDF'] ;                    
                }else{
                    $_SESSION['caddie']['prixvente'][$i] =  $pvent / self::MONNAIE['CDF'];
                }                
                $_SESSION['caddie']['coutachat'][$i] =  $_SESSION['caddie']['coutachat'][$i];
            }          
        }       
    }
    
    public function monnaieExist() {
        return key_exists("defaultMonnaie", $_SESSION);
    }
    /*public function __destruct() {
        var_dump("executée");
        if(in_array($_SESSION['caddie'], $_SESSION)){
            $_SESSION['caddie'] =  null;
            unset($_SESSION['caddie']);
        }
    }*/
}
