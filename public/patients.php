<?php
$config = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "config.php";
$config = str_replace("/", DIRECTORY_SEPARATOR, $config);
include_once $config;
$controller = new \controls\Patient();

use Helpers\Date;

if (isset($_SESSION['data'])) {
    extract($_SESSION['data']);
}
$listPatient = null;
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $patient = $controller->get($_GET['id']);

    $controlActe = new controls\Acte();
    $antecedents = $controller->getAntecedent($_GET['id']);
    $condition['where'] = " WHERE acte_pose.id_patient=$_GET[id] ";
    $actes = $controlActe->acteinfo($condition);
    if (count($patient) < 1) {
        $session->setFlash("Patient non trouvé");
    }
} elseif (isset($_GET['statut']) && strlen($_GET['statut']) > 0) {
    $listPatient = $controller->getList($_GET['statut']);
}else{
    $listPatient = $controller->getList();
}
if (isset($_SESSION['patient']) && count($_SESSION['patient']) > 0) {
    extract($_SESSION['patient']);
}
if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case "add":
            $filariane = array(
                'Patients' => "/public/patients.php",
                'Liste des patients' => "/public/patients.php",
                "Création de nouveau patient" => ""
            );
            $titlePage = "Création de nouveau personnel";
            break;
        case "view" :
            $filariane = array(
                'Patients' => "/public/patients.php",
                'Liste des patients' => "/public/patients.php",
                "Visualisation " => "",
                $_GET['id'] => ""
            );
            $titlePage = "Visualisation du Personnel";
            break;

        case "deceder" :
            $filariane = array(
                'Patients' => "/public/patients.php",
                'Liste des patients' => "/public/patients.php",
                $_GET['id'] => "",
                "Changement statut du patient " => "",
            );
            $titlePage = "Changement statut du patient";
            break;

        case "bind" :
            $filariane = array(
                'Patients' => "/public/patients.php",
                'Liste des patients' => "/public/patients.php",
                "Liaison à une structure " => "",
                $_GET['id'] => ""
            );
            $titlePage = "Liaison à une structure";
            break;
        default:
            break;
    }
} else {
    $filariane = array(
        'Patient' => "/public/users.php",
        'Liste des patients' => ""
    );
    $titlePage = "Liste des Agents";
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
                    PATIENTS
                </h3>
                <div class="box-options">
                    <a href="/public/patients.php?action=add" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> </a>
                    <a href="/public/patients.php?action=del" class="btn btn-primary"><span class="glyphicon glyphicon-print"></span> </a>
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
            if (isset($_GET['action'])) {
                switch ($_GET['action']) {
                    case 'add':
                        ?>
                        <div id="div-1" class="body collapse in col-lg-8" aria-expanded="true" style="">
                            <form class="form-horizontal" action="/controls/control.php?mod=patient&act=add" method="POST" enctype="multipart/form-data">

                                <div class="form-group">
                                    <label class="control-label col-lg-4">Image du Patient</label>
                                    <div class="col-lg-8">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;"></div>
                                            <div>
                                                <span class="btn btn-default btn-file"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span><input  type="file" name="imgAgent[]" multiple="" ></span>
                                                <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="text1" class="control-label col-lg-4">Nom</label>

                                    <div class="col-lg-8">
                                        <input type="text" id="text1" name="nom" placeholder="Nom"value="<?= (isset($nom)) ? $nom : "" ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="text1" class="control-label col-lg-4">Post-nom</label>

                                    <div class="col-lg-8">
                                        <input type="text" id="text1"  name="postnom" value="<?= (isset($postnom)) ? $postnom : "" ?>"placeholder="Post-nom" class="form-control">
                                    </div>

                                </div>
                                <div class="form-group">
                                    <label for="text1"  class="control-label col-lg-4">Prénom</label>

                                    <div class="col-lg-8">
                                        <input type="text" id="text1" name="prenom" value="<?= (isset($prenom)) ? $prenom : "" ?>" placeholder="Prénom" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Sexe</label>

                                    <div class="col-lg-8">
                                        <select class="form-control" name="sexe">
                                            <option value="">Choisir votre sexe</option>
                                            <option value="M" <?= (isset($sexe) && $sexe == "M") ? "selected" : "" ?>>Masculin</option>
                                            <option value="F" <?= (isset($sexe) && $sexe == "F") ? "selected" : "" ?>>Féminin</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="text1"  class="control-label col-lg-4">Groupe Sanguin</label>

                                    <div class="col-lg-8">
                                        <select type="text" id="text1" name="sang" value="<?= (isset($sang)) ? $sang : "" ?>" placeholder="Groupe Sanguin" class="form-control">
                                            <option value="A" <?= isset($sang) && $sang == "A" ? "selected" : "" ?>>A</option>
                                            <option value="B" <?= isset($sang) && $sang == "B" ? "selected" : "" ?>>B</option>
                                            <option value="AB" <?= isset($sang) && $sang == "AB" ? "selected" : "" ?>>AB</option>
                                            <option value="O" <?= isset($sang) && $sang == "O" ? "selected" : "" ?>>O</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="text1"  class="control-label col-lg-4">Lieu de naissance</label>

                                    <div class="col-lg-8">
                                        <input type="text" id="text1" value="<?= (isset($lieuNaiss)) ? $lieuNaiss : "" ?>"name="lieuNaiss" placeholder="Lieu de naissance" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="text1"  class="control-label col-lg-4">Date de naissance</label>

                                    <div class="col-lg-8">
                                        <input type="date" id="text1" name="dateNaiss" value="<?= (isset($dateNaiss)) ? $dateNaiss : "" ?>" placeholder="Date de naissance" class="form-control">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-lg-4">Nationalité</label>

                                    <div class="col-lg-8">
                                        <select class="form-control" name="nationality">
                                            <option value="">Choisir votre nationalité</option>
                                            <option value="CD" <?= isset($nationality) && $nationality == "CD" ? "selected" : "" ?>>RDC</option>
                                            <option value="otres" <?= isset($nationality) && $nationality == "otres" ? "selected" : "" ?>>other</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Etat-civil</label>

                                    <div class="col-lg-8">
                                        <select class="form-control" name="etatCivil">
                                            <option value="">Choisir votre état-civil</option>
                                            <option value="c" <?= (isset($etatCivil) && $sexe == "c") ? "selected" : "" ?>>Célibataire</option>
                                            <option value="m" <?= (isset($etatCivil) && $sexe == "m") ? "selected" : "" ?>>Marié (e)</option>
                                            <option value="d" <?= (isset($etatCivil) && $sexe == "d") ? "selected" : "" ?>>Divorcé (e)</option>
                                            <option value="v" <?= (isset($etatCivil) && $sexe == "v") ? "selected" : "" ?>> Veuf (ve)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="text1"  class="control-label col-lg-4">Adresse</label>

                                    <div class="col-lg-8">
                                        <textarea type="text" id="text1" name="adresse" placeholder="Adresse physique" class="form-control"><?= (isset($adresse)) ? $adresse : "" ?></textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="text1"  class="control-label col-lg-4">Téléphone</label>

                                    <div class="col-lg-8">
                                        <input type="text" id="text1" name="telephone" value="<?= (isset($telephone)) ? $telephone : "" ?>" placeholder="Votre numéro de téléphone " class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="text1"  class="control-label col-lg-4">Adresse e-mail</label>

                                    <div class="col-lg-8">
                                        <input type="text" id="text1" name="email" value="<?= (isset($email)) ? $email : "" ?>"placeholder="Votre adresse e-mail" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-4">Type</label>
                                    <div class="col-lg-8">
                                        <select class="form-control" name="type">
                                            <option value="">Choisir le Type du patient</option>
                                            <option value="0" <?= (isset($type) && $type == "0") ? "selected" : "" ?>>Ordinaire</option>
                                            <option value="1" <?= (isset($type) && $type == "1") ? "selected" : "" ?>>Affilié Externe</option>
                                            <option value="2" <?= (isset($type) && $type == "2") ? "selected" : "" ?>>Affilié Interne</option>                                                    
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
                            </form>
                        </div>
                        <?php
                        break; //Sortie $_GET['action']= add
                    case 'edit':
                        if (isset($_GET['id']) && !empty($_GET['id'])) {
                            $patient = $controller->get($_GET['id']);
                            if (isset($patient) && count($patient) > 0) {
                                $patient = $patient[0];
                                ?>
                                <div id="div-1" class="body collapse in col-lg-8" aria-expanded="true" style="">
                                    <form class="form-horizontal" action="/controls/control.php?mod=patient&act=update" method="POST" enctype="multipart/form-data">                           
                                        <div class="form-group">
                                            <label class="control-label col-lg-4">Image du Patient</label>
                                            <div class="col-lg-8">
                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                    <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="">
                                                        <img src="/img/personnel/<?= $patient->filename . "." . $patient->type ?>" class="user-profile"/>
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
                                                    <input type="text" id="text1" name="nom" placeholder="Nom"value="<?= (isset($nom)) ? $nom : $patient->nom ?>" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="text1" class="control-label col-lg-4">Post-nom</label>

                                                <div class="col-lg-8">
                                                    <input type="text" id="text1"  name="postnom" value="<?= (isset($postnom)) ? $postnom : $patient->postnom ?>"placeholder="Post-nom" class="form-control">
                                                </div>

                                            </div>
                                            <div class="form-group">
                                                <label for="text1"  class="control-label col-lg-4">Prénom</label>

                                                <div class="col-lg-8">
                                                    <input type="text" id="text1" name="prenom" value="<?= (isset($prenom)) ? $prenom : $patient->prenom ?>" placeholder="Prénom" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-lg-4">Sexe</label>
                                                <div class="col-lg-8">
                                                    <select class="form-control" name="sexe">
                                                        <option value="">Choisir votre sexe</option>
                                                        <option value="M" <?= (isset($sexe) && $sexe == "M") ? "selected" : (isset($patient->sexe) && $patient->sexe == "M") ? "selected" : "" ?>>Masculin</option>
                                                        <option value="F" <?= (isset($sexe) && $sexe == "F") ? "selected" : (isset($patient->sexe) && $patient->sexe == "F") ? "selected" : "" ?>>Féminin</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="text1"  class="control-label col-lg-4">Lieu de naissance</label>

                                                <div class="col-lg-8">
                                                    <input type="text" id="text1" value="<?= (isset($lieuNaiss)) ? $lieuNaiss : $patient->lieuNaiss ?>"name="lieuNaiss" placeholder="Lieu de naissance" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="text1"  class="control-label col-lg-4">Date de naissance</label>

                                                <div class="col-lg-8">
                                                    <input type="date" id="text1" name="dateNaiss" value="<?= (isset($dateNaiss)) ? $dateNaiss : $patient->age ?>" placeholder="Date de naissance" class="form-control">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-lg-4">Nationalité</label>

                                                <div class="col-lg-8">
                                                    <select class="form-control" name="nationality">
                                                        <option value="">Choisir votre nationalité</option>
                                                        <option value="CD" <?= (isset($nationality) && $nationality == "CD") ? "selected" : (isset($patient->nationality) && $patient->nationality == "CD") ? "selected" : "" ?>>RDC</option>
                                                        <option value="otres" <?= (isset($nationality) && $nationality == "otres") ? "selected" : (isset($patient->nationality) && $patient->nationality == "otres") ? "selected" : "" ?>>other</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-lg-4">Etat-civil</label>

                                                <div class="col-lg-8">
                                                    <select class="form-control" name="etatCivil">
                                                        <option value="">Choisir votre état-civil</option>
                                                        <option value="c" <?= (isset($etatCivil) && $etatCivil == "c") ? "selected" : (isset($patient->etatcivil) && $patient->etatcivil == "c") ? "selected" : "" ?>  >Célibataire</option>
                                                        <option value="m" <?= (isset($etatCivil) && $etatCivil == "m") ? "selected" : (isset($patient->etatcivil) && $patient->etatcivil == "m") ? "selected" : "" ?> >Marié (e)</option>
                                                        <option value="d" <?= (isset($etatCivil) && $etatCivil == "d") ? "selected" : (isset($patient->etatcivil) && $patient->etatcivil == "d") ? "selected" : "" ?> >Divorcé (e)</option>
                                                        <option value="v" <?= (isset($etatCivil) && $etatCivil == "v") ? "selected" : (isset($patient->etatcivil) && $patient->etatcivil == "v") ? "selected" : "" ?> > Veuf (ve)</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="text1"  class="control-label col-lg-4">Adresse</label>

                                                <div class="col-lg-8">
                                                    <textarea type="text" id="text1" name="adresse" placeholder="Adresse physique" class="form-control"><?= (isset($adresse)) ? $adresse : $patient->adresse ?></textarea>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="text1"  class="control-label col-lg-4">Téléphone</label>

                                                <div class="col-lg-8">
                                                    <input type="text" id="text1" name="telephone" value="<?= (isset($telephone)) ? $telephone : $patient->contact ?>" placeholder="Votre numéro de téléphone " class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="text1"  class="control-label col-lg-4">Adresse e-mail</label>

                                                <div class="col-lg-8">
                                                    <input type="text" id="text1" name="email" value="<?= (isset($email)) ? $email : $patient->email ?>"placeholder="Votre adresse e-mail" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-lg-4">Type</label>
                                                <div class="col-lg-8">
                                                    <select class="form-control" name="type">
                                                        <option value="">Choisir le Type du patient</option>
                                                        <option value="0" <?= (isset($type) && $type = "0") ? "selected" : (isset($patient->type) && $patient->type = "0") ? "selected" : "" ?>>Ordinaire</option>
                                                        <option value="1" <?= (isset($type) && $type = "1") ? "selected" : (isset($patient->type) && $patient->type = "1") ? "selected" : "" ?>>Affilié Externe</option>
                                                        <option value="2" <?= (isset($type) && $type = "2") ? "selected" : "" ?>>Affilié Interne</option>        
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
                                    } else {
                                        ?>
                                        <div class="row"><div class="col-md-12"><h5 class="text-center alert alert-info alert-secondary alert-dismissible">Aucun patient n'est trouvé dans le système</h5> </div></div>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <div class="row"><div class="col-md-12"><h5 class="text-center alert alert-info alert-secondary alert-dismissible">Aucun patient n'est sélectionné</h5> </div></div>
                                    <?php
                                }
                                break; //Sortie edit
                            case 'view':
                                ?>
                                <?php
                                if (isset($_GET['id']) && count($patient) > 0) {
                                    $patient = $patient[0];
                                    ?>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12">
                                            <div class="col-lg-3">
                                                <div class="wrapImgProfile">
                                                    <img src="/img/personnel/<?= $patient->filename . "." . $patient->type ?>" />
                                                </div>
                                                <div class="">
                                                    <br>
                                                    <a href="/controls/control.php?mod=patient&act=edit&id=<?= $patient->idPatient ?>" class="btn btn-success" title="Modifier les données du patient"><span class="glyphicon glyphicon-edit"></span> Modifier</a>
                                                    <a href="/controls/control.php?mod=patient&act=print&id=<?= $patient->idPatient ?>" class="btn btn-success" title="Imprimer la fiche du patient"><span class="glyphicon glyphicon-print"></span> </a>
                                                    <!--<a href="/controls/control.php?mod=patient&act=del&id=<?= $patient->idPatient ?>" class="btn btn-metis-1"><span class="glyphicon glyphicon-remove"></span> </a>-->
                                                    <?php
                                                    if ($patient->statut == 0) {
                                                        ?>
                                                    <a href="/public/patients.php?action=deceder&id=<?= $patient->idPatient ?>" class="btn btn-metis-1" title="changer le statut en lui mettre décéder"><span class="glyphicon glyphicon-off"></span> </a>
                <?php } ?>
                                                    <a href="/public/patients.php?action=bind&id=<?= $patient->idPatient ?>" class="btn btn-metis-3" title="lier ce patient à une structure affiliée (Entreprise, famille, organisation,société,...)"><span class="glyphicon glyphicon-transfer"></span> </a>
                                                    <br>              
                                                </div>
                                                <br>
                                            </div>                          
                                            <div class="col-lg-9 personne-info">
                                                <div class="line-personne-info"><span class="champ">Statut :</span><span class="val-line-personne-info"><?= $patient->statutp == 0 ? "EN VIE" : "DECEDE" ?></span></div> 
                                                <div class="line-personne-info"><span class="champ">N°Fiche interne :</span><span class="val-line-personne-info"><?= $patient->numinterne != null ? $patient->numinterne : "" ?></span></div> 
                                                <div class="line-personne-info"><span class="champ">NUP :</span><span class="val-line-personne-info"><?= $patient->nu != null ? $patient->nu : "" ?></span></div> 
                                                <div class="line-personne-info"><span class="champ">Nom :</span><span class="val-line-personne-info"><?= $patient->nom ?></span></div> 
                                                <div class="line-personne-info"><span class="champ">Prénom :</span><span class="val-line-personne-info"><?= $patient->postnom ?></span></div> 
                                                <div class="line-personne-info"><span class="champ">Post-nom :</span><span class="val-line-personne-info"><?= $patient->prenom ?></span></div> 
                                                <div class="line-personne-info"><span class="champ">Groupe Sanguin :</span><span class="val-line-personne-info"><?= $patient->group_sanguin ?></span></div> 
                                                <div class="line-personne-info"><span class="champ">Lieu de naissance :</span><span class="val-line-personne-info"><?= $patient->lieuNaiss ?></span></div> 
                                                <div class="line-personne-info"><span class="champ">Date de naissance :</span><span class="val-line-personne-info"><?= $patient->age ?></span></div> 
                                                <div class="line-personne-info"><span class="champ">Sexe :</span><span class="val-line-personne-info"><?= ($patient->sexe == "m") ? "Masculin" : "Feminin" ?></span></div> 
                                                <div class="line-personne-info"><span class="champ">Etat-civil :</span><span class="val-line-personne-info"><?= ($patient->etatcivil == "m") ? "Marié(e)" : ($patient->etatcivil == "c") ? "Célibataire" : ($patient->etatcivil == "d") ? "Divorcé(e)" : ($patient->etatcivil == "v") ? "Veuf (ve)" : "" ?></span></div> 
                                                <div class="line-personne-info"><span class="champ">Nationalité :</span><span class="val-line-personne-info"><?= ($patient->nationality = "CD") ? " Congolaise" : "Autres" ?></span></div>
                                                <div class="line-personne-info"><span class="champ">Adresse :</span><span class="val-line-personne-info"><?= $patient->adresse ?></span></div>
                                                <div class="line-personne-info"><span class="champ">Téléphone :</span><span class="val-line-personne-info"><?= $patient->contact ?></span></div>
                                                <div class="line-personne-info"><span class="champ">Type :</span><span class="val-line-personne-info"><?= $patient->libstructure ?></span></div>
                                                <div class="line-personne-info"><span class="champ">Structure :</span><span class="val-line-personne-info"><?= $patient->raisonsociale ?></span></div>
                                            </div>

                                            <div class="col-lg-12">
                                                 <?php 
                                                          
                                                          if($patient->statutp == 1){?>
                                                <div class="panel panel-primary panel-group">
                                                    <div class="panel-heading panel-primary">
                                                        <h4>INFORMATION SUR DECES </h4> 

                                                    </div>
                                                    <div class="panel-body">
                                                        <div id="stripedTable" class="body collapse in">
                                                         
                                                                <div class="col-lg-12 col-md-12 personne-info">
                                                <div class="line-personne-info"><span class="champ">Cause :</span><span class="val-line-personne-info"><?= $patient->cause ?></span></div> 
                                                <div class="line-personne-info"><span class="champ">Date :</span><span class="val-line-personne-info"><?= $patient->date_deces ?></span></div> 
                                                <div class="line-personne-info"><span class="champ">Lieu du décès :</span><span class="val-line-personne-info"><?= $patient->lieu_deces ?></span></div> 
                                                <div class="line-personne-info"><span class="champ">Observation :</span><span class="val-line-personne-info"><?= $patient->observation_deces   ?></span></div> 
                                                
                                            </div>
                                                            
                                                           

                                                        </div>   

                                                    </div>
                                                    <div class="panel-footer">
                                                        <!--<a class="btn btn-info"><span class="glyphicon glyphicon-file"></span>Voir toutes</a>
                                                        <a class="btn btn-success"><span class="glyphicon glyphicon-edit"></span>Modifier</a>
                                                        <a class="btn btn-success"><span class="glyphicon glyphicon-eye-open"></span>Consulter now</a>-->
                                                    </div>
                                                </div>
                                                 <?php
                                                              
                                                          }
                                                          ?>
                                                <div class="panel panel-primary panel-group">
                                                    <div class="panel-heading panel-primary">
                                                        <h4>ANTECEDENTS <button href="" class="btn btn-success pull-right" style="margin-top: -10px !important; display: inline-block" data-toggle="modal" data-target="#addAnt"><span class="glyphicon glyphicon-plus"></span> </button></h4> 

                                                    </div>
                                                    <div class="panel-body">
                                                        <div id="stripedTable" class="body collapse in">
                                                            <?php
                                                            if (count($antecedents)) {
                                                                ?>

                                                                <table class="table table-striped responsive-table">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>#</th>                                                           
                                                                            <th>Elément</th>
                                                                            <th>Type</th>
                                                                            <th>Details</th>                                                                   
                                                                            <th>&nbsp;</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
                                                                        $count = 0;
                                                                        foreach ($antecedents as $key => $value) {
                                                                            ?>
                                                                            <tr class="">
                                                                                <td><?= ++$count ?></td>
                                                                                <td><?= $value->element ?></td>  
                                                                                <td><?php
                                                                                    switch ($value->type_antecedent) {
                                                                                        case 1:
                                                                                            echo 'Normal';
                                                                                            break;
                                                                                        case 2:
                                                                                            echo 'Familier';
                                                                                            break;
                                                                                        case 3:
                                                                                            echo 'Autre';
                                                                                    }
                                                                                    ?>
                                                                                </td> 
                                                                                <td><?= $value->detail ?></td>
                                                                                <td>
                                                                                    <a href=""><span class="glyphicon glyphicon-eye-open"></span></a>                                                      

                                                                                </td></tr>        

                        <?php }
                    ?>

                                                                    </tbody>                                      
                                                                </table>                 
                    <?php }
                ?>

                                                        </div>   

                                                    </div>
                                                    <div class="panel-footer">
                                                        <!--<a class="btn btn-info"><span class="glyphicon glyphicon-file"></span>Voir toutes</a>
                                                        <a class="btn btn-success"><span class="glyphicon glyphicon-edit"></span>Modifier</a>
                                                        <a class="btn btn-success"><span class="glyphicon glyphicon-eye-open"></span>Consulter now</a>-->
                                                    </div>
                                                </div>
                                                <div class="panel panel-primary panel-group">
                                                    <div class="panel-heading panel-primary">
                                                        <h4>TOUS ACTES MEDICAUX</h4>                                  
                                                    </div>
                                                    <div class="panel-body">
                                                        <div id="stripedTable" class="body collapse in">
                                                            <table class="table table-striped responsive-table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Ref</th>                                                            
                                                                        <th>Patient</th>
                                                                        <th>Agent</th>
                                                                        <th>Acte posé</th>
                                                                        <th>Category</th>
                                                                        <th>Date</th>
                                                                        <th>&nbsp;</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    if (isset($actes['results']) && count($actes['results']) > 0) {
                                                                        $count = 0;

                                                                        foreach ($actes['results'] as $item) {
                                                                            $count++;
                                                                            ?>
                                                                            <tr class="">
                                                                                <td><?= $count ?></td>
                                                                                <td><?= $item->id ?></td>
                                                                                <td>
                                                                                    <a href="/controls/control.php?mod=patient&act=view&id=<?= $item->idPatient ?>">
                                                                                        <h5><?= $item->nompatient . " " . $item->prenompatient ?></h5></a>
                                                                                </td>                                                    
                                                                                <td><?= $item->nomagent . " " . $item->prenomagent . "<br>(" . $item->fonctionagent . ")" ?></td>
                                                                                <td><?= $item->acte_pose ?></td>                                                    
                                                                                <td><?= $item->category ?></td>
                                                                                <td><?= Helpers\Date::dateToFr($item->date) ?></td>
                                                                                <td>
                                                                                    <a href="/public/actes_medicaux.php?action=view&id=<?= $item->id ?>"><span class="glyphicon glyphicon-eye-open"></span></a>                                                      

                                                                            </tr>        

                                                                        <?php
                                                                    }
                                                                } else {//Aucun acte posé
                                                                    ?>
                                                                    <div class="row"><div class="col-md-12"><h5 class="text-center alert alert-info alert-secondary alert-dismissible">Aucun acte n'est enregistré encore pour ce patient</h5> </div></div>
                    <?php
                }
                ?>

                                                                </tbody>                                      
                                                            </table>                                        
                                                        </div>   

                                                    </div>
                                                    <div class="panel-footer">
                                                        <!--<a class="btn btn-info"><span class="glyphicon glyphicon-file"></span>Voir toutes</a>
                                                        <a class="btn btn-success"><span class="glyphicon glyphicon-edit"></span>Modifier</a>
                                                        <a class="btn btn-success"><span class="glyphicon glyphicon-eye-open"></span>Consulter now</a>-->
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

                                            <?php } else {
                                            ?>
                                            <h2 class="text-center alert alert-info alert-secondary alert-dismissible">Aucun examen Patient trouvé avec cette identifiant</h2> 
                                            <?php
                                        }
                                        break; //Sortie $_GET['action']= view
                                    case "bind" :
                                        if (isset($_GET['id']) && count($patient) > 0) {
                                            $patient = $patient[0];
                                            $listStructure = $controller->dao->get("structureaffilier");
                                            ?>
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12">
                                                    <div class="col-lg-3">
                                                        <div class="wrapImgProfile">
                                                            <img src="/img/personnel/<?= $patient->filename . "." . $patient->type ?>" />
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
                                                                        if (count($listStructure) > 0) {
                                                                            foreach ($listStructure as $structure) {
                                                                                ?>
                                                                                <option value="<?= $structure->id ?>"><?= $structure->raisonsociale ?></option>                                            
                        <?php
                    }
                }
                ?>
                                                                    </select>
                                                                </span>
                                                            </div>
                                                            <input type="hidden" name="idpatient" value="<?= $patient->idPatient ?>"/>
                                                            <div class="line-personne-info"><span class="champ"></span><span class="val-line-personne-info"><button class="btn btn-success btn-grad" type="submit">Confirmer</button></span></div> 
                                                        </form>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="clearfix"><br>
                                                <br></div>

                                            <?php } else {
                                            ?>
                                            <h2 class="text-center alert alert-info alert-secondary alert-dismissible">Aucun examen Patient trouvé avec cette identifiant</h2> 
                                            <?php
                                        }
                                        break; //Sortie $_GET['action']= bind

                                    case "deceder" :
                                        if (isset($_GET['id']) && count($patient) > 0) {
                                            $patient = $patient[0];
                                            $listStructure = $controller->dao->get("structureaffilier");
                                            ?>
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12">
                                                    <div class="col-lg-3">
                                                        <div class="wrapImgProfile">
                                                            <img src="/img/personnel/<?= $patient->filename . "." . $patient->type ?>" />
                                                        </div>
                                                        <div class="">
                                                            <br>

                                                        </div>
                                                        <br>
                                                    </div>                       
                                                    <div class="col-lg-9 personne-info"> 
                                                        <form action="/controls/control.php?mod=patient&act=deceder" method="POST">
                                                            <div class="line-personne-info"><span class="champ">Nom :</span><span class="val-line-personne-info"><?= $patient->nom ?></span></div> 
                                                            <div class="line-personne-info"><span class="champ">Prénom :</span><span class="val-line-personne-info"><?= $patient->postnom ?></span></div> 
                                                            <div class="line-personne-info"><span class="champ">Post-nom :</span><span class="val-line-personne-info"><?= $patient->prenom ?></span></div> 
                                                            <div class="line-personne-info"><span class="champ">Lieu de naissance :</span><span class="val-line-personne-info"><?= $patient->lieuNaiss ?></span></div> 
                                                            <div class="line-personne-info"><span class="champ">Date de naissance :</span><span class="val-line-personne-info"><?= $patient->age ?></span></div> 
                                                            <div class="line-personne-info">
                                                                <span class="champ">Cause du décès :</span>
                                                                <span class="val-line-personne-info">
                                                                    <input class="form-control" name="cause"/>
                                                                </span>
                                                            </div>
                                                            <div class="line-personne-info">
                                                                <span class="champ">Lieu du décès :</span>
                                                                <span class="val-line-personne-info">
                                                                    <input class="form-control" name="lieu_deces"/>
                                                                </span>
                                                            </div>
                                                            <div class="line-personne-info">
                                                                <span class="champ">Date du décès :</span>
                                                                <span class="val-line-personne-info">
                                                                    <input class="form-control" type="date" name="date_deces"/>
                                                                </span>
                                                            </div>
                                                            <div class="line-personne-info">
                                                                <span class="champ">Observation sur le décès :</span>
                                                                <span class="val-line-personne-info">
                                                                    <textarea class="form-control" name="observation_deces"></textarea>
                                                                </span>
                                                            </div>
                                                            <input type="hidden" name="idpatient" value="<?= $patient->idPatient ?>"/>
                                                            <div class="line-personne-info"><span class="champ"></span><span class="val-line-personne-info"><button class="btn btn-success btn-grad" type="submit">Confirmer</button></span></div> 
                                                        </form>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="clearfix"><br>
                                                <br></div>

                                            <?php } else {
                                            ?>
                                            <h2 class="text-center alert alert-info alert-secondary alert-dismissible">Aucun examen Patient trouvé avec cette identifiant</h2> 
                                            <?php
                                        }
                                        break; //Sortie $_GET['action']= deceder
                                }
                            } else {
                                if (count($listPatient['results']) > 0) {
                                    $plife = $controller->getListNormal("0");
                                    $pdie = $controller->getListNormal("1");
                                 
                                    ?>
                                    <div class="">
                                        <div class="col-lg-12">
                                            <div class="text-center">
                                                        <ul class="stats_box">
                                                            <li>
                                                                <div class="sparkline bar_week"></div>
                                                                <div class="stat_text">
                                                                    <strong><?=  (isset($plife)) ? count($plife) : "0" ?></strong>En vie
                                                                    <span class="percent up"> <i class="fa fa-caret-down"></i> </span>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="sparkline line_day"></div>
                                                                <?php
                                                               
                                                                ?>
                                                                <div class="stat_text">
                                                                    <strong><?=  (isset($pdie)) ? count($pdie) : "0" ?></strong>Décédé(e)s
                                                                    <span class="percent up"> <i class="fa fa-caret-up"></i> </span>
                                                                </div>
                                                            </li>                                                                                    
                                                        </ul>
                                                    </div>
                                            <div class="box">
                                                <header>
                                                    <h5></h5>
                                                    <div class="toolbar">
                                                        <ul class="nav">
                                                            <div class="toolbar">
                                                                <ul class="nav">
                                                                    <li>
                                                                        <form action="/controls/control.php?mod=patient&amp;act=searchpatient" method="get" class="form-inline searchform">
                                                                            <div class=" form-group top_search">
                                                                                <div class="input-group">
                                                                                    <input type="text" class="form-control input-search-patient" name="q" placeholder="Recherche...">
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
                                                                            
                                                                            <li><a href="/public/patients.php?statut=">Tout</a></li>
                                                                            <li><a href="/public/patients.php?statut=1">Décédé</a></li>
                                                                            <li><a href="/public/patients.php?statut=0">En vie</a></li>
                                                                            <li><a href="#"><i class="icon-external-link"></i>Date</a></li>
                                                                            
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
                                                                <th style="width: 25%"><span class="glyphicon glyphicon-user"></span></th>
                                                                <th style="width: 25%"><span class="glyphicon glyphicon-qrcode"></span> NUP</th>
                                                                <th>N°Fiche</th>
                                                                <th> <span class="glyphicon glyphicon-th-list"></span>&nbsp;Structure</th>
                                                                <th><span class="glyphicon glyphicon-th"></span>&nbsp;Type</th>
                                                                <th>Sexe</th>
                                                                <th>Statut</th>
                                                                <th>Date</th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $count = 0;
                                                            foreach ($listPatient['results'] as $key => $patient) {
                                                                
                                                                $count++
                                                                ?>
                                                                <tr>
                                                                    <td><?= $count ?></td>
                                                                    <td><a href="/controls/control.php?mod=patient&act=view&id=<?= $patient->idPatient ?>" ><img src="/img/personnel/passport.png" class="user-profile"/>
                                                                            <h5><?= $patient->nom . " " . $patient->postnom . " " . $patient->prenom ?></h5></a></td>
                                                                    <td style="width: 25%"> <?= ($patient->nu) ? $patient->nu : "" ?></td>
                                                                    <td><?= ($patient->numinterne) ? $patient->numinterne : "" ?></td>
                                                                    <td><?= (!empty($patient->raisonsociale)) ? $patient->raisonsociale : "Privé" ?></td>

                                                                    <td><?= ($patient->typePatient ==  0) ? "Ordinaire" : ($patient->typePatient ==  1) ? "Affilié" : "Interne " ?></td>
                                                                    <td><?= $patient->sexe ?></td>
                                                                    <td><?= ($patient->statut == 0) ? " En vie"  : "Décédé"?></td>
                                                                    <td><?= Date::reFormat($patient->dateEnregistrement) ?></td>
                                                                    <td><a class="text-danger" href="/controls/control.php?mod=patient&act=del&id=<?= $patient->idPatient ?>"><span class="glyphicon glyphicon-remove"></span></a></td>
                                                                </tr>                        
                                                                <?php
                                                            }
                                                            ?>



                                                        </tbody>               
                                                    </table>
                                                </div>
                                                <div style="padding: 10px;">
        <?= composants\Utilitaire::pagination($listPatient['nbPages'], 100, "/public/patients.php?") ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.inner -->
                                </div>
                                <?php } else {
                                ?>

                                <div class="row">
                                    <div class="col-md-12">
                                        <p class="alert alert-info">Aucun patient n'est trouvé. Veuilllez enregistrer un en cliquant sur icone plus ci haut à droite</p>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                    <!-- /.outer -->
            </div>

            <div class="modal fade" id="addAnt" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
                <form class="form" action="/controls/control.php?mod=patient&act=addAnt&id=<?= $_GET['id'] ?>" method="POST" id="addAntecedent">
                    <div class="modal-dialog " >
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Ajouter Antécédent</h4>
                            </div>
                            <div class="modal-body">

                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Elément" name="element">
                                </div>
                                <div class="form-group">
                                    <select type="text" class="form-control" placeholder="Type d'antécedent" name="type">
                                        <option value="-1">Type d'antécédent</option>
                                        <option value="1">Personnel</option>
                                        <option value="2">Familier</option>
                                        <option value="3">Autre</option>
                                    </select>
                                </div>
                                <div class="form-group">                                                
                                    <textarea type="text" class="form-control" rows="6" style="resize: none" placeholder="Détails" name="detail"></textarea>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Enregistrer</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <?php
            include_once ROOT . DS . "squelette" . DS . "footer.php";
            include_once ROOT . DS . "squelette" . DS . "endPage.php";
            ?>