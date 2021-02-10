<?php  
    $config = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "config.php";
    $config = str_replace("/", DIRECTORY_SEPARATOR, $config);
    include_once $config;
    $controllerActe = new \controls\Acte();
    $controllerPharmacy =  new controls\Pharmacy();
    if(isset($_SESSION['data'])){
        extract($_SESSION['data']);
    }
    $filariane = array(
        'Actes médicaux' => "/public/actes_medicaux.php",
        'Grille tarifaire' => "/public/grilletarifaire.php",
        'Liste des prix' => ""
    );
    $titlePage = "Grille tarifaire";
    include_once ROOT . DS . "squelette" . DS . "head.php";
    include_once ROOT . DS . "squelette" . DS . "header.php";
    include_once ROOT . DS . "squelette" . DS . "leftNav.php";
    
?>
                <div id="content">
                    <div class="outer">
                    <div class="inner">
                    <div class="main-bar">
                        <h3>
                            <i class="fa fa-dashboard"></i>&nbsp;
                            GRILLE TARIFAIRE
                        </h3>
                        <div class="box-options">
                          
                            <a href="/public/personnel.php?action=del" class="btn btn-primary"><span class="glyphicon glyphicon-print"></span> </a>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <?php
                        ($session->flash());
                        ?> 
                    </div>
                    <?php
                    
                        if(isset($_GET['action'])){
                            switch ($_GET['action']){
                                case 'add':?>
                    <?php
                            }
                        }else{
                    ?>   
                    <div class="col-lg-12">                        
                        <div class="x_content">
                                <div class="" role="tabpanel" data-example-id="togglable-tabs">
                                    <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                                        <!--<li role="presentation" class="active"><a href="/public/grilletarifaire.php?onlget=All">ALL</a></li>-->
                                        <li class="active" role="presentation"><a href="#prixactemedical" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Actes médicaux</a></li>
                                        
                                        <li role="presentation" class=""><a href="#prixexamens" id="" role="tab" data-toggle="tab" aria-expanded="true">Examens</a>
                                        </li>
                                        <li role="presentation" class=""><a href="#pharmacy" role="tab" id="" data-toggle="tab" aria-expanded="false">Pharmacie</a>
                                        </li>
                                        <li role="presentation" class=""><a href="#chambre" role="tab" id="" data-toggle="tab" aria-expanded="false">Chambres/Lits</a>
                                        </li>
                                    </ul>
                                    <div id="myTabContent" class="tab-content">
                                        <div role="tabpanel" class="tab-pane fade active in" id="prixactemedical" aria-labelledby="">
                                            <div class="box">
                                                    <header>
                                                        <h5>TOUS LES ACTES </h5>
                                                        <div class="toolbar">
                                                            <ul class="nav">
                                                                <li>
                                                                    <form action="/controls/control.php?mod=acte&amp;act=getActes" method="get" class="form-inline searchform">
                                                                        <div class=" form-group top_search">
                                                                            <div class="input-group">
                                                                                <input type="text" class="form-control input-acte-price" name="q" placeholder="Recherche...">
                                                                                <span class="input-group-btn">
                                                                                    <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-search"></span></button>
                                                                                </span>
                                                                            </div>
                                                                        </div>                                                    
                                                                    </form>
                                                                </li>
                                                                <li class="dropdown">
                                                                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                                                        Filtre
                                                                        <b class="caret"></b>
                                                                    </a>
                                                                    <ul class="dropdown-menu">
                                                                        <li><a href="">Aujourd'hui</a></li>
                                                                        <li><a href="#">Etape</a></li>
                                                                        <li><a href="#"><i class="icon-external-link"></i>Date</a></li>
                                                                        <li><a href="#"><i class="icon-external-link"></i>Résultat</a></li>
                                                                        <li class="divider"></li>
                                                                        <li><a href="#">Personnalisé</a></li>
                                                                    </ul>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </header>
                                                <div id="" class="body">
                                                    <?php
                                                        $listActes = $controllerActe->getActes();                                                                                                          
                                                        if(count($listActes)> 0){$count = 0;
                                                      
                                                    ?>
                                                        <div id="stripedTable" class="body collapse in">
                                                            <table class="table table-striped responsive-table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Acte</th>                                                            
                                                                        <th>Catégorie</th>
                                                                        <th>Prix Convention</th>
                                                                        <th>Prix Privé</th>
                                                                        <th>Prix Affilié</th>                                                                        
                                                                        <th>&nbsp;</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                        foreach ($listActes as $acte) {$count++;

                                                                        ?>
                                                                    <tr class="">
                                                                        <td><?= $count?></td>
                                                                        <td><?= $acte->acte ?></td>
                                                                        <td>
                                                                            <?= $acte->category ?>
                                                                        </td>
                                                                        <td><?= $acte->prix_conventionne ?></td>
                                                                        <td><?= $acte->prix_prive ?></td>
                                                                        <td><?= $acte->prix_affilier ?></td>
                                                                       
                                                                        <td>
                                                                            <!--
                                                                            <a href=""><span class="glyphicon glyphicon-eye-open"></span></a>
                                                                            <a href=""><span class="glyphicon glyphicon-edit"></span></a>
                                                                            <a href="" class="danger text-danger"><span class="glyphicon glyphicon-remove"></span></a></td>
                                                                            -->
                                                                    </tr>
                                                                   <?php
                                                                        }?>
                                                                </tbody>                
                                                            </table>
                                                        </div>
                                                       
                                                    <!--
                                                        <div class="col-lg-12">
                                                            <ul class="pagination"><li><a href="forum.php&amp;page=1" style="background-color : rgba(240,240,240,.7)">1</a></li><li><a href="forum.php&amp;page=2">2</a></li><li><a href="forum.php&amp;page=3">3</a></li><li><a href="forum.php&amp;page=4">4</a></li><li><a href="forum.php&amp;page=5">5</a></li><li><a href="forum.php&amp;page=6">6</a></li><li><a href="forum.php&amp;page=7">7</a></li><li><a href="forum.php&amp;page=8">8</a></li><li><a href="forum.php&amp;page=9">9</a></li><li><a href="forum.php&amp;page=10">10</a></li><li><a href="forum.php&amp;page=2">&nbsp;<span class="glyphicon glyphicon-forward"></span>&nbsp;</a></li></ul>                                            </div>
                                                    </div>-->
                                                            <?php }?>
                                                </div>
                                        </div>                                        
                                    </div>
                                        <div role="tabpanel" class="tab-pane fade " id="prixexamens" aria-labelledby="">
                                            <div class="box">
                                                    <header>
                                                        <h5>TOUS LES EXAMENS </h5>
                                                        <div class="toolbar">
                                                            <ul class="nav">
                                                                <li>
                                                                    <form action="/controls/control.php" method="get" class="form-inline searchform">
                                                                        <div class=" form-group top_search">
                                                                            <div class="input-group">
                                                                                <input type="text" class="form-control input-examen-price" name="q" placeholder="Recherche...">
                                                                                <span class="input-group-btn">
                                                                                    <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-search"></span></button>
                                                                                </span>
                                                                            </div>
                                                                        </div>                                                    
                                                                    </form>
                                                                </li>
                                                                <li class="dropdown">
                                                                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                                                        Filtre
                                                                        <b class="caret"></b>
                                                                    </a>
                                                                    <ul class="dropdown-menu">
                                                                        <li><a href="">Aujourd'hui</a></li>
                                                                        <li><a href="#">Etape</a></li>
                                                                        <li><a href="#"><i class="icon-external-link"></i>Date</a></li>
                                                                        <li><a href="#"><i class="icon-external-link"></i>Résultat</a></li>
                                                                        <li class="divider"></li>
                                                                        <li><a href="#">Personnalisé</a></li>
                                                                    </ul>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </header>
                                                <div id="" class="body">
                                                    <?php
                                                        $listExamen = $controllerActe->getexamenrices();                                           
                                                        if(count($listActes)> 0){$count = 0;
                                                      
                                                    ?>
                                                        <div id="stripedTable" class="body collapse in">
                                                            <table class="table table-striped responsive-table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Examen</th>                                                            
                                                                        <th>Catégorie</th>
                                                                        <th>Prix Convention</th>
                                                                        <th>Prix Privé</th>
                                                                        <th>Prix Affilié</th>                                                                        
                                                                        <th>&nbsp;</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                        foreach ($listExamen as $examen) {$count++;

                                                                        ?>
                                                                    <tr class="">
                                                                        <td><?= $count?></td>
                                                                        <td><?= $examen->examen ?></td>
                                                                        <td>
                                                                            <?= $examen->category ?>
                                                                        </td>
                                                                        <td><?= $examen->prixconventionne ?></td>
                                                                        <td><?= $examen->prixprive ?></td>
                                                                        <td><?= $examen->prixaffilier ?></td>
                                                                       
                                                                        <td>
                                                                            <!--
                                                                            <a href=""><span class="glyphicon glyphicon-eye-open"></span></a>
                                                                            <a href=""><span class="glyphicon glyphicon-edit"></span></a>
                                                                            <a href="" class="danger text-danger"><span class="glyphicon glyphicon-remove"></span></a></td>
                                                                            -->
                                                                    </tr>
                                                                   <?php
                                                                        }?>
                                                                </tbody>                
                                                            </table>
                                                        </div>
                                                       
                                                    <!--
                                                        <div class="col-lg-12">
                                                            <ul class="pagination"><li><a href="forum.php&amp;page=1" style="background-color : rgba(240,240,240,.7)">1</a></li><li><a href="forum.php&amp;page=2">2</a></li><li><a href="forum.php&amp;page=3">3</a></li><li><a href="forum.php&amp;page=4">4</a></li><li><a href="forum.php&amp;page=5">5</a></li><li><a href="forum.php&amp;page=6">6</a></li><li><a href="forum.php&amp;page=7">7</a></li><li><a href="forum.php&amp;page=8">8</a></li><li><a href="forum.php&amp;page=9">9</a></li><li><a href="forum.php&amp;page=10">10</a></li><li><a href="forum.php&amp;page=2">&nbsp;<span class="glyphicon glyphicon-forward"></span>&nbsp;</a></li></ul>                                            </div>
                                                    </div>-->
                                                            <?php }?>
                                                </div>
                                        </div>                                        
                                    </div>
                                        <div role="tabpanel" class="tab-pane fade " id="pharmacy" aria-labelledby="">
                                            <div class="box">
                                                <header>
                                                        <h5></h5>
                                                        <div class="toolbar">
                                                            <ul class="nav">
                                                                <div class="toolbar">
                                                                    <ul class="nav">
                                                                        <li>
                                                                            <form action="/controls/control.php?mod=acte&amp;act=searchactes" method="get" class="form-inline searchform" autocomplete="off">
                                                                                <div class=" form-group top_search">
                                                                                    <div class="input-group">
                                                                                        <input type="text" class="form-control input-search-product" name="q" placeholder="Recherche...">
                                                                                        <span class="input-group-btn">
                                                                                            <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-search"></span></button>
                                                                                        </span>
                                                                                    </div>
                                                                                </div>
                                                                            </form>
                                                                        </li>
                                                                        <li class="dropdown">
                                                                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                                                                Filtre
                                                                                <b class="caret"></b>
                                                                            </a>
                                                                            <ul class="dropdown-menu">
                                                                                <li><a href="">Aujourd'hui</a></li>
                                                                                <li><a href="#">Etape</a></li>
                                                                                <li><a href="#"><i class="icon-external-link"></i>Date</a></li>
                                                                                <li><a href="#"><i class="icon-external-link"></i>Résultat</a></li>
                                                                                <li class="divider"></li>
                                                                                <li><a href="#">Personnalisé</a></li>
                                                                            </ul>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </ul>
                                                        </div>
                                                    </header>
                                                <div id="" class="body">                                                    
                                                    <?php $listProduit = $controllerPharmacy->getproduct();
                                                        if(count($listProduit['results']) > 0){$count = 0;?>
                                                    <div class="row">
                                                            <div class="col-lg-12">   
                                                                    <div id="optionalTable" class="body collapse in">
                                                                        <table class="table responsive-table" id="list-agents">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>#</th>
                                                                                    <th><span class="glyphicon glyphicon-user"></span>Produit</th>
                                                                                    <th> <span class="glyphicon glyphicon-th-list"></span>Catégorie</th>
                                                                                    <th><span class="glyphicon glyphicon-th"></span>Quantité en stock</th>
                                                                                    <th>Prix Achat</th>
                                                                                    <th>Prix Vente</th>
                                                                                    <th>Quantité Alert</th>
                                                                                    <th>Date Fab</th>
                                                                                    <th>Date Exp</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <?php foreach ($listProduit['results'] as $key => $produit) {
                                                                                    $count++ ?>
                                                                                    <tr>
                                                                                        <td><?= $count ?></td>
                                                                                        <td><a href="/public/pharmacy.php?action=view&id=<?= $produit->id ?>" >
                                                                                                <h5><?= $produit->lib ?></h5></a></td>
                                                                                        <td><?= $produit->libcategory ?></td>
                                                                                        <td><?= $produit->quantite ?></td>
                                                                                        <td><?= $produit->prixachat ?></td>
                                                                                        <td><?= $produit->prixvente ?></td>
                                                                                        <td><?= $produit->qtealert ?></td>
                                                                                        <td><?= $produit->dateFab ?></td>
                                                                                        <td><?= $produit->dateExp ?></td>                                                                                       
                                                                                    </tr>
                                                                                    <?php
                                                                                }
                                                                                ?>
                                                                            </tbody>               
                                                                        </table>
                                                                    </div>                                                                            
                                                            </div>
                                                        </div>
                                                    <?php                                                    
                                                    }
                                                    ?>
                                                </div>
                                        </div>                                        
                                    </div>
                                    <div role="tabpanel" class="tab-pane fade " id="chambre" aria-labelledby=""> 
                                                    <div class="row">
                                                        <div class="box">
                                                                    <header>
                                                                        <h5>TOUTES LES CHAMBRE ET LEUR LIT</h5>
                                                                    </header>
                                                                    <div class="body" id="trigo" style="height: auto;">
                                                                        <?php
                                                                        unset($condition);
                                                                        $condition['order'] = " chambre.id ASC ";
                                                                        $lits = $controllerActe->getlits();
                                                                        $count = 0;
                                                                        if (count($lits) > 0) {
                                                                            ?>
                                                                            <table class="table table-striped responsive-table">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th>#</th>
                                                                                        <th>Lit</th>
                                                                                        <th>Chambre</th>
                                                                                        <th>Category</th>
                                                                                        <th>Occupée</th>
                                                                                        <th>Prix</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    <?php
                                                                                    foreach ($lits as $lit) {
                                                                                        $count++;
                                                                                        ?>
                                                                                        <tr class="">
                                                                                            <td><?= $count ?></td>
                                                                                            <td>
                                                                                                <?= $lit->lit ?>
                                                                                            </td>
                                                                                            <td><?= $lit->chambre ?></td>
                                                                                            <td><?= $lit->category ?></td>
                                                                                            <td><?= $lit->busy ?></td>
                                                                                            <td>                                                                             
                                                                                                <?= $lit->prix ?>$
                                                                                            </td>
                                                                                        </tr> 
                                                                                    <?php }
                                                                                    ?>
                                                                                </tbody>                
                                                                            </table>
                                                                            <?php
                                                                        }else{?>
                                                                            <div class="row"><div class="col-md-12"><h5 class="text-center alert alert-info alert-secondary alert-dismissible">Aucun lit n'est enregistré</h5> </div></div>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                </div>       
                                                    </div>                         
                                    </div>    
                                        
                                </div>
                                    <bR><br><BR>
                            </div>
                        <div class="col-lg-12">
                            
                        </div>
                    </div>
                        <!-- /.inner -->
                    </div>
                    <?php
                        }
                    ?>
                    </div>
                    <!-- /.outer -->
                </div>


<?php
$config = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "config.php";
$config = str_replace("/", DIRECTORY_SEPARATOR, $config);
include_once $config;
include_once ROOT . DS . "squelette" . DS . "footer.php";
include_once ROOT . DS . "squelette" . DS . "endPage.php";
?>