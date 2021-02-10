<?php  
    $config = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "config.php";
    $config = str_replace("/", DIRECTORY_SEPARATOR, $config);
    include_once $config;
    $controller = new \controls\Acte();    
    use Helpers\Date;
    if(isset($_SESSION['data'])){
        extract($_SESSION['data']);
    }
    include_once ROOT . DS . "squelette" . DS . "head.php";
    if(isset($_GET['id'])){
        $fiche;
        $seeActe = $controller->getlistacte($_GET);
        if(count($seeActe) > 0){
            $seeActe = $seeActe[0];
        ?>
<div id="wrapFacture">
    <div class="print-message alert alert-warning">
        Ne pas quitter cette page avant l'impression ou la copie de la référénce facture.
    </div>
    <div class="row text-center"><a class="btn btn-grad btn-metis-1" href="/public/actes_medicaux.php?action=view&id=<?=$_GET['id']?>"><i class="glyphicon glyphicon-backward"></i>  Back</a></div>
    <a href="#" class="printpage btn btn-grad btn-metis-3"> <i class="glyphicon glyphicon-print"></i> Imprimer facture</a> 
    <div class="col-lg-12">
                <?php
                ($session->flash());
                ?> 
            </div>

    <h3 class="titre">
        JETON N°<?= $_GET['id'] ?>
    </h3>
    <div class="row">        
        <div class="col-lg-12 personne-info">
            <div class="line-personne-info"><span class="champ">Sujet :</span><span class="val-line-personne-info"><?= $seeActe->nompatient . " " . $seeActe->postnompatient . " " . $seeActe->prenompatient ?></span></div> 
            <div class="line-personne-info"><span class="champ">Type :</span><span class="val-line-personne-info">Ordinaire</span></div>    
            <div class="line-personne-info"><span class="champ">Réf fiche :</span><span class="val-line-personne-info"><?= $seeActe->idPatient?></span></div>    
            <div class="line-personne-info"><span class="champ">Réf Acte :</span><span class="val-line-personne-info"><?= $seeActe->idactepose?></span></div>
            <div class="line-personne-info"><span class="champ">Motif :</span><span class="val-line-personne-info"><?= ucwords($seeActe->acte)?></span></div>
        </div>
    </div>
     
    <div class="list_article">       
        <div>
            <div class=" personne-info">
                <div class="line-personne-info"><span class="champ">Date :</span><span class="val-line-personne-info"><?= Date::dateToFr(date("D-m-Y"), "%d/%m/%y")?></span></div> 
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
