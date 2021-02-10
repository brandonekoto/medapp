<?php  
    $config = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "config.php";
    $config = str_replace("/", DIRECTORY_SEPARATOR, $config);
    include_once $config;
    $controller = new \controls\Agent();
    
    
    if(isset($_GET['id'])){
        
        $condition['joins'] =  [
                    'tables' => ['fonction','download'],
                    'tableBase' => ['agent','agent'],
                    'typeJointure' => ['INNER','INNER'],
                    'keys' => ['idFonction', 'id_download'],
                    'primaryKeys' => ['fonction','id_avatar']
                ];
        $condition['where'] = " WHERE agent.id = ". $_GET['id'];
        //$agent = $controller->dao->get("agent", $condition);
        $agent = $controller->get($_GET['id']);
       
    }
    if(isset($_SESSION['data'])){
        extract($_SESSION['data']);
    }
    $listAgent = $controller->list();
    if(isset($_GET['action'])){
        switch ($_GET['action']) {
            case "add":
                $filariane = array(
                    'Personnel' => "/public/personnem.php",
                    'Liste de Personnel' => "",
                    "Création de nouveau personnel" => ""
                );
                $titlePage =  "Création de nouveau personnel";
            break;
            case "view" :
                $filariane = array(
                    'Personnel' => "/public/personnel.php",
                    'Liste de Personnel' => "",
                    "Visualisation " => "",
                    $_GET['id'] => ""
                );
                $titlePage =  "Visualisation du Personnel";
            
            case "edit" :
                $filariane = array(
                    'Personnel' => "/public/personnel.php",
                    'Liste de Personnel' => "",
                    "Modification " => "",
                    $_GET['id'] => ""
                );
                $titlePage =  "Modification du Personnel";
                break;
           default:
                break;
            
        }
    }else{
        $filariane = array(
        'Personnel' => "/public/users.php",
        'Liste de personnel' => ""
        );
        $titlePage =  "Liste des Agents";
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
                            <a href="/public/personnel.php?action=add" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> </a>
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
                    <div id="div-1" class="body collapse in col-lg-8" aria-expanded="true" style="">
                        <form class="form-horizontal" action="/controls/control.php?mod=agent&act=add" method="POST" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Image de l'Agent</label>
                                            <div class="col-lg-8">
                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                    <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;"></div>
                                                    <div>
                                                        <span class="btn btn-default btn-file"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span><input  type="file" name="imgAgent[]" multiple accept=""></span>
                                                        <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="text1" class="control-label col-lg-4">Nom</label>
                                            <div class="col-lg-8">
                                                <input type="text" id="text1" name="nom" placeholder="Nom" value="<?= (isset($nom)) ? $nom : ""?>" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="text1" class="control-label col-lg-4" >Post-nom</label>

                                            <div class="col-lg-8">
                                                <input type="text" id="text1"  name="postnom"placeholder="Post-nom" value="<?= (isset($postnom)) ? $postnom : ""?>" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="text1"  class="control-label col-lg-4">Prénom</label>

                                            <div class="col-lg-8">
                                                <input type="text" id="text1" name="prenom" placeholder="Prénom" value="<?= (isset($prenom)) ? $prenom : ""?> " class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Sexe</label>

                                            <div class="col-lg-8">
                                                <select class="form-control" name="sexe">
                                                    <option value="">Choisir votre sexe</option>
                                                    <option value="M" <?= (isset($sexe) && $sexe == "M")? "selected" : ""?>>Masculin</option>
                                                    <option value="F" <?= (isset($sexe) && $sexe == "F")? "selected" : ""?>>Féminin</option>                                                    
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="text1"  class="control-label col-lg-4">Lieu de naissance</label>
                                            <div class="col-lg-8">
                                                <input type="text" id="text1" name="lieuNaiss" placeholder="Lieu de naissance" value="<?= (isset($lieuNaiss)) ? $lieuNaiss : ""?>" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="text1"  class="control-label col-lg-4">Date de naissance</label>

                                            <div class="col-lg-8">
                                                <input type="date" id="text1" name="dateNaiss" value="<?= (isset($dateNaiss)) ? $dateNaiss : ""?>" placeholder="Date de naissance" class="form-control">
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Nationalité</label>
                                            <div class="col-lg-8">
                                                <select class="form-control" name="nationality">
                                                    <option value="">Choisir votre nationalité</option>
                                                    <option value="CD" <?= (isset($nationality) && $nationality == "CD") ? "selected" : "" ?>>RDC</option>
                                                    <option value="other" <?= (isset($nationality) && $nationality == "other") ? "selected" : "" ?> >other</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="text1"  class="control-label col-lg-4">Adresse</label>
                                            <div class="col-lg-8">
                                                <textarea type="text" rows="6" id="text1" name="adresse" placeholder="Adresse physique" class="form-control"><?= (isset($adresse)) ? $adresse : ""?></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Etat-civil</label>
                                            <div class="col-lg-8">
                                                <select class="form-control" name="etatCivil">
                                                    <option value="">Choisir votre état-civil</option>
                                                    <option value="c" <?= (isset($etatCivil) && $etatCivil == "c")? "selected" : ""?>>Célibataire</option>
                                                    <option value="m" <?= (isset($etatCivil) && $etatCivil == "m")? "selected" : ""?>>Marié (e)</option>
                                                    <option value="d" <?= (isset($etatCivil) && $etatCivil == "d")? "selected" : ""?>>Divorcé (e)</option>
                                                    <option value="v" <?= (isset($etatCivil) && $etatCivil == "v")? "selected" : ""?>> Veuf (ve)</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="text1"  class="control-label col-lg-4">Nombre d'enfants</label>
                                            <div class="col-lg-8">
                                                <input type="number" id="text1" name="nbreEnfant" placeholder="Nombre d'enfants" class="form-control" >
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="text1"  class="control-label col-lg-4">Téléphone</label>
                                            <div class="col-lg-8">
                                                <input type="text" id="text1" name="telephone" placeholder="Votre numéro de téléphone " value="<?= (isset($telephone)) ? $telephone : ""?>" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="text1"  class="control-label col-lg-4">Adresse e-mail</label>

                                            <div class="col-lg-8">
                                                <input type="text" id="text1" name="email" placeholder="Votre adresse e-mail" value="<?= (isset($email)) ? $email : ""?>" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Fonction</label>

                                            <div class="col-lg-8">
                                                <select class="form-control" name="fonction">
                                                    <option value="">Choisir la fonction de l'Agent</option>
                                                    <?php
                                                    $listFonction = $controller->getfonction();
                                                    foreach ($listFonction as $value) {
                                                        if($value->idFonction != "0"){
                                                        ?>
                                                    <option value="<?= $value->idFonction?>" <?= (isset($fonction) && $fonction == $value->idFonction)? "selected" : "" ?> ><?= $value->libelle?></option> 
                                                    <?php
                                                        }
                                                    }
                                                    ?>             
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Niveau d'étude</label>

                                            <div class="col-lg-8">
                                                <select class="form-control" name="niveauEtude">
                                                    <option value="">Choisir votre qualification</option>
                                                    <option value="doc" <?= (isset($niveauEtude) && $nivEtudes == "doc") ? "selected" : "" ?>>Docteur</option>
                                                    <option value="lic" <?= (isset($niveauEtude) && $nivEtudes == "lic") ? "selected" : "" ?>>Licencié</option>
                                                    <option value="grad" <?= (isset($niveauEtude) && $nivEtudes == "grad") ? "selected" : "" ?>>Gradué (e)</option>
                                                    <option value="dip" <?= (isset($niveauEtude) && $nivEtudes == "dip") ? "selected" : "" ?>>Diplômé</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Statut</label>
                                            <div class="col-lg-8">
                                                <select class="form-control" name="statut">
                                                    <option value="">Choisir votre statut du contrat</option>
                                                    <option value="1" <?= (isset($statut) && $statut == "1") ? "selected" : "" ?>>Contracté (e)</option>
                                                    <option value="0" <?= (isset($statut) && $statut == "0") ? "selected" : "" ?>>Non contracté (e)</option>        
                                                </select>                                                
                                            </div>
                                        </div>
                            <div class="form-group">
                                            <label class="control-label col-lg-4">Type</label>
                                            <div class="col-lg-8">
                                                <select class="form-control" name="type_agent">
                                                    <option value="">Choisir votre type</option>
                                                    <option value="1" <?= (isset($statut) && $statut == "1") ? "selected" : "" ?>>Interne</option>
                                                    <option value="0" <?= (isset($statut) && $statut == "0") ? "selected" : "" ?>>Externe</option>        
                                                </select>                                                
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="text1"  class="control-label col-lg-4">Date d'engagement </label>
                                            <div class="col-lg-8">
                                                <input type="date" id="text1" name="dateEngagement" placeholder="Date d'engagement" class="form-control" value="<?= (isset($dateEngagement)) ? $dateEngagement : ""?> ">
                                            </div>
                                        </div>
                            <!--
                                        <div class="form-group">
                                            <label for="text1"  class="control-label col-lg-4">Date de sortie </label>
                                            <div class="col-lg-8">
                                                <input type="date" id="text1" name="datesortie" placeholder="Date de sortie" value="<?= (isset($datesortie)) ? $datesortie : ""?> " class="form-control">
                                            </div>
                                        </div>-->
                                        <div class="form-group">
                                            <div class="col-lg-12">
                                                <button class="btn btn-success">
                                                    <span class="glyphicon glyphicon-save">                                                         
                                                    </span>
                                                    Enregistrer
                                                </button>
                                                <button class="btn btn-metis-1">
                                                    <span class="glyphicon glyphicon-remove">
                                                         
                                                    </span>
                                                    Annuler
                                                </button>
                                            </div>
                                        </div>
                            <br>
                            <br>
                                    </form>
                                </div>
                    
                    <?php
                                    
                                    break;
                                case 'view':                                    
                                    if(isset($_GET['id']) && count($agent) > 0){
                                        $agent = $agent[0];
                                    ?>
                            <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="col-lg-3">
                            <div class="wrapImgProfile">
                                <img src="/img/personnel/<?= $agent->filename . "." .$agent->type?>" />
                            </div>
                            <div class="">
                                <br>
                   
                                <a href="/public/personnel.php?ac=agent&action=edit&id=<?= $agent->idagent ?>" class="btn btn-success"><span class="glyphicon glyphicon-edit"></span>Modifier </a>
                                <a href="/public/personnel.php?mod=agent&action=print&id=<?= $agent->idagent ?>" class="btn btn-success"><span class="glyphicon glyphicon-print"></span> </a>
                                <a href="/controls/control.php?mod=agent&act=del&id=<?= $agent->idagent ?>" class="btn btn-metis-1"><span class="glyphicon glyphicon-remove"></span> </a>
                                <a href="/controls/control.php?mod=agent&act=bind&id=<?= $agent->idagent ?>" class="btn btn-metis-3"><span class="glyphicon glyphicon-transfer"></span> </a>
                                <br>              
                            </div>
                            <br>
                        </div>
                        <div class="col-lg-9">
                            <div class="col-lg-12 personne-info">
                                <div class="line-personne-info"><span class="champ">Type :</span><span class="val-line-personne-info"><?= ($agent->type_agent == 0) ? "INTERNE" : "EXTERNE" ?></span></div> 
                                <div class="line-personne-info"><span class="champ">Nom :</span><span class="val-line-personne-info"><?= $agent->nom ?></span></div> 
                                <div class="line-personne-info"><span class="champ">Prénom :</span><span class="val-line-personne-info"><?= $agent->postnom ?></span></div> 
                                <div class="line-personne-info"><span class="champ">Post-nom :</span><span class="val-line-personne-info"><?= $agent->prenom ?></span></div> 
                                <div class="line-personne-info"><span class="champ">Lieu de naissance :</span><span class="val-line-personne-info"><?= $agent->lieuNaiss ?></span></div> 
                                <div class="line-personne-info"><span class="champ">Date de naissance :</span><span class="val-line-personne-info"><?= Helpers\Date::dateToFr($agent->dateNaiss,'%d-%m-%Y  ') ?></span></div> 
                                <div class="line-personne-info"><span class="champ">Etat civil :</span><span class="val-line-personne-info"><?= ($agent->etatCivil=="c") ? "Célibataire" : ($agent->etatCivil=="m")? "Marié(e)" : ($agent->etatCivil=="d")? "Divorcé(e)" : "Veuf (ve)"?></span></div> 
                                <div class="line-personne-info"><span class="champ">Nationalité :</span><span class="val-line-personne-info"><?= ($agent->nationality == "CD") ? "Congolaise" : "Autre" ?></span></div> 
                                <div class="line-personne-info"><span class="champ">Fonction :</span><span class="val-line-personne-info"><?= $agent->libelle ?></span></div> 
                                <div class="line-personne-info"><span class="champ">Sexe :</span><span class="val-line-personne-info"><?= $agent->genre ?></span></div> 
                                <div class="line-personne-info"><span class="champ">Adresse :</span><span class="val-line-personne-info"><?= $agent->adresse ?></span></div>
                                <div class="line-personne-info"><span class="champ">Téléphone :</span><span class="val-line-personne-info"><?= $agent->contact ?></span></div>                            
                            </div>                   
                        </div>
                        <!--
                        <div class="col-lg-12">
                            <div class="panel panel-primary panel-group">
                                <div class="panel-heading panel-primary">
                                    <h4>Qualification</h4>
                                </div>
                                <div class="panel-body">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Position</th>
                                                <th>Libelé</th>
                                                <th>Titre</th>
                                                <th>Annee</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>Principale</td>
                                                <td>Reseau</td>
                                                <td>Licencié (e)</td>
                                                <td>2019</td>
                                            </tr>
                                            <tr>
                                                <td>1</td>
                                                <td>Secondaire</td>
                                                <td>Informatique</td>
                                                <td>Gardué(e)</td>
                                                <td>2019</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    
                                </div>
                                <div class="panel-footer">
                                    <a class="btn btn-success"><span class="glyphicon glyphicon-edit"></span>Modifier</a>
                                </div>
                            </div>
                        </div>-->
                        <div class="col-lg-12">
                            <div class="panel panel-primary panel-group">
                                <div class="panel-heading panel-primary">
                                    <h4>Famille</h4>
                                </div>
                                <div class="panel-body">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Noms et Prénom</th>
                                                <th>Statut</th>
                                                <th>Age</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!--
                                            <tr>
                                                <td>1</td>
                                                <td>Kibala Marlene</td>
                                                <td>Epouse</td>
                                                <td>25</td>
                                            </tr>
                                           -->
                                        </tbody>
                                    </table>
                                    
                                </div>
                                <div class="panel-footer">
                                    <a href="/public/personnel.php?action=addMember" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span>Ajouter membre</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <form action="/controls/control.php?mod=user&act=update" method="post">
                            <div class="panel panel-primary panel-group">
                                
                                <div class="panel-heading panel-primary">
                                    <h4>Compte utilisateur</h4>
                                </div>
                                <div class="panel-body">
                                    <div class="col-lg-12 personne-info">
                                        <div class="line-personne-info"><span class="champ">Email :</span><span class="val-line-personne-info"><?= $agent->email?></span></div> 
                                        <div class="line-personne-info"><span class="champ">username :</span><span class="val-line-personne-info"><?= $agent->username ?></span></div> 
                                        <?php 
                                            if($_SESSION['user']['username'] === $agent->username){
                                                
                                        ?>
                                        <div class="line-personne-info"><span class="champ">Mot de passe:</span><span class="val-line-personne-info"><input class="form-control" type="password" name="password"></span></div> 
                                        <div class="line-personne-info"><span class="champ">Répétez :</span><span class="val-line-personne-info"><input class="form-control" type="password" name="repassword"></span></div> 
                                       <?php
                                    }?>
                                    </div>     
                                    
                                </table>
                                </div>
                                <?php 
                                            if($_SESSION['user']['username'] === $agent->username){
                                                
                                            
                                        ?>
                                <div class="panel-footer">
                                    
                                    <button class="btn btn-success btn-grad"><span class="glyphicon glyphicon-lock "></span> Changer PWD </button>
                                    <a class="btn btn-danger" href="/controls/control.php?mod=user&act=disableaccount=<?= $agent->username ?>"><span class="glyphicon glyphicon-remove"></span>Désactiver ce compte</a>
                                </div>
                                  <?php
                                    }?>
                                
                            </div>
                            </form>
                        </div>
                    </div>
                        </div>
                    <div class="clearfix"><br>
                        <br></div>
                    
                    <?php
                                    }else{?>
                    <div class="col-lg-12">
                                    <h2 class="text-center alert alert-info alert-secondary alert-dismissible">Aucun Agent trouvé avec cette référence</h2> 
                    </div>
                    <?php                                        
                                    }
                                break;
                                case "edit": 
                        if(isset($_GET['id']) && !empty($_GET['id'])){              
                            $agent  = $controller->get($_GET['id']);
                            if(count($agent) > 0 && $agent !== false){
                                $agent = ($agent[0]);
                            ?>
                    <div id="div-1" class="body collapse in col-lg-8" aria-expanded="true" style="">
                        <form class="form-horizontal" action="/controls/control.php?mod=agent&act=update" method="POST" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Image de l'Agent</label>
                                            <div class="col-lg-8">
                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                    <div class="fileinput-preview thumbnail" data-trigger="fileinput" ><img src="/img/personnel/<?= $agent->filename . "." . $agent->type ?>"  class='profile'/>      </div>
                                                                                                  
                                                    
                                                    <div>
                                                        <span class="btn btn-default btn-file"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span><input  type="file" name="imgAgent[]" multiple accept=""></span>
                                                        <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                            <input type="hidden" name="idagent" value="<?= $_GET['id']?>">
                                        <div class="form-group">
                                            <label for="text1" class="control-label col-lg-4">Nom</label>
                                            <div class="col-lg-8">
                                                <input type="text" id="text1" name="nom" placeholder="Nom" value="<?= (isset($nom)) ? $nom : $agent->nom?>" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="text1" class="control-label col-lg-4" >Post-nom</label>

                                            <div class="col-lg-8">
                                                <input type="text" id="text1"  name="postnom"placeholder="Post-nom" value="<?= (isset($postnom)) ? $postnom : $agent->postnom?>" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="text1"  class="control-label col-lg-4">Prénom</label>

                                            <div class="col-lg-8">
                                                <input type="text" id="text1" name="prenom" placeholder="Prénom" value="<?= (isset($prenom)) ? $prenom : $agent->prenom ?> " class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Sexe</label>

                                            <div class="col-lg-8">
                                                <select class="form-control" name="sexe">
                                                    <option value="">Choisir votre sexe</option>
                                                    <option value="M" <?= (isset($sexe) && $sexe == "M")? "selected" : (isset($agent->genre) && $agent->genre == "M") ? "selected" : ""  ?>>Masculin</option>
                                                    <option value="F" <?= (isset($sexe) && $sexe == "F")? "selected" : (isset($agent->genre) && $agent->genre == "F") ? "selected" : ""  ?>>Féminin</option>                                                    
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="text1"  class="control-label col-lg-4">Lieu de naissance</label>
                                            <div class="col-lg-8">
                                                <input type="text" id="text1" name="lieuNaiss" placeholder="Lieu de naissance" value="<?= (isset($lieuNaiss)) ? $lieuNaiss : $agent->lieuNaiss ?>" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="text1"  class="control-label col-lg-4">Date de naissance</label>
                                            <div class="col-lg-8">
                                                <input type="date" id="text1" name="dateNaiss" value="<?= (isset($dateNaiss)) ? $dateNaiss : $agent->dateNaiss?>" placeholder="Date de naissance" class="form-control">
                                            </div>
                                        </div>                                        
                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Nationalité</label>
                                            <div class="col-lg-8">
                                                <select class="form-control" name="nationality">
                                                    <?= var_dump($agent->nationality) ?>
                                                    <option value="">Choisir votre nationalité</option>
                                                    <option value="CD" <?= (isset($nationality) && $nationality == "CD") ? "selected" : isset($agent->nationality) && $agent->nationality == "CD"? "selected" : "" ?>>RDC</option>
                                                    <option value="other" <?= isset($nationality) && $nationality == "other" ? "selected" : isset($agent->nationality) && $agent->nationality == "other" ? "selected" : "" ?> >other</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="text1"  class="control-label col-lg-4">Adresse</label>
                                            <div class="col-lg-8">
                                                <textarea type="text" rows="6" id="text1" name="adresse" placeholder="Adresse physique" class="form-control"><?= (isset($adresse)) ? $adresse : $agent->adresse?></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Etat-civil</label>
                                            <div class="col-lg-8">
                                                <select class="form-control" name="etatCivil">
                                                    <option value="">Choisir votre état-civil</option>
                                                    <option value="c" <?= (isset($etatCivil) && $etatCivil == "c")? "selected" : (isset($agent->etatCivil) && $agent->etatCivil == "c")? "selected" : ""?> >Célibataire</option>
                                                    <option value="m" <?= (isset($etatCivil) && $etatCivil == "m")? "selected" : (isset($agent->etatCivil) && $agent->etatCivil == "m")? "selected" : "" ?>>Marié (e)</option>
                                                    <option value="d" <?= (isset($etatCivil) && $etatCivil == "d")? "selected" : (isset($agent->etatCivil) && $agent->etatCivil == "d")? "selected" : "" ?>>Divorcé (e)</option>
                                                    <option value="v" <?= (isset($etatCivil) && $etatCivil == "v")? "selected" : (isset($agent->etatCivil) && $agent->etatCivil == "v")? "selected" : "" ?>> Veuf (ve)</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="text1"  class="control-label col-lg-4">Nombre d'enfants</label>
                                            <div class="col-lg-8">
                                                <input type="number" id="text1" name="nbreEnfant" placeholder="Nombre d'enfants" class="form-control" >
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="text1"  class="control-label col-lg-4">Téléphone</label>
                                            <div class="col-lg-8">
                                                <input type="text" id="text1" name="telephone" placeholder="Votre numéro de téléphone " value="<?= (isset($telephone)) ? $telephone : $agent->contact?>" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="text1"  class="control-label col-lg-4">Adresse e-mail</label>

                                            <div class="col-lg-8">
                                                <input type="text" id="text1" name="email" placeholder="Votre adresse e-mail" value="<?= (isset($email)) ? $email : $agent->email?>" class="form-control">
                                            </div>
                                        </div>
                            <!--
                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Fonction</label>

                                            <div class="col-lg-8">
                                                <select class="form-control" name="fonction">
                                                    <option value="">Choisir la fonction de l'Agent</option>
                                                    <?php
                                                    $listFonction = $controller->getfonction();
                                                    foreach ($listFonction as $value) {
                                                        if($value->idFonction != "0"){
                                                        ?>
                                                    <option value="<?= $value->idFonction?>" <?= (isset($fonction) && $fonction == $value->idFonction)? "selected" :  (isset($agent->fonction) && $agent->fonction == $value->idFonction)? "selected" : ""?> ><?= $value->libelle?></option> 
                                                    <?php
                                                        }
                                                    }
                                                    ?>             
                                                </select>
                                            </div>
                                        </div>-->
                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Niveau d'étude</label>

                                            <div class="col-lg-8">
                                                <select class="form-control" name="niveauEtude">
                                                    <option value="">Choisir votre qualification</option>
                                                    <option value="doc" <?= (isset($nivEtudes) && $nivEtudes == "doc") ? "selected" : (isset($agent->nivEtude) && $agent->nivEtude == "doc") ? "selected" : ""   ?>>Docteur</option>
                                                    <option value="lic" <?= (isset($nivEtudes) && $nivEtudes == "lic") ? "selected" : (isset($agent->nivEtude) && $agent->nivEtude == "lic") ? "selected" : "" ?>>Licencié</option>
                                                    <option value="grad" <?=(isset($nivEtudes) && $nivEtudes == "grad") ? "selected" : (isset($agent->nivEtude) && $agent->nivEtude == "grad") ? "selected" : "" ?>>Gradué (e)</option>
                                                    <option value="dip" <?= (isset($nivEtudes) && $nivEtudes == "dip") ? "selected" : (isset($agent->nivEtude) && $agent->nivEtude == "dip") ? "selected" : ""  ?>>Diplômé</option>
                                                </select>
                                            </div>
                                        </div><!--
                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Statut</label>
                                            <div class="col-lg-8">
                                                <select class="form-control" name="statut">
                                                    <option value="">Choisir votre état-civil</option>
                                                    <option value="1" <?= (isset($statut) && $statut == "1") ? "selected" : (isset($agent->statut) && $agent->statut == "1") ? "selected" : ""    ?>>Contracté (e)</option>
                                                    <option value="0" <?= (isset($statut) && $statut == "0") ? "selected" : (isset($agent->statut) && $agent->statut == "0") ? "selected" : ""   ?>>Non contracté (e)</option>        
                                                </select>                                                
                                            </div>
                                        </div>  -->                                      
                                        <div class="form-group">
                                            <div class="col-lg-12">
                                                <button class="btn btn-success">
                                                    <span class="glyphicon glyphicon-save">                                                         
                                                    </span>
                                                    Enregistrer
                                                </button>
                                                <button class="btn btn-metis-1">
                                                    <span class="glyphicon glyphicon-remove">
                                                         
                                                    </span>
                                                    Annuler
                                                </button>
                                            </div>
                                        </div>
                                <br>
                                <br>
                                </form>
                            </div>        
                    <?php
                            }else{?>
                            <div class="row"><div class="col-md-12"><h5 class="text-center alert alert-info alert-secondary alert-dismissible">Aucun agent n'est enregistré avec cette référence</h5> </div></div>
                            <?php                                
                            }
                        }else{?>
                            <div class="row"><div class="col-md-12"><h5 class="text-center alert alert-info alert-secondary alert-dismissible">Aucun agent n'a été séléectionné</h5> </div></div>
                            <?php                 
                        }                                    
                            }//Fin switch
                        }else{
                           
                            //listing des agens
                    ?>
                    <div class="">
                        <div class="col-lg-12">
                            <div class="box">
                                <header>
                                    <h5></h5>
                                    <div class="toolbar">
                                        <div class="btn-group">
                                            <a href="#optionalTable" data-toggle="collapse" class="btn btn-default btn-sm minimize-box ">
                                                <i class="fa fa-angle-up"></i>
                                            </a>
                                            <a class="btn btn-danger btn-sm close-box"><i class="fa fa-times"></i></a>
                                        </div>
                                    </div>
                                </header>
                                <div id="optionalTable" class="body collapse in">
                                    <table class="table responsive-table" id="list-agents">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th><span class="glyphicon glyphicon-user"></span></th>
                                                <th>Fonction</th>
                                                <th>Matricule</th>
                                                <th>Sexe</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            
                                            $count =  0;
                                                                foreach ($listAgent as $key => $agent) { $count++?>
                                            <tr>
                                                <td><?= $count?></td>
                                                <td><a href="/public/personnel.php?action=view&id=<?= $agent->id?>" ><img src="/img/personnel/passport.png" class="user-profile"/>
                                                        <h5><?=  $agent->nom . " " .$agent->postnom . " " . $agent->prenom?></h5></a></td>
                                                <td><?= $agent->libelle ?></td>
                                                <td><?= $agent->id ?></td>
                                                <td><?= $agent->genre ?></td>
                                                <td><a class="text-danger" href="/controls/control.php?mod=agent&act=del&id=<?= $agent->id ?>"><span class="glyphicon glyphicon-remove"></span></a></td>
                                            </tr>                        
                                                      <?php          }
                                            ?>
                                            
                                           
                                           
                                        </tbody>               
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- /.inner -->
                    </div>
                    <?php
                        }
                    ?>
                        </div>
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