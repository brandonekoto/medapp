<?php  
    $config = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "config.php";
    $config = str_replace("/", DIRECTORY_SEPARATOR, $config);
    include_once $config;
    $controller = new \controls\Pharmacy();    
    use Helpers\Date;
    if(isset($_SESSION['data'])){
        extract($_SESSION['data']);
    }
    $listCategory = $controller->getcategory();
    $listfournisseur = $controller->getfournisseurs();
    include_once ROOT . DS . "squelette" . DS . "head.php";
    if(isset($_GET['id'])){
        $r = $controller->getfactureitems(); 
        $condition = " WHERE vente.id = '".$_GET['id']."'";
        $s = $controller->getSalesListe($condition);
        $taux= $s[0]->tauxapplique ;
         if (count($r) > 0) {
                $total = 0;
        ?>
<div id="wrapFacture">
   
    <div id="factureHeader">
        <img src="/img/rubis.png">
        <p>Adresse :  111, Av Dilolo, blvd kasava-vubu,<br>Commune de Kinshasa<br>Tél : +243 81 744 736 65<br>Email ; contact@grouperubis.org<br>www.grouperubis.org<br>Rép. Dém. du Congo</p>
    </div>
    <hr>
    <h3 class="titre">
        FACTURE N°<?= $_GET['id'] ?>
    </h3>
    <div class="print-message alert alert-warning">
        Ne pas quitter cette page avant l'impression ou la copie de la référénce facture.
    </div>
     <br>
     
    <a href="#" class="printpage btn btn-grad btn-metis-3"> <i class="glyphicon glyphicon-print"></i> Imprimer facture</a>  
    <div class="list_article">
      
        <table class="table table-bordered" style="background: transparent">
            <thead>
                <tr>
                    <th>
                        &nbsp;
                    </th>
                    <th style="text-align: left">Quantité</th>
                    <th>Désignation</th>
                    <th>Prix total</th>
                </tr>
            </thead>
            <tbody>
                <?php                 
                    foreach ($r as $item) {
                    ?>
                    <tr>
                        <td>&nbsp;</td>
                    <th><?= $item->qtebuy ?></th>
                    <th><?= $item->designation ?></th>
                    <th><?= $item->qtebuy * $item->prixvente ?>$</th>
                    </tr>
               <?php
                $total += $item->qtebuy * $item->prixvente;
                    }
               ?>
            </tbody>
            <tfoot>
                <tr class="bg-blue">
                    <td>&nbsp;</td>
                    <td colspan="2" style="text-align: left"> Total</td>                    
                    <td colspan="1" style="font-weight: bolder" ><?= number_format($total, 3, ",", " ")?> USD</td>                    
                </tr>
                <tr class="bg-blue">
                    <td>&nbsp;</td>
                    <td colspan="2" style="text-align: left; "> Total à payer</td>                    
                    <td colspan="1" style="font-weight: bolder" ><?= number_format(($total + (($total * 17)/100) ), 3, ",", " " )?> USD</td>
                </tr>
                <tr class="bg-blue">
                    <td>&nbsp;</td>
                    <td colspan="2" style="text-align: left; "> Total en Franc</td>                    
                    <td colspan="1" style="font-weight: bolder" ><?= number_format(($total + (($total * 17)/100) )* $taux, 3, ",", " ")?> CDF</td>
                </tr>
            </tfoot>
        </table>
        <div>
            
            <div class="col-lg-12 personne-info">
                <div class="line-personne-info"><span class="champ">Date :</span><span class="val-line-personne-info"><?= $r[0]->datevente ?></span></div> 
                <div class="line-personne-info"><span class="champ">Agent :</span><span class="val-line-personne-info"><?= $_SESSION['user']['username'] ?></span></div>                 
            </div>
        </div>
    </div>
</div>

<?php
     }else{?>
     <div class="row"><h2 class="text-center alert alert-info alert-secondary alert-dismissible">Aucune facture n'est associée à cette référence</h2> </div>
<?php
         
     }
    } else {?>
<div class="row"><h2 class="text-center alert alert-info alert-secondary alert-dismissible">Vous n'avez séléctionné aucune facture à imprimer</h2> </div>
<?php
        
    }

include_once ROOT . DS . "squelette" . DS . "endPage.php";
if(isset($_SESSION['data'])){
    unset($_SESSION['data']);
}
