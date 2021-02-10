<?php

namespace composants;
class ApprovisionnementManager{
    public $product = [];
    public $cmd ;
    public $devise ;
    public $Product ;
    public $errors = [];
    const TVA = "16";
    public function __construct() {
        $this->hasModel = false;
        if(!isset($_SESSION['productAprov'])){
            $this->create();
        }
        $this->Product =  new \hospital\core\dao\Pharmacy();
    }    
    public function addItem($id, $qte=1, $coutachat=0, $prixvente=0, $designation="") {
        $qteDispo ;
        if(!isset($_SESSION['productAprov'])){
            $this->create();
        }
        if((isset($id) && !empty($id)) && isset($qte)){
            
            $this->valideData($qte, "#^[0-9]{1,}$#", "La quantité ne doit être vide et doit être composée que des chiffres", "Quantité");
            $this->valideData($prixvente, "#^[0-9.]{1,}$#", "Le Prix de vente ne doit être vide et doit être composée que des chiffres et admet '\.' (POINT) comme séparateur de décimal", "Prix de vente");
            $this->valideData($coutachat, "#^[0-9.]{1,}$#", "Le cout d'achat ne doit être vide et doit être composée que des chiffres et admet '\.' (POINT) comme séparateur de décimal", "Cout d'achat");
   
            if(count($this->errors) > 0){
                return false;
            }
            $item = $this->itemInDb($id);
            if($item != false && !is_null($item) ){
                if($this->existItem($id) === false){
                    array_push($_SESSION['productAprov']['products'], $id);
                    array_push($_SESSION['productAprov']['qteCmd'], $qte);
                    array_push($_SESSION['productAprov']['coutachat'], $coutachat);
                    array_push($_SESSION['productAprov']['prixvente'], $prixvente);
                    array_push($_SESSION['productAprov']['designation'], $designation);
                    return true;
                }else{
                    /*
                    $pos = array_search($id, $_SESSION['productAprov']['products']);
                    $_SESSION['productAprov']['qteCmd'][$pos] = $_SESSION['productAprov']['qteCmd'][$pos] + $qte;
                    $_SESSION['productAprov']['coutachat'][$pos] = $_SESSION['productAprov']['coutachat'][$pos] + $coutachat;
                    $_SESSION['productAprov']['prixvente'][$pos] = $_SESSION['productAprov']['prixvente'][$pos] + $coutachat;*/
                    return 0;
                }
                return false;
            }
        }
        return false;
        
    }
    
    public function delete($id) {
        if(isset($id) && !empty($id)){
            $pos = array_search($id, $_SESSION['productAprov']['products']);
            if($pos !==  false){
                unset($_SESSION['productAprov']['products'][$pos]);
                unset($_SESSION['productAprov']['qteCmd'][$pos]);
                unset($_SESSION['productAprov']['coutachat'][$pos]);
                unset($_SESSION['productAprov']['prixvente'][$pos]);
                unset($_SESSION['productAprov']['designation'][$pos]);
                $_SESSION['productAprov']['products'] = array_merge($_SESSION['productAprov']['products']);
                $_SESSION['productAprov']['qteCmd'] = array_merge($_SESSION['productAprov']['qte']);
                $_SESSION['productAprov']['coutachat'] = array_merge($_SESSION['productAprov']['coutachat']);
                $_SESSION['productAprov']['prixvente'] = array_merge($_SESSION['productAprov']['prixvente']); 
                $_SESSION['productAprov']['designation'] = array_merge($_SESSION['productAprov']['designation']); 
                return true;
            }
            return false;
        }
        return false;
    }
    public function create() {
        $_SESSION['productAprov'] = [
            'products'=>[],
            'qteCmd'=>[],
            'coutachat'=>[],
            'prixvente' => [],     
            'designation' =>[]
        ];
    }
    
    public function existItem($id){
        return in_array($id, $_SESSION['productAprov']['products']);
    }
    
    public function itemInDb($id) {
        return $this->Product->Product($id);
    }
    public function qteDispo($id) {
        $item = $this->Product->getProduct($id);
        if(!is_null($item) && count($item) > 0){
            $qteDispo = $item[0]->qteStock;
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
            if($dispo -$qte > 0){
                return true;
            }  
            return false;
        }
        return false;
    }
    
    public function clear() {
        $_SESSION['productAprov'] =  null;
        unset($_SESSION['productAprov']);
        if(in_array($_SESSION['productAprov'], $_SESSION)){
            return false;
        }
        return true;
    }
    
    public function countItem() {
        if($this->exist() && isset($_SESSION['productAprov']['products'])){
            return count($_SESSION['caddie']['productAprov']);
        }
        return 0;
    }
    public function countEachItem() {
        $nItem = 0;
        for ($i= 0; $i < count($_SESSION['productAprov']['products']); $i++) {
            $pos = array_search($_SESSION['productAprov']['products'][$i], $_SESSION['productAprov']['products']);
            $nItem += $_SESSION['productAprov']['qteCmd'][$pos];
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
        return $this->Product->get('piece', $condition);
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
        if (!isset($_SESSION['productAprov'])) {
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
    
    public function __destruct() {
    
    }
    public function valideData($data, $regExp, $msg, $champ, $required = true) {

        if ($required === true) {
            if (!isset($data) || strlen($data) < 1) {
                array_push($this->errors, "Ce champ $champ ne peut être vide, Veuillez l'insérer svp");
                return false;
            }
        } else {
            return false;
        }
        if (preg_match($regExp, $data) == false) {
            array_push($this->errors, $msg);
            return false;
        }
    }
    /*public function __destruct() {
        var_dump("executée");
        if(in_array($_SESSION['caddie'], $_SESSION)){
            $_SESSION['caddie'] =  null;
            unset($_SESSION['caddie']);
        }
    }*/
}
