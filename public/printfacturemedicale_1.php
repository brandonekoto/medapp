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
        $seeActe = $controller->getlistacte($_GET);
        if(count($seeActe) > 0){
            $condition = " WHERE consultation.id_acte= ".$_GET['id'];  
            $condition .= " ORDER BY consultation.date DESC ";                                                               
            $consultationInfo = $controller->getconsultations($condition);
            $sstotalConsultation = 0;
            $sstotalexamens = 0;
            $sstotalnursing = 0;
            unset($condition);
            $condition = " WHERE acte_pose.id= ".$_GET['id'];        
            $examens = $controller->getcustomexamenitem($condition);
            $nursings = $controller->getnursing(['id'=>$_GET['id']]);
            $total = 0;
            $seeActe = $seeActe[0];
        var_dump($seeActe);
        ?>
<div id="wrapFacture">
    <div id="factureHeader">
        <img src="/img/rubis.png">
        <p>Adresse :  111, Av Dilolo, blvd kasava-vubu,<br>Commune de Kinshasa<br>Tél : +243 81 744 736 65<br>Email ; contact@grouperubis.org<br>www.grouperubis.org<br>Rép. Dém. du Congo</p>
    </div>
    
    <hr>
    <h3 class="titre">
        FACTURE PATIENT N°<?= $_GET['id'] ?>
    </h3>
    <div class="row" style="margin: 20px">        
        <div class="col-lg-12 personne-info">
            <div class="line-personne-info"><span class="champ">Sujet :</span><span class="val-line-personne-info"><?= $seeActe->nompatient . " " . $seeActe->postnompatient . " " . $seeActe->prenompatient ?></span></div> 
            <div class="line-personne-info"><span class="champ">Type :</span><span class="val-line-personne-info">Ordinaire</span></div>    
            <div class="line-personne-info"><span class="champ">Réf fiche :</span><span class="val-line-personne-info"><?= $seeActe->idPatient?></span></div>    
            <div class="line-personne-info"><span class="champ">Réf Acte :</span><span class="val-line-personne-info"><?= $seeActe->idactepose?></span></div>
            <div class="line-personne-info"><span class="champ">Réf Acte :</span><span class="val-line-personne-info"><?= ucwords($seeActe->acte)?></span></div>
        </div>
    </div>
    <div class="print-message alert alert-warning">
        Ne pas quitter cette page avant l'impression ou la copie de la référénce facture.
    </div>
    <div class="list_article">
        
        <?php
           if(count($consultationInfo) > 0){               
            $count = 0;            
        ?>
        <div style="padding: 10px" class=" bg-blue btn-grad text-center"><h4>Consultations</h4></div>
        <table class="table table-bordered" style="background: transparent">
            <thead>
                <tr>
                    <th>
                        &nbsp;
                    </th>
                    <th style="text-align: left">Date</th>
                    <th>Prix</th>
                    
                </tr>
            </thead>
            <tbody>
                    <?php
                            foreach ($consultationInfo as $value) {     
                               $sstotalConsultation += $value->prixConsultation;
                    ?>
                    <tr>
                        <td><?= ++$count ?></td>
                    <th><?= $value->dateconsultation ?></th>
                    <th><?= $value->prixConsultation ?></th>
                
                    
                    </tr>
                    <?php
                            }
                    ?>
            </tbody>
            <tfoot>
                <tr class="bg-blue">
                    <td colspan="2" style="text-align: left"> Sous Total</td>                    
                    <td colspan="1" > <?= $sstotalConsultation ?> USD</td>                    
                </tr>
                <tr class="bg-blue">
               
                    <td colspan="2" style="text-align: left"> Sous Total en Franc</td>                    
                    <td colspan="1" ><?= $sstotalConsultation * $_SESSION['TAUX']?> CDF</td>
                </tr>
            </tfoot>
        </table>
        <?php
           }
           
           if(count($examens) > 0){               
            $count = 0;  
        ?>
        <div style="padding: 10px" class=" bg-blue btn-grad text-center"><h4>Examens</h4></div>
        <table class="table table-bordered" style="background: transparent">
            <thead>
                <tr>
                    <th>
                        &nbsp;
                    </th>
                    <th style="text-align: left">Libellé</th>
                    <th>Prix</th>
                </tr>
            </thead>
            <tbody>
                    <?php
                            foreach ($examens as $value) {     
                               $sstotalexamens += $value->prixexamen;
                    ?>
                    <tr>
                     
                    <th><?= ++$count ?></th>
                    <th><?= $value->libexamen ?></th>
                    <th><?= $value->prixexamen ?></th>
                
                    
                    </tr>
                    <?php
                            }
                    ?>
         
            </tbody>
            <tfoot>
                <tr class="bg-blue">
                    <td colspan="2" style="text-align: left"> Sous Total</td> 
                    <td colspan="1" ><?= $sstotalexamens ?> USD</td>                    
                </tr>
                <tr class="bg-blue">               
                    <td colspan="2" style="text-align: left"> Sous Total en Franc</td>       
                    <td colspan="1" ><?= $sstotalexamens * $_SESSION['TAUX'] ?> CDF</td>
                </tr>
            </tfoot>
        </table>
        <?php
           }
           if(count($nursings) > 0){               
            $count = 0;  
           
        ?>
        
        <div style="padding: 10px" class=" bg-blue btn-grad text-center"><h4>Nurnings</h4></div>
        <table class="table table-bordered" style="background: transparent">
            <thead>
                <tr>
                    <th>
                        &nbsp;
                    </th>
                    <th style="text-align: left">Libellé</th>
                    <th style="text-align: left">Date</th>
                    <th>Prix</th>
                </tr>
            </thead>
            <tbody>                
                <?php
                            foreach ($nursings as $value) {     
                               $sstotalnursing += $value->prixsoin;
                    ?>
                    <tr>
                            <td><?= ++$count?></td>
                        <th><?= $value->nursingpose ?></th>
                        <th><?= $value->date ?></th>
                        <th><?= $value->prixsoin ?></th>
                    </tr>
                    <?php
                            }?>
            </tbody>
            <tfoot>
                <tr class="bg-blue">
                    <td colspan="2" style="text-align: left"> Sous Total</td>    
                    <td>&nbsp;</td>
                    <td colspan="1" ><?= $sstotalnursing ?> USD</td>                    
                </tr>
                <tr class="bg-blue">               
                    <td colspan="2" style="text-align: left"> Sous Total en Franc</td>     
                    <td>&nbsp;</td>
                    <td colspan="1" ><?= $sstotalnursing * $_SESSION['TAUX'] ?> CDF</td>
                </tr>
            </tfoot>
        </table>
        <?php
           }
           $ttgeneral = $sstotalConsultation + $sstotalexamens + $sstotalnursing;
           $net  = $ttgeneral + (($ttgeneral * hospital\core\dao\Pharmacy::TVA) / 100 ) ;
        ?>
        <div>
            <div class="col-lg-12 personne-info bg-dark" style="color : #ffffff">
                <div class="line-personne-info"><span class="champ">Total général :</span><span class="val-line-personne-info"><?= $sstotalConsultation + $sstotalexamens + $sstotalnursing?> USD ($)</span></div> 
                
                <div class="line-personne-info"><span class="champ">Net à payer :</span><span class="val-line-personne-info"><?= $net?> USD ($)</span></div>
                <div class="line-personne-info"><span class="champ">En CDF :</span><span class="val-line-personne-info"><?= $net  * $_SESSION['TAUX']?> CDF </span></div>                 
            </div>
        </div>
        <br><br>
        <div>
            <div class="col-lg-12 personne-info">
                <div class="line-personne-info"><span class="champ">Date :</span><span class="val-line-personne-info"><?= Date::dateToFr(date("D-m-Y"))?></span></div> 
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
