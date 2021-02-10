<?php



namespace controls;

class Pharmacy extends ControlBase{
    public $AprovManage ;
    public $CaddieManager ;
    public $LivraisonManager ;
    public function __construct() {
        parent::__construct();
        $this->AprovManage = new \composants\ApprovisionnementManager();
        $this->LivraisonManager = new \composants\LivraisonManager();
        $this->CaddieManager =  new \composants\Caddie();
        $this->setDao();
        $this->session->write('TAUX', \hospital\core\dao\Pharmacy::$TAUX);
    }
    public function after() {
        
    }

    public function before() {
        
    }

    public function setBeans() {
        
    }
    public function del($data=[]) {
        if ($_SESSION['user']['idFonction'] == 0 ) {
            if(isset($data['id']) && !empty($data['id'])){
                extract($data);
                $this->setDao();
                $r = $this->dao->del($id);
                if ($r == true) {
                    $this->session->setFlash("Suppression du produit avec succès");                    
                } else {
                    $this->session->setFlash("Possible de supprimer", "danger");                   
                }                
            } else {
                $this->session->setFlash("Vous n'avez sélectionné aucun produit à supprimer", 'warning');                
            }
        } else {
            $this->session->setFlash("Vous n'avez pas de privilège d'executer cette opération");            
        }
        $this->redirect($_SERVER['HTTP_REFERER']);
    }
    public function delapprov($data=[]) {
        if ($_SESSION['user']['idFonction'] == 0 ) {
            if(isset($data['id']) && !empty($data['id'])){
                extract($data);
                $this->setDao();
                $r = $this->dao->delApprov($id);
                if ($r == true) {
                    $this->session->setFlash("Suppression de l'approvisionnement réussie avec succès");                    
                } else {
                    $this->session->setFlash("Possible de supprimer", "danger");                   
                }    
            } else {
                $this->session->setFlash("Vous n'avez sélectionné aucun approvisionnement à supprimer", 'warning');                
            }
            $this->redirect($_SERVER['HTTP_REFERER']);
        } else {
            $this->session->setFlash("Vous n'avez pas de privilège d'executer cette opération");            
        }
        $this->redirect($_SERVER['HTTP_REFERER']);
    }
    public function dellivraison($data=[]) {
        if ($_SESSION['user']['idFonction'] == 0 ) {
            if(isset($data['id']) && !empty($data['id'])){
                extract($data);
                $this->setDao();
                $r = $this->dao->delLivraison($id);
                if ($r == true) {
                    $this->session->setFlash("Suppression de la livraison réussie avec succès");                    
                } else {
                    $this->session->setFlash("Possible de supprimer", "danger");                 
                }
            } else {
                $this->session->setFlash("Vous n'avez sélectionné aucune livraison à supprimer", 'warning');                
            }
            $this->redirect($_SERVER['HTTP_REFERER']);
        } else {
            $this->session->setFlash("Vous n'avez pas de privilège d'executer cette opération");
        }
        $this->redirect($_SERVER['HTTP_REFERER']);
    }
    
    public function setDao() {
        if($this->dao === null){
            $this->dao = new \hospital\core\dao\Pharmacy();
        }        
    }

    public function view($id) {
        
    }    
    public function addfournisseur($data=[]) {
        $this->setDao();
        $r = $this->dao->addFournisseur($this->data);
        if($r === true){
            $this->session->setFlash("Ajout fournisseur reussi avec succès"); 
            $this->redirect("/public/pharmacy.php?action=fournisseur");
        }else{
            $this->session->setFlash($this->dao->errors,"danger");
            $this->redirect($_SERVER['HTTP_REFERER']);
        }         
    }
    public function initapprov($data=[]) {
        $this->AprovManage->clear();
        $this->setDao();
        $r = $this->dao->initApprov($this->data);
        $id = $this->dao->lastId();
        if($r === true){
            $this->session->setFlash("Initialisation approvisionnement reussi avec succès. Veuillez ajouter les produits puis valider"); 
            $this->redirect("/public/pharmacy.php?action=approvisionnement&m=addproduct&id=$id");
        }else{
            $this->session->setFlash($this->dao->errors,"danger");
            $this->redirect($_SERVER['HTTP_REFERER']);
        }
    }
    public function initlivraison($data=[]) {
        $this->LivraisonManager->clear();
        $this->setDao();
        $r = $this->dao->initLivraison($this->data);
        
        if($r != null){
            $this->session->setFlash("Initialisation de livraison reussi avec succès. Veuillez ajouter les produits puis valider"); 
            $this->redirect("/public/pharmacy.php?action=livraison&m=addproduct&id=$r");
        }else{
            $this->session->setFlash($this->dao->errors,"danger");
            $this->redirect($_SERVER['HTTP_REFERER']);
        }
    }
    
