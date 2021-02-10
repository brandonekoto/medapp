<?php

namespace composants;
class LivraisonManager{
    public $product = [];
    public $cmd ;
    public $devise ;
    private $Product ;
    const TVA = "16";
    public function __construct() {
        $this->hasModel = false;
        if(!isset($_SESSION['productLivraison'])){
            $this->create();
        }
        $this->Product =  new \hospital\core\dao\Pharmacy();
    }    
    public function addItem($id, $qte=1) {
        $qteDispo ;
        if(!isset($_SESSION['productLivraison'])){
            $this->create();
        }
        if((isset($id) && !empty($id)) && isset($qte)){
            $item = $this->itemInDb($id);
            if($item != false && !is_null($item) ){
                if($this->existItem($id) === false){
                    array_push($_SESSION['productLivraison']['products'], $id);
                    array_push($_SESSION['productLivraison']['qteCmd'], $qte);
                    array_push($_SESSION['productLivraison']['coutachat'], $item[0]->prixachat);
                    array_push($_SESSION['productLivraison']['prixvente'], $item[0]->prixvente);
                    array_push($_SESSION['productLivraison']['designation'], $item[0]->lib);
                   
                    return true;
                }else{
                    /*
                    $pos = array_search($id, $_SESSION['productLivraison']['products']);
                    $_SESSION['productLivraison']['qteCmd'][$pos] = $_SESSION['productLivraison']['qteCmd'][$pos] + $qte;
                    $_SESSION['productLivraison']['coutachat'][$pos] = $_SESSION['productLivraison']['coutachat'][$pos] + $coutachat;
                    $_SESSION['productLivraison']['prixvente'][$pos] = $_SESSION['productLivraison']['prixvente'][$pos] + $coutachat;*/
                    return 0;
                }
                return false;
            }
        }
        return false;
        
    }
    
    public function delete($id) {
        if(isset($id) && !empty($id)){
            $pos = array_search($id, $_SESSION['productLivraison']['products']);
            if($pos !==  false){
                unset($_SESSION['productLivraison']['products'][$pos]);
                unset($_SESSION['productLivraison']['qteCmd'][$pos]);
                unset($_SESSION['productLivraison']['coutachat'][$pos]);
                unset($_SESSION['productLivraison']['prixvente'][$pos]);
                unset($_SESSION['productLivraison']['designation'][$pos]);
                $_SESSION['productLivraison']['products'] = array_merge($_SESSION['productLivraison']['products']);
                $_SESSION['productLivraison']['qteCmd'] = array_merge($_SESSION['productLivraison']['qte']);
                $_SESSION['productLivraison']['coutachat'] = array_merge($_SESSION['productLivraison']['coutachat']);
                $_SESSION['productLivraison']['prixvente'] = array_merge($_SESSION['productLivraison']['prixvente']); 
                $_SESSION['productLivraison']['designation'] = array_merge($_SESSION['productLivraison']['designation']);
                return true;
            }
            return false;
        }
        return false;
    }
    public function create() {
        $_SESSION['productLivraison'] = [
            'products'=>[],
            'qteCmd'=>[],
            'coutachat'=>[],
            'prixvente' => [],     
            'designation' =>[]
        ];
    }
    
    public function existItem($id){
        return in_array($id, $_SESSION['productLivraison']['products']);
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
        $_SESSION['productLivraison'] =  null;
        unset($_SESSION['productLivraison']);
        if(in_array($_SESSION['productLivraison'], $_SESSION)){
            return false;
        }
        return true;
    }
    
    public function countItem() {
        if($this->exist() && isset($_SESSION['productLivraison']['products'])){
            return count($_SESSION['caddie']['productLivraison']);
        }
        return 0;
    }
    public function countEachItem() {
        $nItem = 0;
        for ($i= 0; $i < count($_SESSION['productLivraison']['products']); $i++) {
            $pos = array_search($_SESSION['productLivraison']['products'][$i], $_SESSION['productLivraison']['products']);
            $nItem += $_SESSION['productLivraison']['qteCmd'][$pos];
        }
        return $nItem;
    }
    public  function totalProduct() {
        //$productIds = $this->getProductsInDB();
        $productWithPrices = $this->getPrices();
        $total = 0;
        $keys = array_keys($productWithPrices);
        $prices = array_values($productWithPrices);        
        if(!is_null($productWithPrices) && count($productWithPrices) == count($_SESSION['productLivraison']['products'])){
            for ($i = 0; $i < count($_SESSION['productLivraison']['products']); $i++) {
                if(array_key_exists($_SESSION['productLivraison']['products'][$i], $productWithPrices)){
                     $total += floatval($prices[$i]) * $_SESSION['productLivraison']['qteCmd'][$i];                    
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
        $productIds = " WHERE id IN(";
        for ($i = 0; $i< count($_SESSION['productLivraison']['products']); $i++) {
            $productIds .= $_SESSION['productLivraison']['products'][$i] .",";
        }
        $productIds = trim($productIds, ",");
        $productIds .= ")";
        $condition['where'] = $productIds;
        return $this->Product->get('produit', $condition);
    }
    public function getItemsInDB() {
        //$condition['fields'] =  " piece.idPiece as id, piece.prixUnitVente as pVente, piece.qteStock as qte, piece.prixUnitAchat as pAchat, piece.refProduct as ref, piece.dateFab, piece.codType as type, piece.description, imagesproduct.id as idImg, imagesproduct.idPiece as idPieceImg, imagesproduct.id_download as idDownloadImg,download.id_download, download.filename, download.type, typepieces.codType, typepieces.lib as libType";
        $condition['joins'] = [
            'tables' => ['typepieces','imagesproduct','download'],
            'tableBase' => ['piece','piece','imagesproduct'],
            'typeJointure' => ['INNER', 'LEFT','LEFT'],
            'keys' => ['codType','idPiece','id_download'],
            'primaryKeys' => ['codType','idPiece','id_download']
        ];                
        $productIds = " WHERE produit.id IN(";
        for ($i = 0; $i< count($_SESSION['productLivraison']['products']); $i++) {
            $productIds .= $_SESSION['productLivraison']['products'][$i] .",";
        }
        $productIds = trim($productIds, ",");
        $productIds .= ")";
        $condition['where'] = $productIds;
        $condition['groupBy'] = "piece.idPiece";
        return $this->Product->get('piece', $condition);
    }
    public function exist() {
        if (!isset($_SESSION['productLivraison'])) {
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
    /*public function __destruct() {
        var_dump("executée");
        if(in_array($_SESSION['caddie'], $_SESSION)){
            $_SESSION['caddie'] =  null;
            unset($_SESSION['caddie']);
        }
    }*/
}
