<?php  
    $config = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "config.php";
    $config = str_replace("/", DIRECTORY_SEPARATOR, $config);
    include_once $config;
    use Helpers\Date;
    if(isset($_SESSION['data'])){
        extract($_SESSION['data']);
    }
    //$listPatient = $controller->getList();
    $controller = new \controls\Consultation();
    $controllerActe =  new controls\Acte();
    $controllerPatient = new controls\Patient();    
    $listActes =  $controllerActe->getActes();
    $listPatiens =  $controllerPatient->getList();
    if(isset($_GET['id']) && !empty($_GET['id'])){
        
    }
    include_once ROOT . DS . "squelette" . DS . "head.php";
    include_once ROOT . DS . "squelette" . DS . "header.php";
    include_once ROOT . DS . "squelette" . DS . "leftNav.php";
?>
                <div id="content">
                    <div class="outer">
                        <div class="inner bg-light lter">
                            <div class="main-bar">
                                <h3>
                                    <i class="fa fa-dashboard"></i>&nbsp;
                                    CONSULTATION
                                </h3>
                                <div class="box-options">
                                    <a href="/public/consultation.php?action=add" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> </a>
                                    <a href="/public/consultation.php?action=del" class="btn btn-primary"><span class="glyphicon glyphicon-print"></span> </a>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <?php
                                ($session->flash());
                                ?> 
                            </div>
                            <?php
                                if(isset($_GET['action'])){
                                    switch ($_GET['action']) {
                                        case "add":?>
                            <div class="">
                                <?php
                                    if(isset($_GET['etape'])){
                                        switch ($_GET['etape']) {
                                            case 1:
                                                

                                                break;
                                            ?>
                                <?php
                                            default:
                                                break;
                                        }
                                    }
                                ?>
                                <div class="col-md-12">
                                                <div class="content-box-large">
                                                    <div class="panel-heading">
                                                        <div class="panel-title"></div>

                                                        <div class="panel-options">
                                                            <a href="#" data-rel="collapse"><i class="glyphicon glyphicon-refresh"></i></a>
                                                            <!--<a href="#" data-rel="reload"><i class="glyphicon glyphicon-cog"></i></a>-->
                                                        </div>
                                                    </div>
                                                    <div class="panel-body">
                                                        <div id="rootwizard">
                                                            <div class="navbar">
                                                                <div class="navbar-inner">
                                                                    <div class="container">
                                                                        <ul class="nav nav-pills">
                                                                            <li class="active"><a href="#tab1" data-toggle="tab">Entretien</a></li>
                                                                            <li><a href="#tab2" data-toggle="tab">Diagnostic</a></li>
                                                                            <li><a href="#tab3" data-toggle="tab">Labo</a></li>
                                                                            <li><a href="#tab3" data-toggle="tab">Prescription</a></li>
                                                                            
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="tab-content">
                                                                <div class="tab-pane active" id="tab1">
                                                                    <div style="height: 300px; width: 100%;" class="bg-batthern  text-center vertical">
                                                                        <br><br>
                                                                        <h1 class="text-success">CONSULTATION CREEE AVEC SUCCEES</h1>
                                                                        <p>Voici le détail pour cette consultation</p>
                                                                        
                                                                        
                                                                    </div>
                                                                    <!--
                                                                    <form class="form-horizontal" role="form" action="/controls/control.php?mod=consultation&act=add" method="post">
                                                                        <div class="form-group">
                                                                            <label for="inputEmail3" class="col-sm-2 control-label">Patient</label>
                                                                            <div class="col-sm-10">
                                                                                <select class="form-control" name="patient">
                                                                                    <?php
                                                                                        if(count($listPatiens['results']) > 0){
                                                                                           
                                                                                            foreach ($listPatiens['results'] as $key => $itemPatient) {?>
                                                                                    <option value="<?=$itemPatient->idPatient?>"><?= $itemPatient->nom . " " . $itemPatient->postnom?></option>
                                                                                    <?php
                                                                                                
                                                                                            }
                                                                                        }
                                                                                    ?>
                                                                                    
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div  class="form-group">
                                                                            <div class="col-sm-2">
                                                                                
                                                                            </div>
                                                                            <div class="col-sm-10" id="patientInfo">
                                                                                <div class="profile col-lg-3">
                                                                                    <div class="wrapImgProfile">
                                                                                        <img src="/img/personnel/10981441_932904300076295_8167041328504341445_n.jpg"/>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-9">
                                                                                    <table class="table table-striped">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td>Age</td>
                                                                                                <td>27 ans</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>Genre</td>
                                                                                                <td>Masculin</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>Groupe sanguin</td>
                                                                                                <td>A</td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="inputEmail3" class="col-sm-2 control-label">Acte médical</label>
                                                                            <div class="col-sm-10">
                                                                                <select class="form-control" name="acte_medical">
                                                                                    <?php 
                                                                                    $cle = null;                                                                                                                   
                                                                                        if(count($listActes) > 0){
                                                                                            foreach ($listActes as $key => $itemActe) { 
                                                                                                
                                                                                                if($cle !== $itemActe->id_cat){ ?>
                                                                                                    <optgroup label="<?= $itemActe->category?>" data-category_acte='<?= $itemActe->id_cat?>'>
                                                                                                        <option value="<?= $itemActe->id?>" data-category_acte='<?= $itemActe->id_cat?>' data-id='<?= $itemActe->id?>' ><?= $itemActe->acte?></option>
                                                                                                    
                                                                                    <?php
                                                                                                    $cle = $itemActe->id_cat;
                                                                                                    
                                                                                                }else{?>
                                                                                                        <option value="<?= $itemActe->id?>" data-category_acte='<?= $itemActe->id_cat?>'  data-id='<?= $itemActe->id?>'><?= $itemActe->acte?></option>
                                                                                                        <?php
                                                                                                    
                                                                                                }
                                                                                                
                                                                                                
                                                                                               ?>
                                                                                                <?php
                                                                                                
                                                                                                
                                                                                            }
                                                                                        }
                                                                                    ?>
                                                                                    
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-sm-2 control-label">Anamnèse</label>
                                                                            <div class="col-sm-10">
                                                                                <textarea class="form-control" name="anamnese" placeholder="Textarea" rows="3"></textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="inputPassword3" class="col-sm-2 control-label">Signes vitaux</label>                                                                
                                                                            <div class="col-sm-10" style="padding-left: 0; padding-right: 0" >
                                                                                <div class="" style="height: auto; overflow: auto">
                                                                                        <div class="col-lg-6">
                                                                                            <input type="text" name="poids" class="form-control" id="inputPassword3" placeholder="Poids">
                                                                                        </div>
                                                                                        <div class="col-lg-6">
                                                                                            <input type="text" name="taille" class="form-control" id="inputPassword3" placeholder="Taille">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="" style="padding-top: 13px">                                                                                        
                                                                                        <div class="col-lg-6">
                                                                                            <input type="number" name="temperature" class="form-control" id="inputPassword3" placeholder="Température (C°)">
                                                                                        </div>
                                                                                        <div class="col-lg-6">
                                                                                            <input type="number" name="tension" class="form-control" id="inputPassword3" placeholder="Tension ">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <button  type="submit" class="form-control btn btn-metis-6 btn-grad"><i class="glyphicon glyphicon-save-file"></i> Enregistrer</button>
                                                                        </div>
                                                                        
                                                                    </form>-->
                                                                </div>
                                                                <div class="tab-pane" id="tab2">
                                                                    <form class="form-horizontal" role="form">
                                                                        <div class="form-group">
                                                                            <label for="inputEmail3" class="col-sm-2 control-label">Recherche acte</label>
                                                                            <div class="col-sm-10">
                                                                                <div class="input-group">
                                                                                    <input type="text" class="form-control" placeholder="Recherche Réf Acte/Consultation...">
                                                                                    <span class="input-group-btn">
                                                                                        <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-search"></span></button>
                                                                                    </span>
                                                                                </div>
                                                                                <input type="search" class="form-control" id="inputPassword3" placeholder="Réf Acte/Consultation">
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="inputEmail3" class="col-sm-2 control-label">Patient</label>
                                                                            <div class="col-sm-10">
                                                                                <select class="form-control">
                                                                                    <option>KAPENA PATRICK</option>
                                                                                    <option>Atlanta</option>

                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <div class="col-sm-2">
                                                                                
                                                                            </div>
                                                                            <div class="col-sm-10" id="patientInfo">
                                                                                <div class="profile col-lg-3">
                                                                                    <div class="wrapImgProfile">
                                                                                        <img src="/img/personnel/10981441_932904300076295_8167041328504341445_n.jpg">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-9">
                                                                                    <table class="table table-striped">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td>Age</td>
                                                                                                <td>27 ans</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>Genre</td>
                                                                                                <td>Masculin</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>Groupe sanguin</td>
                                                                                                <td>A</td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="inputEmail3" class="col-sm-2 control-label">Examens</label>
                                                                            <div class="col-sm-10">
                                                                                <select class="form-control">
                                                                                    <optgroup label="Pediatrie">
                                                                                        <option>VIH</option>
                                                                                        <option>Atlanta</option>
                                                                                    </optgroup>
                                                                                    <optgroup label="Chirurgie">
                                                                                        <option>KAPENA PATRICK</option>
                                                                                        <option>Atlanta</option>
                                                                                    </optgroup>
                                                                                    <optgroup label="Gyneco">
                                                                                        <option>KAPENA PATRICK</option>
                                                                                        <option>Atlanta</option>
                                                                                    </optgroup>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-sm-2 control-label">Observations</label>
                                                                            <div class="col-sm-10">
                                                                                <textarea class="form-control" placeholder="Textarea" rows="6"></textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <div class="col-sm-offset-2 col-sm-10">
                                                                              <div class="checkbox">
                                                                                <label>
                                                                                  <input type="checkbox"> Hospitaliser ?
                                                                                </label>
                                                                              </div>                                                                              
                                                                            </div>
                                                                          </div>                                                                        
                                                                    </form>
                                                                </div>
                                                                <div class="tab-pane" id="tab3">
                                                                    <form class="form-horizontal" role="form">
                                                                        <div class="form-group">
                                                                            <label for="inputEmail3" class="col-sm-2 control-label">Recherche acte</label>
                                                                            <div class="col-sm-10">
                                                                                <div class="input-group">
                                                                                    <input type="text" class="form-control" placeholder="Recherche Réf Acte/Consultation...">
                                                                                    <span class="input-group-btn">
                                                                                        <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-search"></span></button>
                                                                                    </span>
                                                                                </div>
                                                                                <!--<input type="search" class="form-control" id="inputPassword3" placeholder="Réf Acte/Consultation">-->
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="inputEmail3" class="col-sm-2 control-label">Patient</label>
                                                                            <div class="col-sm-10">
                                                                                <select class="form-control">
                                                                                    <option>KAPENA PATRICK</option>
                                                                                    <option>Atlanta</option>

                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <div class="col-sm-2">
                                                                                
                                                                            </div>
                                                                            <div class="col-sm-10" id="patientInfo">
                                                                                <div class="profile col-lg-3">
                                                                                    <div class="wrapImgProfile">
                                                                                        <img src="/img/personnel/10981441_932904300076295_8167041328504341445_n.jpg">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-9">
                                                                                    <table class="table table-striped">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td>Age</td>
                                                                                                <td>27 ans</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>Genre</td>
                                                                                                <td>Masculin</td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td>Groupe sanguin</td>
                                                                                                <td>A</td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="inputEmail3" class="col-sm-2 control-label">Exa. Recommandé</label>
                                                                            <div class="col-sm-10">
                                                                                <select class="form-control">
                                                                                    <optgroup label="Pediatrie">
                                                                                        <option>VIH</option>
                                                                                        <option>Atlanta</option>
                                                                                    </optgroup>
                                                                                    <optgroup label="Chirurgie">
                                                                                        <option>KAPENA PATRICK</option>
                                                                                        <option>Atlanta</option>
                                                                                    </optgroup>
                                                                                    <optgroup label="Gyneco">
                                                                                        <option>KAPENA PATRICK</option>
                                                                                        <option>Atlanta</option>
                                                                                    </optgroup>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-sm-2 control-label">Résultats</label>
                                                                            <div class="col-sm-10">
                                                                                <textarea class="form-control" placeholder="Textarea" rows="6"></textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-sm-2 control-label">Observations</label>
                                                                            <div class="col-sm-10">
                                                                                <textarea class="form-control" placeholder="Textarea" rows="6"></textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <div class="col-sm-offset-2 col-sm-10">
                                                                              <div class="checkbox">
                                                                                <label>
                                                                                  <input type="checkbox"> Fait ?
                                                                                </label>
                                                                              </div>                                                                              
                                                                            </div>
                                                                          </div>
                                                                        
                                                                        
                                                                    </form>
                                                                </div>
                                                                <ul class="pager wizard">
                                                                    <li class="previous first disabled" style="display:none;"><a href="javascript:void(0);">First</a></li>
                                                                    <li class="previous disabled"><a href="javascript:void(0);">Previous</a></li>
                                                                    <li class="next last" style="display:none;"><a href="javascript:void(0);">Last</a></li>
                                                                    <li class="next"><a href="javascript:void(0);">Next</a></li>
                                                                </ul>
                                                            </div>	
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                            </div>
                            <?php


                                            break;

                                        default:
                                            break;
                                    }
                                }else{
                            ?>
                            <div class="text-center">
                                <ul class="stats_box">
                                    <li>
                                        <div class="sparkline bar_week"></div>
                                        <div class="stat_text">
                                            <strong>345</strong>Hospitalisés
                                            <span class="percent down"> <i class="fa fa-caret-down"></i> -16</span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="sparkline line_day"></div>
                                        <div class="stat_text">
                                            <strong>165</strong>en voix de sortie
                                            <span class="percent up"> <i class="fa fa-caret-up"></i> 3</span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="sparkline pie_week"></div>
                                        <div class="stat_text">
                                            <strong>34</strong>en état critique
                                            <span class="percent"> 0%</span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="sparkline stacked_month"></div>
                                        <div class="stat_text">
                                            <strong>78</strong>A transferer
                                            <span class="percent down"> <i class="fa fa-caret-down"></i> 5</span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <hr>
                            <div class="text-center">
                                <a class="quick-btn" href="#">
                                    <i class="fa fa-bolt fa-2x"></i>
                                    <span>Gyneco</span>
                                    <span class="label label-default">2</span>
                                </a>
                                <a class="quick-btn" href="#">
                                    <i class="fa fa-check fa-2x"></i>
                                    <span>Pediatrie</span>
                                    <span class="label label-danger">2</span>
                                </a>
                                <a class="quick-btn" href="#">
                                    <i class="fa fa-building-o fa-2x"></i>
                                    <span>Maternité</span>
                                    <span class="label label-danger">2</span>
                                </a>
                                <a class="quick-btn" href="#">
                                    <i class="fa fa-envelope fa-2x"></i>
                                    <span>M. Directeur</span>
                                    <span class="label label-success">56</span>
                                </a>
                                <a class="quick-btn" href="#">
                                    <i class="fa fa-signal fa-2x"></i>
                                    <span>Labo</span>
                                    <span class="label label-warning">25</span>
                                </a>
                                <a class="quick-btn" href="#">
                                    <i class="fa fa-external-link fa-2x"></i>
                                    <span>Radiologie</span>
                                    <span class="label btn-metis-2">3</span>
                                </a>
                                <a class="quick-btn" href="#">
                                    <i class="fa fa-lemon-o fa-2x"></i>
                                    <span>Hospitalisés</span>
                                    <span class="label btn-metis-4">11</span>
                                </a>
                                <a class="quick-btn" href="#">
                                    <i class="fa fa-glass fa-2x"></i>
                                    <span>Operation</span>
                                    <span class="label btn-metis-3">1.618</span>
                                </a>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="box">
                                        <header>
                                            <h5>AUJOURD'HUI</h5>
                                        </header>
                                        <div class="body" id="trigo" style="height: auto;">
                                            <div id="stripedTable" class="body collapse in">
                                                <table class="table table-striped responsive-table">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Patient</th>
                                                            <th># Fiche </th>
                                                            <th>Etat</th>
                                                            <th>Service</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr class="danger">
                                                            <td>1</td>
                                                            <td>
                                                                <a href="/controls/control.php?mod=patient&act=view&id=" ><img src="/img/personnel/10981441_932904300076295_8167041328504341445_n.jpg" class="user-profile"/>
                                                        <h5>BRANDON EKOTO</h5></a>
                                                            </td>
                                                            <td>2152</td>
                                                            <td>Critique</td>
                                                            <td>Gyneco</td>
                                                        </tr>
                                                        <tr class="">
                                                            <td>2</td>
                                                            <td>
                                                                <a href="/controls/control.php?mod=patient&act=view&id=" ><img src="/img/personnel/10981441_932904300076295_8167041328504341445_n.jpg" class="user-profile"/>
                                                        <h5>PATRICK KAPENA</h5></a>
                                                            </td>
                                                            <td>2152</td>
                                                            <td>Critique</td>
                                                            <td>Pediatrie</td>
                                                        </tr>
                                                        <tr class="">
                                                            <td>1</td>
                                                            <td>
                                                                <a href="/controls/control.php?mod=patient&act=view&id=" ><img src="/img/personnel/10981441_932904300076295_8167041328504341445_n.jpg" class="user-profile"/>
                                                        <h5>JAELLE MAKONGA</h5></a>
                                                            </td>
                                                            <td>2152</td>
                                                            <td>Critique</td>
                                                            <td>Ophtamologie</td>
                                                        </tr>
                                                        
                                                    </tbody>                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="box">
                                        <header>
                                            <h5>EXAMEN EN LABO</h5>
                                        </header>
                                        <div class="body">
                                            <table class="table table-condensed table-hovered sortableTable">
                                                <thead>
                                                    <tr>
                                                        <th>Fiche <i class="fa sort"></i></th>
                                                        <th>Examen <i class="fa sort"></i></th>
                                                        <th>Niveau <i class="fa sort"></i></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="active">
                                                        <td>2152</td>
                                                        <td>VIH</td>
                                                        <td>En cours</td>
                                                    </tr>
                                                   
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="box">
                                        <header>
                                            <h5>TOUTES LES CONSULTATIONS</h5>
                                            <div class="toolbar">
                                                <ul class="nav">
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
                                            <div id="stripedTable" class="body collapse in">
                                                <table class="table table-striped responsive-table">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Ref consultation</th>                                                            
                                                            <th>Patient</th>
                                                            <th>Etape</th>
                                                            <th>Exa. récommandés</th>
                                                            <th>Résultat</th>
                                                            <th>Date</th>
                                                            <th>&nbsp;</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr class="">
                                                            <td>1</td>
                                                            <td>25</td>
                                                            <td>
                                                                <a href="/controls/control.php?mod=patient&amp;act=view&amp;id="><img src="/img/personnel/10981441_932904300076295_8167041328504341445_n.jpg" class="user-profile">
                                                                    <h5>BRANDON EKOTO</h5></a>
                                                            </td>
                                                            <td>Infirmier</td>
                                                            <td>2</td>
                                                            <td>Critique</td>
                                                            <td>Non disponible</td>
                                                            <td>
                                                                <a href=""><span class="glyphicon glyphicon-eye-open"></span></a>
                                                                <a href=""><span class="glyphicon glyphicon-edit"></span></a>
                                                                <a href="" class="danger text-danger"><span class="glyphicon glyphicon-remove"></span></a></td>
                                                                
                                                        </tr>
                                                        <tr class="">
                                                            <td>2</td>
                                                            <td>26</td>
                                                            <td>
                                                                <a href="/controls/control.php?mod=patient&amp;act=view&amp;id="><img src="/img/personnel/10981441_932904300076295_8167041328504341445_n.jpg" class="user-profile">
                                                                    <h5>BRANDON EKOTO</h5></a>
                                                            </td>
                                                            <td>Medecin</td>
                                                            <td>2</td>
                                                            <td>Critique</td>
                                                            <td>Non disponible</td>
                                                            <td>
                                                                <a href=""><span class="glyphicon glyphicon-eye-open"></span></a>
                                                                <a href=""><span class="glyphicon glyphicon-edit"></span></a>
                                                                <a href="" class="danger text-danger"><span class="glyphicon glyphicon-remove"></span></a></td>
                                                                
                                                        </tr>
                                                        <tr class="">
                                                            <td>3</td>
                                                            <td>27</td>
                                                            <td>
                                                                <a href="/controls/control.php?mod=patient&amp;act=view&amp;id="><img src="/img/personnel/10981441_932904300076295_8167041328504341445_n.jpg" class="user-profile">
                                                                    <h5>BRANDON EKOTO</h5></a>
                                                            </td>
                                                            <td>Labo</td>
                                                            <td>2</td>
                                                            <td>Critique</td>
                                                            <td>Non disponible</td>
                                                            <td>
                                                                <a href=""><span class="glyphicon glyphicon-eye-open"></span></a>
                                                                <a href=""><span class="glyphicon glyphicon-edit"></span></a>
                                                                <a href="" class="danger text-danger"><span class="glyphicon glyphicon-remove"></span></a></td>
                                                                
                                                        </tr>

                                                    </tbody>                </table>
                                            </div>
                                            <div class="col-lg-12">
                                                <?= composants\Utilitaire::pagination(200, 20) ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                                }
                            ?>
                        </div>
                        <!-- /.inner -->
                    </div>
                    <!-- /.outer -->
                </div>
                <!-- /#content -->

                    <div id="right" class="onoffcanvas is-right is-fixed bg-light" aria-expanded=false>
                        <a class="onoffcanvas-toggler" href="#right" data-toggle=onoffcanvas aria-expanded=false></a>
                        <br>
                        <br>
                        <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Warning!</strong> Best check yo self, you're not looking too good.
                        </div>
                        <!-- .well well-small -->
                        <div class="well well-small dark">
                            <ul class="list-unstyled">
                                <li>Visitor <span class="inlinesparkline pull-right">1,4,4,7,5,9,10</span></li>
                                <li>Online Visitor <span class="dynamicsparkline pull-right">Loading..</span></li>
                                <li>Popularity <span class="dynamicbar pull-right">Loading..</span></li>
                                <li>New Users <span class="inlinebar pull-right">1,3,4,5,3,5</span></li>
                            </ul>
                        </div>
                        <!-- /.well well-small -->
                        <!-- .well well-small -->
                        <div class="well well-small dark">
                            <button class="btn btn-block">Default</button>
                            <button class="btn btn-primary btn-block">Primary</button>
                            <button class="btn btn-info btn-block">Info</button>
                            <button class="btn btn-success btn-block">Success</button>
                            <button class="btn btn-danger btn-block">Danger</button>
                            <button class="btn btn-warning btn-block">Warning</button>
                            <button class="btn btn-inverse btn-block">Inverse</button>
                            <button class="btn btn-metis-1 btn-block">btn-metis-1</button>
                            <button class="btn btn-metis-2 btn-block">btn-metis-2</button>
                            <button class="btn btn-metis-3 btn-block">btn-metis-3</button>
                            <button class="btn btn-metis-4 btn-block">btn-metis-4</button>
                            <button class="btn btn-metis-5 btn-block">btn-metis-5</button>
                            <button class="btn btn-metis-6 btn-block">btn-metis-6</button>
                        </div>
                        <!-- /.well well-small -->
                        <!-- .well well-small -->
                        <div class="well well-small dark">
                            <span>Default</span><span class="pull-right"><small>20%</small></span>
                        
                            <div class="progress xs">
                                <div class="progress-bar progress-bar-info" style="width: 20%"></div>
                            </div>
                            <span>Success</span><span class="pull-right"><small>40%</small></span>
                        
                            <div class="progress xs">
                                <div class="progress-bar progress-bar-success" style="width: 40%"></div>
                            </div>
                            <span>warning</span><span class="pull-right"><small>60%</small></span>
                        
                            <div class="progress xs">
                                <div class="progress-bar progress-bar-warning" style="width: 60%"></div>
                            </div>
                            <span>Danger</span><span class="pull-right"><small>80%</small></span>
                        
                            <div class="progress xs">
                                <div class="progress-bar progress-bar-danger" style="width: 80%"></div>
                            </div>
                        </div>
                    </div>
                    <!-- /#right -->
            </div>
 <?php


include_once ROOT . DS . "squelette" . DS . "footer.php";
include_once ROOT . DS . "squelette" . DS . "endPage.php";
?>          