    public function add($data=[]) {
        $this->setDao();
        if(isset($_FILES['imgProduit']) && count($_FILES['imgProduit']['name']) > 0 && strlen($_FILES['imgProduit']['name'][0]) > 0){
                $imgController = new \composants\Download(ROOT . DS . "img/produit/");                
                $s = $imgController->addFiles($_FILES, "imgProduit");
                $this->data['imgproduit'] = $s['ids'][0];
        }
        $r = $this->dao->add($this->data);
        if($r === true){
            $this->session->setFlash("Ajout Nouveau produit reussi avec succès"); 
            $this->redirect("/public/pharmacy.php?");
        }else{
            $this->session->write("data", $this->data);
            $this->session->setFlash($this->dao->errors,"danger");
            $this->redirect($_SERVER['HTTP_REFERER']);            
        }     
    }
    public function edit($data=[]) {
        $this->setDao();
        if(isset($_FILES['imgProduit']) && count($_FILES['imgProduit']['name']) > 0 && strlen($_FILES['imgProduit']['name'][0]) > 0){
                $imgController = new \composants\Download(ROOT . DS . "img/produit/");                
                $s = $imgController->addFiles($_FILES, "imgProduit");
                $this->data['imgproduit'] = $s['ids'][0];
        }
        $r = $this->dao->edit($this->data);
        if($r === true){
            $this->session->setFlash("Modification du produit reussie avec succès"); 
            $this->redirect("/public/pharmacy.php?action=view&id=".$this->data['idproduit']);
        }else{
            $this->session->write("data", $this->data);
            $this->session->setFlash($this->dao->errors,"danger");
            $this->redirect($_SERVER['HTTP_REFERER']);
            
        }     
    }
    
    
    public function addproductapprov($data=[]) { 
        extract($this->data);        
        if(isset($product) && !empty($product) && isset($quantite) && !empty($quantite) && isset($coutachat) && !empty($coutachat)  && isset( $prixvente) && !empty($prixvente) && isset( $designation) && !empty($designation)){            
            $r = $this->AprovManage->addItem($product, $quantite, $coutachat, $prixvente, $designation);   
            if($r===true){
                $this->session->setFlash("Produit ajouté avec succès");                
            }elseif ($r=== 0) {
                $this->session->write("data", $this->data);
                $this->session->setFlash("Produit déjà existant dans la liste", "warning");
            }else{
                $this->session->write("data", $this->data);
                array_unshift($this->AprovManage->errors, "Une erreur est surgie, produit non trouvé dans le système, veuillez l'enregistrer en amont");                
               
                $this->session->setFlash($this->AprovManage->errors, "danger");
                
            }            
            $this->redirect($_SERVER['HTTP_REFERER']);
        }else{
            $this->session->write("data", $this->data);
            $this->session->setFlash("Veuillez vérifier que tous les chambres sont remplis","danger");
            $this->redirect($_SERVER['HTTP_REFERER']);            
        }
    }
    public function addproductlivraison($data=[]) { 
        extract($this->data);  
        var_dump($this->data);
        if(isset($product) && !empty($product) && isset($quantite) && !empty($quantite) ){
            $r = $this->LivraisonManager->addItem($product, $quantite);            
            if($r===true){
                $this->session->setFlash("Produit ajouté avec succès");                
            }elseif ($r=== 0) {
                $this->session->write("data", $this->data);
                $this->session->setFlash("Produit déjà existant dans la liste", "warning");
            }else{
                $this->session->write("data", $this->data);
                $this->session->setFlash("Une erreur est surgie, produit non trouvé dans le système, veuillez l'enregistrer en amont", "danger");
            }          
            var_dump($r, $_SESSION);
            $this->redirect($_SERVER['HTTP_REFERER']);
        }else{
            $this->session->write("data", $this->data);
            $this->session->setFlash("Veuillez vérifier que tous les chambres sont remplis","danger");
            $this->redirect($_SERVER['HTTP_REFERER']);
            
        }
    }
    
    
    public function clearapprov() {
        unset($_SESSION['productAprov']);        
        $this->redirect($_SERVER['HTTP_REFERER']);
    }
    public function clearlivraison() {
        unset($_SESSION['productLivraison']);        
        $this->redirect($_SERVER['HTTP_REFERER']);
    }
    
    public function addcategory($data=[]) {
        $this->setDao();        
        $r = $this->dao->addCategory($this->data);
        if($r === true){
            $this->session->setFlash("Ajout Catégorie produit reussi avec succès"); 
            $this->redirect("/public/pharmacy.php?action=category");
        }else{
            $this->session->setFlash($this->dao->errors,"danger");
            $this->redirect($_SERVER['HTTP_REFERER']);
        }        
    }
    
