<?php  
    $config = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "config.php";
    $config = str_replace("/", DIRECTORY_SEPARATOR, $config);
    include_once $config;
    $controller = new \controls\User();
    if(isset($_SESSION['data'])){
        extract($_SESSION['data']);
    }
    $agent = [];
    if(isset($_GET['id'])){
        $condition['where'] = " WHERE agent.id = ". $_GET['id'];
        //$agent = $controller->dao->get("agent", $condition);       
    }
    if(isset($_GET['action'])){
        switch ($_GET['action']) {
            case "add":
                $filariane = array(
                    'Utilisateurs' => "/public/users.php",
                    'Liste des utilisateurs' => "",
                    "Création de nouvel utilisateur" => ""
                );
                $titlePage =  "Création de nouvel utilisateur";
            break;
            case "view" :
                $filariane = array(
                    'Utilisateurs' => "/public/users.php",
                    'Liste des utilisateurs' => "",
                    "Visualisation " => "",
                    $_GET['id'] => ""
                );
                $titlePage =  "Visualisation de l'utilisateur";
            default:
                break;
        }
    }else{
        $filariane = array(
        'Utilisateurs' => "/public/users.php",
        'Liste des utilisateurs' => ""
        );
        $titlePage =  "Liste des utilisateurs";
    }
    $listUser = $controller->getList();
    $agent = new controls\Agent();
    $listAgent = $agent->list();
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
                            <a href="/public/users.php?action=add" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> </a>
                            <a href="/public/users.php?action=del" class="btn btn-primary"><span class="glyphicon glyphicon-print"></span> </a>
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
                            <div class="row">
                    <div id="div-1" class="body collapse in col-lg-8" aria-expanded="true" style="">
                        <form class="form-horizontal" action="/controls/control.php?mod=user&act=add" method="POST" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Agent</label>
                                            <div class="col-lg-8">
                                                <select class="form-control" name="id">
                                                    <option value="">Selectionner</option>
                                                    <?php
                                                    foreach ($listAgent as $itemAgent) {?>
                                                        <option value="<?= $itemAgent->id?>"><?= $itemAgent->nom . " " . $itemAgent->prenom ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div> 
                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Type de compte</label>    
                                            <div class="col-lg-8">
                                                <select class="form-control" name="type" value>
                                                    <option value="">Selectionner</option>
                                                    <option value="agent">Agent</option>
                                                    <option value="user">Patient & autres</option>
                                                    <option value="Admin">Admin</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Image de l'Agent</label>
                                            <div class="col-lg-8">
                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                    <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;"></div>
                                                   
                                                </div>
                                            </div>
                                        </div>
                                      
                                                                                
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
                        </div>
                    <?php
                                    
                                    break;
                                case 'view':                                    
                                    if(isset($_GET['id']) && count($agent) > 0){
                                        $agent = $agent[0];
                                    
                                    ?>
                    <div class="col-lg-12 col-md-12">
                        <div class="col-lg-3">
                            <div class="wrapImgProfile">
                                <img src="/img/personnel/10981441_932904300076295_8167041328504341445_n.jpg" />
                            </div>
                            <div class="">
                                <br>
                                <a href="/public/personnel.php?ac=agent&action=edit&id=<?= $agent->id ?>" class="btn btn-success"><span class="glyphicon glyphicon-edit"></span>Modifier </a>
                                <a href="/public/personnel.php?mod=agent&action=print&id=<?= $agent->id ?>" class="btn btn-success"><span class="glyphicon glyphicon-print"></span> </a>
                                <a href="/controls/control.php?mod=agent&act=del&id=<?= $agent->id ?>" class="btn btn-metis-1"><span class="glyphicon glyphicon-remove"></span> </a>
                                <a href="/public/personnel.php?action=bind&id=<?= $agent->id ?>" class="btn btn-metis-3"><span class="glyphicon glyphicon-transfer"></span> </a>
                                <br>              
                            </div>
                            <br>
                        </div>
                        <div class="col-lg-9">
                            <table class="table">
                                <tbody class="tab-content">
                                    <tr>
                                        <td>
                                            Nom 
                                        </td>
                                        <td><?= $agent->nom ?></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Postnom 
                                        </td>
                                        <td><?= $agent->postnom?></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Prénom 
                                        </td>
                                        <td><?= $agent->prenom ?></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Lieu de naissance 
                                        </td>
                                        <td><?= $agent->lieuNaiss?></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Date de naissance 
                                        </td>
                                        <td><?= $agent->dateNaiss?></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Nationalité 
                                        </td>
                                        <td><?= $agent->nationality?></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Fonction 
                                        </td>
                                        <td><?= ($agent->fonction == 0) ? "Medecin ": ($agent->fonction == 1)? "Infirmier" : ($agent->fonction == 2) ? "Comptable" : ($agent->fonction == 3) ? "réceptionniste": ($agent->fonction == 4)?"Autres" :""?></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Sexe 
                                        </td>
                                        <td><?= ($agent->genre == "M") ? "Masculin" : "Feminin" ?></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Etat-civil 
                                        </td>
                                        <td><?= ($agent->etatCivil == "c") ? "Celibataire" :  ($agent->etatCivil == "m") ? "Marié (e)" :  ($agent->etatCivil == "d")? "divorcé (e)" :  ($agent->etatCivil == "v")? "veuf (ve)" : "" ?></td>
                                    </tr>
                                    
                                    <tr>
                                        <td>
                                            Adresse 
                                        </td>
                                        <td><?= $agent->adresse?></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Téléphone 
                                        </td>
                                        <td><?= $agent->contact ?></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Email 
                                        </td>
                                        <td><?= $agent->email ?></td>
                                    </tr>
                                    
                                </tbody>
                            </table>
                            
                        </div>
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
                        </div>
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
                                            <tr>
                                                <td>1</td>
                                                <td>Kibala Marlene</td>
                                                <td>Epouse</td>
                                                <td>25</td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>Marndine Ekoto</td>
                                                <td>Enfant</td>
                                                <td>2</td>
                                            </tr>
                                            <tr>
                                                <td>3</td>
                                                <td>Marndine Ekoto</td>
                                                <td>Enfant</td>
                                                <td>2</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    
                                </div>
                                <div class="panel-footer">
                                    <a href="/public/personnel.php?action=addMember" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span>Ajouter membre</a>
                                </div>
                            </div>
                        </div>
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
                                    <a class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span>Désactiver ce compte</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"><br>
                        <br></div>
                    
                    <?php
                                    }
                                break;//sortie view
                                case "edit": 
                        if(isset($_GET['id'])){ ?>
                    <div id="div-1" class="body collapse in col-lg-8" aria-expanded="true" style="">
                        <form class="form-horizontal" action="/controls/control.php?mod=agent&act=add" method="POST" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Image de l'Agent</label>
                                            <div class="col-lg-8">
                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                    <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;"></div>
                                                    <div>
                                                        <span class="btn btn-default btn-file"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span><input  type="file" name="imgAgent"></span>
                                                        <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="text1" class="control-label col-lg-4">Nom</label>

                                            <div class="col-lg-8">
                                                <input type="text" id="text1" name="nom" placeholder="Nom" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="text1" class="control-label col-lg-4">Post-nom</label>

                                            <div class="col-lg-8">
                                                <input type="text" id="text1"  name="postnom"placeholder="Post-nom" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="text1"  class="control-label col-lg-4">Prénom</label>

                                            <div class="col-lg-8">
                                                <input type="text" id="text1" name="prenom" placeholder="Prénom" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Sexe</label>

                                            <div class="col-lg-8">
                                                <select class="form-control" name="sexe">
                                                    <option value="">Choisir votre sexe</option>
                                                    <option value="M">Masculin</option>
                                                    <option value="F">Féminin</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="text1"  class="control-label col-lg-4">Lieu de naissance</label>

                                            <div class="col-lg-8">
                                                <input type="text" id="text1" name="lieuNaiss" placeholder="Lieu de naissance" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="text1"  class="control-label col-lg-4">Date de naissance</label>

                                            <div class="col-lg-8">
                                                <input type="date" id="text1" name="dateNaiss" placeholder="Date de naissance" class="form-control">
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Nationalité</label>

                                            <div class="col-lg-8">
                                                <select class="form-control" name="nationality">
                                                    <option value="">Choisir votre nationalité</option>
                                                    <option value="CD">RDC</option>
                                                    <option value="other">other</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="text1"  class="control-label col-lg-4">Adresse</label>

                                            <div class="col-lg-8">
                                                <textarea type="text" rows="6" id="text1" name="adresse" placeholder="Adresse physique" class="form-control"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Etat-civil</label>

                                            <div class="col-lg-8">
                                                <select class="form-control" name="etatCivil">
                                                    <option value="">Choisir votre état-civil</option>
                                                    <option value="c">Célibataire</option>
                                                    <option value="m">Marié (e)</option>
                                                    <option value="d">Divorcé (e)</option>
                                                    <option value="v">Veuf (ve)</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="text1"  class="control-label col-lg-4">Nombre d'enfants</label>

                                            <div class="col-lg-8">
                                                <input type="number" id="text1" name="nbreEnfant" placeholder="Nombre d'enfants" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="text1"  class="control-label col-lg-4">Téléphone</label>

                                            <div class="col-lg-8">
                                                <input type="text" id="text1" name="telephone" placeholder="Votre numéro de téléphone " class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="text1"  class="control-label col-lg-4">Adresse e-mail</label>

                                            <div class="col-lg-8">
                                                <input type="text" id="text1" name="email" placeholder="Votre adresse e-mail" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Fonction</label>

                                            <div class="col-lg-8">
                                                <select class="form-control" name="fonction">
                                                    <option value="">Choisir la fonction de l'Agent</option>
                                                    <option value="0">Médecin</option>
                                                    <option value="1">Infirmier</option>                                                    
                                                    <option value="2">Comptable</option>
                                                    <option value="3">Réceptionniste</option>
                                                    <option value="4">Others</option>                                                    
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Niveau d'étude</label>

                                            <div class="col-lg-8">
                                                <select class="form-control" name="niveauEtude">
                                                    <option value="">Choisir votre qualification</option>
                                                    <option value="doc">Docteur</option>
                                                    <option value="lic">Licencié</option>
                                                    <option value="grad">Gradué (e)</option>
                                                    <option value="dip">Diplômé</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Statut</label>
                                            <div class="col-lg-8">
                                                <select class="form-control" name="statut">
                                                    <option value="">Choisir votre état-civil</option>
                                                    <option value="1">Contracté (e)</option>
                                                    <option value="0">Non contracté (e)</option>        
                                                </select>                                                
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="text1"  class="control-label col-lg-4">Date d'engagement </label>

                                            <div class="col-lg-8">
                                                <input type="date" id="text1" name="dateEngagement" placeholder="Date d'engagement" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="text1"  class="control-label col-lg-4">Date de sortie </label>

                                            <div class="col-lg-8">
                                                <input type="date" id="text1" name="datesortie" placeholder="Date de sortie" class="form-control">
                                            </div>
                                        </div>
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
                            <div class="col-lg-12">
                                <h2 class="text-center alert alert-info alert-secondary alert-dismissible">Aucun utilisateur trouvé avec cette référence</h2> </div>
                            <?php
                            
                        }
                                    
                            }
                        }else{
                    ?>
                    <div class="row">
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
                                                <th>Categorie</th>
                                                <th>Fonction</th>
                                                <th>Active</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            
                                            $count =  0;
                                                                foreach ($listUser as $key => $user) {$count++?>
                                            <tr>
                                                <td><?= $count?></td>
                                                <td><!--<a href="/public/personnel.php?action=view&id=<?= $user->id?>" >-->
                                                    <h5><?=  $user->username?></h5><!--</a>--></td>
                                                <td><?= $user->category ?></td>
                                                <td><?= $user->sous_category ?></td>
                                                <td><?= $user->allowed ?></td>
                                                <td><a class="text-danger" href="/controls/control.php?mod=user&act=del&id=<?= $user->id ?>"><span class="glyphicon glyphicon-remove"></span></a></td>
                                            </tr>                        
                                                      <?php         
                                                      }
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