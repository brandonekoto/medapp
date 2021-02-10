<?php  
    $config = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "config.php";
    $config = str_replace("/", DIRECTORY_SEPARATOR, $config);
    include_once $config;
    $controller = new \controls\Accounting();
    use Helpers\Date;
    if(isset($_SESSION['data'])){
        extract($_SESSION['data']);        
    }
   
    if(isset($_GET['action'])){
        
        switch ($_GET['action']) {
            
            case "add":
                $listAgent = $controller->dao->get('agent');
                $filariane = array(
                    'Comptabilté' => "/public/patients.php",
                    'Liste des opération' => "/public/patients.php",
                    "Effectuer une opération" => ""
                );
                $titlePage =  "Effectuer une opération";
            break;
            case "view" :
                if(isset($_GET['id'])){
                    $condition = " WHERE operation.id = '".$_GET['id']."' ";
                }
                
                $condition .= " ORDER BY operation.date DESC";
                $operation = $controller->get($condition);
                $filariane = array(
                    'Comptabilité' => "/public/patients.php",
                    'List des opérations' => "/public/patients.php",
                    "Visualisation " => "",
                    $_GET['id'] => ""
                );
                $titlePage =  "Visualisation de l'opération";
                break;
            case "bind" :
                $filariane = array(
                    'Patients' => "/public/patients.php",
                    'Liste des patients' => "/public/patients.php",
                    "Liaison à une structure " => "",
                    $_GET['id'] => ""
                );
                $titlePage =  "Liaison à une structure";
                break;    
            default:
                break;
        }
    }else{
        $condition = " ORDER BY operation.date DESC";
        $listOperation = $controller->get($condition);
        $filariane = array(
        'Comptabilité' => "/public/users.php",
        'Liste des opérations' => ""
        );
        $titlePage =  "Liste des opération";
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
                            <?= $titlePage?>
                        </h3>
                        <div class="box-options">
                            <a href="/public/accounting.php?action=add" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> </a>
                            <a href="/public/accounting.php?action=print" class="btn btn-primary"><span class="glyphicon glyphicon-print"></span> </a>
                        </div>
                    </div>
                    <div class="showmessages">
                        <div class="col-lg-12">
                           <?php
                            ($session->flash());
                            
                        ?> 
                        </div>
                        
                    </div>
                    <?php
                    
                        if(isset($_GET['action'])){
                            switch ($_GET['action']){
                                case 'add':?>
                    <div id="div-1" class="body collapse in col-lg-8" aria-expanded="true" style="">
                        <form class="form-horizontal" action="/controls/control.php?mod=accounting&act=add" method="POST" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Type</label>
                                            <div class="col-lg-8">
                                                <select class="form-control" name="type">
                                                    <option value="">Choisir le type d'opération à effectuer</option>
                                                    <option value="1" <?= (isset($type) && $type = "1")? "selected" : ""?>>Entrée</option>
                                                    <option value="2" <?= (isset($type) && $type = "2")? "selected" : ""?>>Sortie</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="text1" class="control-label col-lg-4">Montant</label>
                                            <div class="col-lg-8">
                                                <input type="text" id="text1" name="montant" placeholder="Montant"value="<?= (isset($montant))? $montant : ""?>" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="text1" class="control-label col-lg-4">Motif</label>
                                            <div class="col-lg-8">
                                                <input type="text" id="text1"  name="motif" value="<?= (isset($motif))? $motif : ""?>"placeholder="Motif" class="form-control">
                                            </div>                                       
                                        </div>
                                       <div class="form-group">
                                            <label class="control-label col-lg-4">De/A</label>

                                            <div class="col-lg-8">
                                                <select class="form-control" name="agent_from">
                                                    <option value="">Choisir l'agent qui vs m'a donné </option>
                                                    <?php
                                                    foreach ($listAgent as $value) {?>                                                        
                                                    <option value="<?=$value->id?>" <?= (isset($agent_from ) && $agent_from ==  $value->id) ? "selected" : "" ?>><?= $value->nom . " " . $value->postnom . " " . $value->prenom ?></option>
                                                    <?php }?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="text1"  class="control-label col-lg-4">Observation</label>

                                            <div class="col-lg-8">
                                                <textarea type="text" id="text1" name="observation" placeholder="Ecrire une note d'observation" class="form-control"><?= (isset($adresse))? $adresse : ""?></textarea>
                                            </div>
                                        </div>
                                      
                                        <div class="form-group">
                                            <div class="col-lg-12">
                                                <button class="btn btn-success">
                                                    <span class="glyphicon glyphicon-save">                                                         
                                                    </span>
                                                    Enregistrer
                                                </button>
                                            </div>
                                        </div>
                            <br>
                            <br>
                                    </form>
                                </div>
                    <?php
                                    break;//Sortie $_GET['action']= add
                                case 'edit':
                                    if(isset($_GET['id']) && !empty($_GET['id'])){
                                        $patient = $controller->get($_GET['id']);
                                        if(isset($patient) && count($patient) > 0){                                                
                                            $patient = $patient[0];
                                        
                                            ?>
                            <div id="div-1" class="body collapse in col-lg-8" aria-expanded="true" style="">
                        <form class="form-horizontal" action="/controls/control.php?mod=patient&act=update" method="POST" enctype="multipart/form-data">                           
                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Image du Patient</label>
                                            <div class="col-lg-8">
                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                    <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="">
                                                        <img src="/img/personnel/<?= $patient->filename . ".". $patient->type?>" class="user-profile"/>
                                                    </div>
                                                    <div>
                                                        <span class="btn btn-default btn-file"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span><input  type="file" name="imgAgent[]" multiple="" ></span>
                                                        <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                                    </div>
                                                </div>
                                                <input type="hidden" name="idpatient" value="<?= $_GET['id'] ?>"
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="text1" class="control-label col-lg-4">Nom</label>

                                            <div class="col-lg-8">
                                                <input type="text" id="text1" name="nom" placeholder="Nom"value="<?= (isset($nom))? $nom : $patient->nom?>" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="text1" class="control-label col-lg-4">Post-nom</label>

                                            <div class="col-lg-8">
                                                <input type="text" id="text1"  name="postnom" value="<?= (isset($postnom))? $postnom : $patient->postnom?>"placeholder="Post-nom" class="form-control">
                                            </div>
                                       
                                        </div>
                                        <div class="form-group">
                                            <label for="text1"  class="control-label col-lg-4">Prénom</label>

                                            <div class="col-lg-8">
                                                <input type="text" id="text1" name="prenom" value="<?= (isset($prenom))? $prenom : $patient->prenom?>" placeholder="Prénom" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Sexe</label>
                                            <div class="col-lg-8">
                                                <select class="form-control" name="sexe">
                                                    <option value="">Choisir votre sexe</option>
                                                    <option value="M" <?= (isset($sexe) && $sexe = "M")? "selected" : (isset($patient->sexe) && $patient->sexe = "M") ? "selected" : ""?>>Masculin</option>
                                                    <option value="F" <?= (isset($sexe) && $sexe = "F")? "selected" : (isset($patient->sexe) && $patient->sexe = "F") ? "selected" : ""?>>Féminin</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="text1"  class="control-label col-lg-4">Lieu de naissance</label>

                                            <div class="col-lg-8">
                                                <input type="text" id="text1" value="<?= (isset($lieuNaiss))? $lieuNaiss : $patient->lieuNaiss?>"name="lieuNaiss" placeholder="Lieu de naissance" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="text1"  class="control-label col-lg-4">Date de naissance</label>

                                            <div class="col-lg-8">
                                                <input type="date" id="text1" name="dateNaiss" value="<?= (isset($dateNaiss))? $dateNaiss : $patient->age?>" placeholder="Date de naissance" class="form-control">
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Nationalité</label>

                                            <div class="col-lg-8">
                                                <select class="form-control" name="nationality">
                                                    <option value="">Choisir votre nationalité</option>
                                                    <option value="CD" <?= (isset($nationality ) && $nationality ==  "CD") ? "selected" : (isset($patient->nationality) && $patient->nationality == "CD") ? "selected" : "" ?>>RDC</option>
                                                    <option value="otres" <?= (isset($nationality ) && $nationality ==  "otres") ? "selected" : (isset($patient->nationality) && $patient->nationality == "otres") ? "selected" : "" ?>>other</option>
                                                </select>
                                            </div>
                                        </div>
                                         <div class="form-group">
                                            <label class="control-label col-lg-4">Etat-civil</label>

                                            <div class="col-lg-8">
                                                <select class="form-control" name="etatCivil">
                                                    <option value="">Choisir votre état-civil</option>
                                                    <option value="c" <?= (isset($etatCivil ) && $etatCivil ==  "c") ? "selected" : (isset($patient->etatcivil) && $patient->etatcivil == "c") ? "selected" : "" ?>  >Célibataire</option>
                                                    <option value="m" <?=  (isset($etatCivil ) && $etatCivil ==  "m") ? "selected" : (isset($patient->etatcivil) && $patient->etatcivil == "m") ? "selected" : "" ?> >Marié (e)</option>
                                                    <option value="d" <?=  (isset($etatCivil ) && $etatCivil ==  "d") ? "selected" : (isset($patient->etatcivil) && $patient->etatcivil == "d") ? "selected" : "" ?> >Divorcé (e)</option>
                                                    <option value="v" <?=  (isset($etatCivil ) && $etatCivil ==  "v") ? "selected" : (isset($patient->etatcivil) && $patient->etatcivil == "v") ? "selected" : "" ?> > Veuf (ve)</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="text1"  class="control-label col-lg-4">Adresse</label>

                                            <div class="col-lg-8">
                                                <textarea type="text" id="text1" name="adresse" placeholder="Adresse physique" class="form-control"><?= (isset($adresse))? $adresse : $patient->adresse?></textarea>
                                            </div>
                                        </div>
                                       
                                        <div class="form-group">
                                            <label for="text1"  class="control-label col-lg-4">Téléphone</label>

                                            <div class="col-lg-8">
                                                <input type="text" id="text1" name="telephone" value="<?= (isset($telephone))? $telephone : $patient->contact?>" placeholder="Votre numéro de téléphone " class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="text1"  class="control-label col-lg-4">Adresse e-mail</label>

                                            <div class="col-lg-8">
                                                <input type="text" id="text1" name="email" value="<?= (isset($email))? $email : $patient->email?>"placeholder="Votre adresse e-mail" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Type</label>
                                            <div class="col-lg-8">
                                                <select class="form-control" name="type">
                                                    <option value="">Choisir le Type du patient</option>
                                                    <option value="0" <?= (isset($type) && $type = "0")? "selected" : (isset($patient->type) && $patient->type = "0")? "selected" : "" ?>>Ordinaire</option>
                                                    <option value="1" <?= (isset($type) && $type = "1")? "selected" : (isset($patient->type) && $patient->type = "1")? "selected" : "" ?>>Affilié Externe</option>
                                                    <option value="2" <?= (isset($type) && $type = "2")? "selected" : ""?>>Affilié Interne</option>        
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <div class="col-lg-12">
                                                <button class="btn btn-success">
                                                    <span class="glyphicon glyphicon-save">
                                                         
                                                    </span>
                                                    Enregistrer
                                                </button>
                                            </div>
                                        </div>
                            <br>
                            <br>
                                        <!-- /.form-group -->

                                        <!-- /.form-group -->
                                    </form>
                                </div>
                            <?php             
                                            unset($patient);
                                        }else{?>
                            <div class="row"><div class="col-md-12"><h5 class="text-center alert alert-info alert-secondary alert-dismissible">Aucun patient n'est trouvé dans le système</h5> </div></div>
                            <?php                                            
                                        }                                        
                                    } else {?>
                                    <div class="row"><div class="col-md-12"><h5 class="text-center alert alert-info alert-secondary alert-dismissible">Aucun patient n'est sélectionné</h5> </div></div>
                            <?php                                        
                                    }
                                    break;//Sortie edit
                                case 'view':?>
                    <?php
                        if(isset($_GET['id']) && !empty($_GET['id']) && count($operation) > 0){                             
                            $operation = $operation[0];
                           
                    ?>
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="bg-warning" style="padding: 10px">
                            <div class="bg-blue-sky personne-info">
                                <div class="line-personne-info"><span class="champ">Type :</span><span class="val-line-personne-info"><?= ($operation->type == 1)? "Entrée" : "SORTIE" ?></span></div> 
                                <div class="line-personne-info"><span class="champ">Motif :</span><span class="val-line-personne-info"><?= $operation->motif ?></span></div> 
                                <div class="line-personne-info"><span class="champ">Montant :</span><span class="val-line-personne-info"><?= $operation->montant ?>$</span></div> 
                                <div class="line-personne-info"><span class="champ">Montant en CDF:</span><span class="val-line-personne-info"><?= $operation->montant * $operation->tauxapplique ?>$</span></div> 
                                
                                <div class="line-personne-info"><span class="champ">Taux appliqué :</span><span class="val-line-personne-info"><?= $operation->tauxapplique ?>$</span></div> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="wrapImgProfile" style="height:250px">
                                    <img src="/img/personnel/<?= $operation->filename . "." .$operation->type?>"   />
                                    <div class="refproduit">Initiateur<br><?= $operation->nom  . " ". $operation->postnom?></div>
                                </div>                                
                            </div>                         
                            <div class="col-lg-4">
                            <div class="wrapImgProfile" style="height:250px">
                                <img src="/img/personnel/<?= $operation->filename . "." .$operation->type?>"  />
                                <div class="refproduit">Intervenant <?= $operation->fromnom . " " .$operation->fromprenom?></div>
                            </div>                           
                        </div> 
                        </div>
                    
                        <!--
                        <div class="col-lg-12">
                            <div class="panel panel-primary panel-group">
                                
                                <div class="panel-heading panel-primary">
                                    <h4>Compte utilisateur</h4>
                                </div>
                                <div class="panel-body">
                                    <table class="table">
                                    <tbody>
                                        <tr class="">
                                            <td>Email</td>
                                            <td>brandon.ekoto@gmail.com</td>
                                        </tr>
                                        <tr class="">
                                            <td>Username</td>
                                            <td>brandon.ekoto</td>
                                        </tr>
                                        <tr class="">
                                            <td>Categorie</td>
                                            <td>Agent</td>
                                        </tr>
                                        <tr class="">
                                            <td>Mot de passe</td>
                                            <td>Agent</td>
                                        </tr>
                                    </tbody>
                                </table>
                                </div>
                                <div class="panel-footer">
                                    <a class="btn btn-success"><span class="glyphicon glyphicon-edit"></span>Modifier</a>
                                    <a class="btn btn-danger"><span class="glyphicon glyphicon-edit"></span>Désactiver ce compte</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>-->
                    <div class="clearfix"><br>
                        <br></div>
                    </div>
                    <?php
                            }else{?>
                            <h2 class="text-center alert alert-info alert-secondary alert-dismissible">Aucun examen Patient trouvé avec cette identifiant</h2> 
                    <?php

                            }
                                    break;//Sortie $_GET['action']= view
                                case "bind" :        
                                if(isset($_GET['id']) && count($patient) > 0){
                            $patient = $patient[0];
                            $listStructure = $controller->dao->get("structureaffilier");
                    ?>
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="col-lg-3">
                            <div class="wrapImgProfile">
                                <img src="/img/personnel/<?= $patient->filename . "." .$patient->type?>" />
                            </div>
                            <div class="">
                                <br>
                                           
                            </div>
                            <br>
                        </div>                       
                        <div class="col-lg-9 personne-info"> 
                            <form action="/controls/control.php?mod=structure&act=bind" method="POST">
                                <div class="line-personne-info"><span class="champ">Nom :</span><span class="val-line-personne-info"><?= $patient->nom ?></span></div> 
                                <div class="line-personne-info"><span class="champ">Prénom :</span><span class="val-line-personne-info"><?= $patient->postnom ?></span></div> 
                                <div class="line-personne-info"><span class="champ">Post-nom :</span><span class="val-line-personne-info"><?= $patient->prenom ?></span></div> 
                                <div class="line-personne-info"><span class="champ">Lieu de naissance :</span><span class="val-line-personne-info"><?= $patient->lieuNaiss ?></span></div> 
                                <div class="line-personne-info"><span class="champ">Age :</span><span class="val-line-personne-info"><?= $patient->age ?></span></div> 
                           
                                <div class="line-personne-info">
                                    <span class="champ">Structure :</span>
                                    <span class="val-line-personne-info">
                                        <select class="form-control" name="idStructure"> 
                                            
                                            <option value="">Sélectionner une structure</option>
                                            <?php
                                                if(count($listStructure) > 0){
                                                    foreach ($listStructure as $structure) {?>
                                                        <option value="<?= $structure->id ?>"><?= $structure->raisonsociale ?></option>                                            
                                            <?php                                                        
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </span>
                                </div>
                                <input type="hidden" name="idpatient" value="<?= $patient->idPatient?>"/>
                                <div class="line-personne-info"><span class="champ"></span><span class="val-line-personne-info"><button class="btn btn-success btn-grad" type="submit">Confirmer</button></span></div> 
                            </form>
                        </div>
                       
                    </div>
                </div>
                    <div class="clearfix"><br>
                        <br></div>
                    
                    <?php
                            }else{?>
                            <h2 class="text-center alert alert-info alert-secondary alert-dismissible">Aucun examen Patient trouvé avec cette identifiant</h2> 
                    <?php

                            }                            
                            break; //Sortie $_GET['action']= bind
                        }
                        
                        }else{
                            if(count($listOperation) > 0){ 
                            
                    ?>
                    <div class="">
                        <div class="col-lg-12">
                            <div class="box">
                                <header>
                                    <h5></h5>
                                    <div class="toolbar">
                                                <ul class="nav">
                                                    <div class="toolbar">
                                                        <ul class="nav">
                                                            <li>
                                                                <form action="/controls/control.php?mod=accounting&act=search" method="get" class="form-inline searchform">
                                                                    <div class=" form-group top_search">
                                                                        <div class="input-group">
                                                                            <input type="text" class="form-control input-search" name="q" placeholder="Recherche...">
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
                                <div id="optionalTable" class="body collapse in">
                                    <table class="table responsive-table" id="list-agents">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th><span class="glyphicon glyphicon-">Réf. Opé.</span></th>
                                                <th> <span class="glyphicon glyphicon-th-list"></span>&nbsp;Motif</th>
                                                <th>Montant</th>
                                                <th><span class="glyphicon glyphicon-transfer"></span>&nbsp;</th>
                                                <th><span class="glyphicon glyphicon-user"> Initiateur</span></th>
                                                <th><span class="glyphicon glyphicon-user"> Intervenant</span></th>                                     
                                               
                                                
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php                                            
                                            $count =  0;
                                            foreach ($listOperation as $key => $ope) { $count++?>
                                            <tr>
                                                <td><?= $count?></td>
                                                <td><a href="/public/accounting.php?action=view&id=<?= $ope->id?>"><?=$ope->id?></a></td>
                                                <td> <a href="/public/accounting.php?action=view&id=<?= $ope->id?>"><?=$ope->motif?></a></td>
                                                <td><?=$ope->montant?></td>
                                                <td><?=($ope->typeoperation == "1")? "Entrée" : "Sortie"?></td>
                                                <td><a href="/controls/control.php?mod=agent&act=view&id=<?= $ope->idagent?>" ><img src="/img/personnel/<?= $ope->filename . ".".$ope->type ?>" class="user-profile"/>
                                                        <h5><?=  $ope->nom . " " .$ope->postnom . " " . $ope->prenom?></h5></a></td>
                                                <td><a href="/controls/control.php?mod=agent&act=view&id=<?= $ope->idagent?>" ><img src="/img/personnel/<?= $ope->file . "." . $ope->typeimg ?>" class="user-profile"/>
                                                        <h5><?=  $ope->nom . " " .$ope->postnom . " " . $ope->prenom?></h5></a></td>
                                                
                                                <td><a class="text-danger" href="/controls/control.php?mod=accounting&act=del&id=<?= $ope->id ?>"><span class="glyphicon glyphicon-remove"></span></a></td>
                                            </tr>                        
                                                      <?php          
                                                      
                                                }
                                            ?>
                                            
                                           
                                           
                                        </tbody>               
                                    </table>
                                </div>
                                <div style="padding: 10px;">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                        <!-- /.inner -->
                    </div>
                    <?php
                            } else {
                                
                            }
                        }
                    ?>
                    </div>
                    <!-- /.outer -->
                </div>


<?php


include_once ROOT . DS . "squelette" . DS . "footer.php";
include_once ROOT . DS . "squelette" . DS . "endPage.php";
?>