    public function getfournisseurs($condition=[] ){
        $this->setDao();
        return $this->dao->get("fournisseur",$condition);
    }
    
    public function getcategory($condition=""){
        $this->setDao();
        return $this->dao->getCategory($condition);
    }
    
    public function getproduct($condition=[]) {
        $this->setDao();
        return $this->dao->getProduct($condition);
    }
    public function product($data=[]) {
        $this->setDao();
        extract($data);
        return $this->dao->Product($id);
    }
    
    public function searchproduct($condition="") {
        $this->setDao();
        extract($condition);
        
        return $this->dao->searchProduct($motif);
    }
    
    public function getapprovionnement($conditionadditive=[]) { 
        $this->setDao();
        return $this->dao->getApprovionnement($conditionadditive);
    }
    public function getlivraison($conditionadditive=[]) { 
        $this->setDao();
        return $this->dao->getlivraison($conditionadditive);
    }
    
    public function getlistapprovisionnement($conditionadditive=[]) {
        $this->setDao();
        return $this->dao->getListApprovisionnement($conditionadditive);
    }
    public function searchsale($data=[]) {
        extract($data);
        $this->setDao();
        return $this->dao->searchSale($motif);
    }
    
    public function getlistlivraison($conditionadditive=[]) {
        $this->setDao();
        return $this->dao->getListLivraison($conditionadditive);
    }
    public function getlistlivraisonByActe($conditionadditive=[]) {
        $this->setDao();
        return $this->dao->getlivraisonItemByLivraisonByActe($conditionadditive);
    }
    public function searchlivraison($data="") {
        extract($data);
        $this->setDao();
        return $this->dao->searchLivraison($motif);
    }
    
    public function getapprovisionnementitem($conditionadditive=[]) {
        $this->setDao();
        return $this->dao->getApprovisionnementItem($conditionadditive);
    }
    public function getlivraisonitem($conditionadditive=[]) {
        $this->setDao();
        return $this->dao->getlivraisonItem($conditionadditive);
    }    
    
    public function validerapprov($data=[]) {
        extract($data);
        $this->setDao();
        $r = $this->dao->addItemToAprovisionnement($data['id'], $_SESSION['productAprov']);
        if($r === true){
            $this->session->setFlash('Approvisionnement fait avec succès');
            $this->AprovManage->clear();
            $this->redirect("/public/pharmacy.php?action=approvisionnement");
        } else {
            $this->session->setFlash($this->dao->errors, "danger");
            $this->redirect($_SERVER['HTTP_REFERER']);
        }
    }
    public function validerlivraison($data=[]) {
        extract($data);
        $this->setDao();
        $r = $this->dao->addItemToLivraison($data['id'], $_SESSION['productLivraison']);
        if($r === true){
            $this->session->setFlash('Livraison faite avec succès');
            $this->LivraisonManager->clear();
            $this->redirect("/public/pharmacy.php?action=livraison");
        } else {
            $this->session->setFlash($this->dao->errors, "danger");
            $this->redirect($_SERVER['HTTP_REFERER']);
        }
    }
    
    public function removeproductfromapprov($data = []) {
        if(isset($data['id']) && !empty($data['id'])){
            $this->AprovManage->delete($data['id']);
            $this->session->setFlash('Item oté de la liste');
            $this->redirect($_SERVER['HTTP_REFERER']);
        }else{
            $this->session->setFlash('Une erreur est surgie lors de l\'enlevement de l\'item', "warning");
            $this->redirect($_SERVER['HTTP_REFERER']);
        }
    }
    public function removeproductfromlivraison($data = []) {
        if(isset($data['id']) && !empty($data['id'])){
            $this->LivraisonManager->delete($data['id']);
            $this->session->setFlash('Item oté de la liste');
            $this->redirect($_SERVER['HTTP_REFERER']);
        }else{
            $this->session->setFlash('Une erreur est surgie lors de l\'enlevement de l\'item', "warning");
            $this->redirect($_SERVER['HTTP_REFERER']);
        }
    }
    
    
    public function additemtobasket($data=[]) {
        extract($data);
        $r = $this->CaddieManager->addItem($id);
        if($r === true){
            return [
              'valider' => true,
              'message'=> "Produit ajouter avec succès",
              'product'=> $_SESSION['caddie'], 
                'TAUX' => $_SESSION['TAUX']
                
            ];
        }elseif($r === 0){
            return [
              'valider' => 0,
              'message'=> "Produit déjà sur la liste de facturation",
              'product'=> $_SESSION['caddie'], 'TAUX' => $_SESSION['TAUX']
            ];
        }elseif($r === -1){
            return [
              'valider' => -1,
              'message'=> "Produit non vendable, quantité epuisée",
              'product'=> $_SESSION['caddie'], 'TAUX' => $_SESSION['TAUX']
            ];
        }elseif($r === 1){
            return [
              'valider' => 1,
              'message'=> "Produit tend vers son expiration dans une semaine",
              'product'=> $_SESSION['caddie'], 'TAUX' => $_SESSION['TAUX']
            ];
        }else{
            return [
              'valider' => false,
              'message'=> "Produit tend vers son expiration dans une semaine",
              'product'=> $_SESSION['caddie'], 'TAUX' => $_SESSION['TAUX']
            ];
        }
    }
    
    public function clearbasket() {
        $this->CaddieManager->clear();
        return ["valider"=>true];
    }
    public function removefrombasket($data=[]) {
        extract($data);
        $r = $this->CaddieManager->delete($id);
        if($r === true){
            return ['valider' => TRUE, 'msg'=>"Retrait de l'item sur la liste effectuée avec succès", 'product'=> $_SESSION['caddie'], 'TAUX' => $_SESSION['TAUX']];
        }else{
            return ['valider'=> false, 'msg'=>"Une erreur est survenue lors du retrait de l'item", 'TAUX' => $_SESSION['TAUX']];
        }
    }
    public function getunite($conditionaddivtive=[]) {
        $this->setDao();
        return $this->dao->getUniteConsommation($conditionaddivtive);
    }
    public function getforme($conditionaddivtive=[]) {
        $this->setDao();
        return $this->dao->getForme($conditionaddivtive);
    }
    
    public function getconservation($conditionaddivtive=[]) {
        $this->setDao();
        return $this->dao->getConservation($conditionaddivtive);
    }
    
    public function changequantity($data=[]) {
        extract($data);
        $r = $this->CaddieManager->changequantity($item, $qte);
        if($r === true){
            return ['valider' => TRUE, 'msg'=>"Retrait de l'item sur la liste effectuée avec succès", 'product'=> $_SESSION['caddie'], 'TAUX' => $_SESSION['TAUX']];
        }else{
            return ['valider' => false, 'msg'=>"Une erreur est surgie lors de la mise à jour de la quantité", 'product'=> $_SESSION['caddie'], 'TAUX' => $_SESSION['TAUX']];
        }       
    }
    
    public function changerMoney($data =[]) {
        extract($data);
        $r = $this->CaddieManager->setMonnaie($money);
        if($r === true){
            $this->CaddieManager->reCalculate();
            return ['valider' => TRUE, 'msg'=>"Changer de monnaie effectué avec succès", 'product'=> $_SESSION['caddie'], 'TAUX' => $_SESSION['TAUX']];
        }else{
            return ['valider' => false, 'msg'=>"Une erreur est surgie lors de la mise à jour de la quantité", 'product'=> $_SESSION['caddie'], 'TAUX' => $_SESSION['TAUX']];
        }
    }
    
    public function valider() {      
        if($_SESSION['user']['idFonction'] == 0 || $_SESSION['user']['idFonction'] == 7 || $_SESSION['user']['idFonction'] == 4){
            if($this->CaddieManager->exist() && $this->CaddieManager->countItem() > 0){
                $this->setDao();
                $r =  $this->dao->facturer($_SESSION['caddie']);
                if($r === true){
                    $refFact = $this->dao->idFacture;
                    $this->CaddieManager->clear();
                    return ['valider' => TRUE, 'msg'=>"Facturation effectuée avec succès. Veuillez imprimer la facture", "idFacture" => $refFact];
                }else{
                    return ['valider' => false, 'msg'=> $this->dao->errors];
                }
            }else{
                return ['valider' => false, 'msg'=> "La carte est vide..., Veuillez la remplir si vous voudriez vraiment facturer"];
            }
        } else {
            if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
                return ['valider' => false, 'msg'=> "Vous n'avez pas des privilèges d'exécuter cette opération..., Veuillez contacter l'administrateur pour plus d'info"];
            }else{
                $this->session->setFlash("Vous n'avez pas de privilège d'executer cette opération");
                $this->redirect($_SERVER['HTTP_REFERER']);
            }
        }
    }
    
    public function getfactureitems($data=[]) {
        $this->setDao();        
        extract($data);
        extract($_GET);
        return $this->dao->getFactureItems($id);
    }
    public function getSalesListe($condition="") {
        $this->setDao();  
        return $this->dao->getSalesListe($condition);
    }
    public function getsalesum($condition=[]) {
        $this->setDao();  
        return $this->dao->getSalesSum($condition);
    }
    
    public function getAllSalesListe($condition=[]) {
        $this->setDao();
        return $this->dao->getSalesListe($condition);
    }
    
    static function getTAux() {
        return ['TAUX' => $_SESSION['TAUX']];
    }
    
}
