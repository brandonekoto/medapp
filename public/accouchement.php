<?php
$config = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "config.php";
$config = str_replace("/", DIRECTORY_SEPARATOR, $config);
include_once $config;
$controlerAccouchment = new \controls\Accouchement();
$controller = new \controls\Acte();
$controllerPatient = new controls\Patient();
$listActes = $controller->getActes();
$listPatiens = $controllerPatient->getList();
$listExamen = $controller->getListExamen();
$controllerPharmacy = new \controls\Pharmacy();
$controlUser = new controls\User();
$accouchement = [];

use Helpers\Date;

if (isset($_SESSION['data'])) {
    extract($_SESSION['data']);
}
if (isset($_GET['action'])) {//
    switch ($_GET['action']) {
        case "add":
            $filariane = array(
                'Accouchement' => "/public/accouchement.php",
                'Création du nouvel acte accouchement' => "/public/accouchement.php?action=add",
                'Initialisation' => ""
            );
            $titlePage = "Initialisation du nouvel acte accouchement";
            break;
        case "view" :
            $filariane = array(
                'Actes médicaux' => "/public/actes_medicaux.php",
                'Accouchement' => "/public/accouchement.php",
                'Visualisation accouchement' => "/public/accouchement.php",
                $_GET['id'] => ""
            );
            $titlePage = "Visualisation de l'accouchement";
            break;

        case "viewextrat" :
            $filariane = array(
                'Actes médicaux' => "/public/actes_medicaux.php",
                'Visualisation Acte' => "/public/actes_medicaux.php",
                "detail extrat" => ""
            );
            $titlePage = "Visualisation de l'acte";
            break;

        case "listdiagnistic" :
            $filariane = array(
                'Actes médicaux' => "/public/actes_medicaux.php",
                'Liste des diagnostics ' => "",
            );
            $titlePage = "Liste des diagnostics";
            break;
        case "hospitaliser":
            $filariane = array(
                'Actes médicaux' => "/public/actes_medicaux.php",
                'Hospitaliser ' => "",
            );
            $titlePage = "Hospitaliser";
            break;
        case "dehospitaliser":
            $filariane = array(
                'Actes médicaux' => "/public/actes_medicaux.php",
                'Déshospitaliser ' => "",
            );
            $titlePage = "Déshospitaliser";
            break;
        case "transferer":
            $filariane = array(
                'Actes médicaux' => "/public/actes_medicaux.php",
                'Hospitalisation ' => "",
                'Transférs ' => "",
            );
            $titlePage = "Transfers du patient";
            break;
        case "addExtrat":
            $filariane = array(
                'Actes médicaux' => "/public/actes_medicaux.php",
                $_GET['id'] => "",
                'Ajout Extra ' => "",
            );
            $titlePage = "Extra";
            break;
        case "hospitalisation":
            $filariane = array(
                'Actes médicaux' => "/public/actes_medicaux.php",
                'Hospitalisation & Chambre/Lits ' => "",
            );
            $titlePage = "Hospitaliser";

            break;
        case "prescrire" :
            if (isset($_GET['m'])) {
                switch ($_GET['m']) {
                    case "viewdetail":
                        $filariane = array(
                            'Actes médicaux' => "/public/actes_medicaux.php",
                            'Prescrire ' => "/public/actes_medicaux.php",
                            $_GET['id'] => "",
                            "Liste des éléments prescrit" => ""
                        );
                        $titlePage = "Prescription";
                        break;
                    case "init":
                        $filariane = array(
                            'Actes Médicaux' => "/public/actes_medicaux.php",
                            'Prescrire ' => "/public/actes_medicaux.php",
                            "Initialisation" => "",
                            $_GET['id'] => ""
                        );
                        $titlePage = "Initialisation de la prescription";
                        break;

                    default:
                        break;
                }
            } else {
                $filariane = array(
                    'Actes médicaux' => "/public/actes_medicaux.php",
                    'Prescrire ' => "/public/actes_medicaux.php",
                );
                $titlePage = "Prescription";
                break;
            }
            break;

        case "diagnostiquer":
            $filariane = array(
                'Actes médicaux' => "/public/actes_medicaux.php",
                'Diagnistiquer ' => "/public/actes_medicaux.php",
            );
            $titlePage = "Diagnostiquer";
            break;
        case "consulter":
            $filariane = array(
                'Actes médicaux' => "/public/actes_medicaux.php",
                'Prélèvement des signes vitaux ' => "/public/actes_medicaux.php",
            );
            $titlePage = "Prélèvement des signes vitaux";
            break;

        case "examen":
            if (isset($_GET['m'])) {
                switch ($_GET['m']) {
                    case "doexamen":
                        $filariane = array(
                            'Actes médicaux' => "/public/actes_medicaux.php",
                            'Laboratoire ' => "/public/actes_medicaux.php",
                            'Faire examen' => "",
                            $_GET['id'] => ""
                        );
                        $titlePage = "Faire examen | Labo";
                        break;
                    case "voirettiques":
                        $filariane = array(
                            'Actes médicaux' => "/public/actes_medicaux.php",
                            'Laboratoire ' => "/public/actes_medicaux.php",
                            'Faire examen ' => "/public/actes_medicaux.php",
                            'Voir etiquette' => "",
                            $_GET['id'] => ""
                        );
                        $titlePage = "Voir étiquette | Labo";
                        break;

                    case "doprelever":
                        $filariane = array(
                            'Actes médicaux' => "/public/actes_medicaux.php",
                            'Laboratoire ' => "/public/actes_medicaux.php",
                            'Prélèvelement patient' => "",
                            $_GET['id'] => ""
                        );
                        $titlePage = "Prélèvelement patient | Labo";
                        break;
                    case "addexamen":
                        $filariane = array(
                            'Actes médicaux' => "/public/actes_medicaux.php",
                            'Laboratoire ' => "/public/actes_medicaux.php",
                            'Ajout des examens  | Médecin ' => "",
                            $_GET['id'] => ""
                        );
                        $titlePage = "Ajout des examens | Médecin";
                        break;

                    default:
                        break;
                }
            } else {
                $filariane = array(
                    'Actes médicaux' => "/public/actes_medicaux.php",
                    'Laboratoire ' => "/public/actes_medicaux.php",
                    'Liste des examens ' => ""
                );
                $titlePage = "Liste des examens ";
                break;
            }
            break;
        case 'nursing':
            $filariane = array(
                'Actes médicaux' => "/public/actes_medicaux.php",
                'Nursing ' => "/public/actes_medicaux.php",
                $_GET['id'] => ""
            );
            $titlePage = "Nursing (Soins & traitement) ";
            break;

        case 'edition':
            $condition['where'] = " WHERE DATE(facture_acte.date_facture) LIKE '%" . $start = date('Y-m-d') . "%'";
            $counttoday = $controller->getfacturetotal($condition);
            unset($condition);
            $condition['where'] = " WHERE DATE(facture_acte.date_facture) LIKE '%" . $start = date('Y-m-d') . "%' AND facture_acte.id_agent ='" . $_SESSION['user']['agent'] . "'";
            $countmoi = $controller->getfacturetotal($condition);
            unset($condition);
            $start = date('Y-m') . "-01";
            $end = date('Y-m') . date('-t');
            $condition['where'] = " WHERE DATE(facture_acte.date_facture) BETWEEN '$start' AND '$end'";

            unset($start);
            unset($end);
            $countMonth = $controller->getfacturetotal($condition);
            unset($condition);
            $filariane = array(
                'Actes médicaux' => "/public/actes_medicaux.php",
                'Edition ' => "/public/actes_medicaux.php",
                'Rapport ' => ""
            );
            $titlePage = "Edition des rapports ";
            break;
    }
} else {
    $filariane = array(
        'Actes medicaux' => "",
        'Liste des accouchements' => ""
    );
    $titlePage = "Liste des accouchements";
    $accouchement = $controlerAccouchment->getList();
    //composants\Utilitaire::debug($accouchement, true);
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
                    <?= $titlePage ?>
                </h3>
                <div class="box-options">
                    <a href="/public/accouchement.php?action=add&etape=0" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> </a>
                    <a href="/public/actes_medicaux.php?action=print" class="btn btn-primary"><span class="glyphicon glyphicon-print"></span> </a>
                </div>
            </div>
            <div class="col-lg-12">
                <?php
                ($session->flash());
                ?> 
            </div>

            <?php
            if (isset($_GET['action'])) {
                switch ($_GET['action']) {
                    case "add":
                        ?>
                        <div class="">
                            <?php if (isset($_GET['etape'])) { ?>
                                <div class="col-md-12">
                                    <div class="content-box-large">
                                        <div class="panel-heading">
                                            <div class="panel-title"></div>
                                        </div>
                                        <div class="panel-body">
                                            <div id="rootwizard">
                                                <div class="navbar" style="overflow: hidden; ">
                                                    <div class="navbar-inner">
                                                        <div class="container">
                                                            <ul class="nav nav-tabs" style="padding-left: 50px">
                                                                <li class="active" ><a href="#tab1" data-toggle="tab">Initialisation</a></li>
                                                                <li class=""><a href="#tab2" data-toggle="tab">Enfants</a></li>                                                                
                                                            </ul>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-content">
                                                    <div class="tab-pane active" id="tab1">
                                                        <form class="form-horizontal" role="form" id="formInitActe" action="/controls/control.php?mod=accouchement&act=init" method="POST" autocomplete="off">
                                                            <div class="alert alert-info alert-error">
                                                                <h3>Bienvenue à l'initiation du processus accouchement</h3>
                                                                <p>Tout acte poser sur un patient doit être initialiser</p>
                                                                <p>Notez bien que la patiente (porteuse de la grossesse) doit être enregstré d'abord c'est à dire créer d'abord la fiche du patient</p>
                                                                <p>Pour ajouter l (es) enfant (s) enfanté (s) en cliquant sur l'onglet "ENFANTS" </p>

                                                                <p>La cherche du patient se fait sur la zone labelisée Patient, <br>Il y a 4 façons de rechercher un patient, Soit par nom, soit prenom, soit postnom et enfin par son numero carte</p>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="inputEmail3" class="col-sm-2 control-label">Acte médical</label>
                                                                <div class="col-sm-10">
                                                                    <select class="form-control" name="acte_medical" id="" >
                                                                        <option value="106" selected >Acouchement</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="inputEmail3" class="col-sm-2 control-label">Patient</label>                                                                
                                                                <div class="col-sm-10">
                                                                    <input class="searchpatient form-control" type="search" name="patient" placeholder="Recherche patient par nom, postnom, prenom ou numero fiche"/>
                                                                    <!--
                                                                    <select class="form-control" name="patient" id="selectPatientForActe">
                                                                    <?php
                                                                    if (count($listPatiens['results']) > 0) {

                                                                        foreach ($listPatiens['results'] as $key => $itemPatient) {
                                                                            ?>
                                                                                                                                                                                                                                <option value="<?= $itemPatient->idPatient ?>" data-patientId="<?= $itemPatient->idPatient ?>"><?= $itemPatient->nom . " " . $itemPatient->postnom ?></option>
                                                                            <?php
                                                                        }
                                                                    }
                                                                    ?>

                                                                    </select>-->
                                                                </div>
                                                            </div>
                                                            <div  class="form-group" id="patient">
                                                                <div class="col-sm-2">

                                                                </div>
                                                                <div class="col-sm-10 patientInfo" id="patientInfo">
                                                                    <p class="alert alert-warning">Aucun patient selectionné</p>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <button  type="submit" class="form-control btn btn-metis-6 btn-grad"><i class="glyphicon glyphicon-save-file"></i> Enregistrer</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="tab-pane" id="tab2">
                                                        <form class="form-horizontal" role="form" id="formConsultation" method="POST" action="/controls/control.php?mod=acte&act=addconsultationinfo" autocomplete="off">
                                                            <div class="alert alert-info alert-error">
                                                                <h3>Bienvenue à l'enregistrement de l'enfants ou des enfants enfanté (s)</h3>
                                                                <p>Etant donné un accoucjement est considérée comme un acte et il se rapporte à une patiente biev identifiée, vous devriez saisir la référence de l'acte initialisé pour cete patiente pour enregistrer son (ses) enfant(s) </p>
                                                                <p>Pour vous faciliter la tâche le système vous permet de retrouvez l'acte soit par le nom du patient soit vous saisissez directement la référence Acte pour plus de précision</p>
                                                                <p>Si la patiente a fait des jumbeaux ou triplets, le tableau à la droit du formulaire vous permet d'ajouter autant d'enfants voulus. <br>Cette action conduira à la création des patients qui sont ces enfants enfantés.
                                                                </p>
                                                            </div>
                                                            <div class='col-lg-12'>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="inputEmail3" class="col-sm-2 control-label">Recherche Acte </label>
                                                                            <div class="col-sm-10">
                                                                                <div class="input-group">
                                                                                    <input type="text" class="form-control ui-autocomplete-input refCat" id="acte_accouchement" name="acte_medical" class="" placeholder="Recherche Réf Acte  " autocomplete="off">
                                                                                    <span class="input-group-btn">
                                                                                        <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-search"></span></button>
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div  class="form-group">
                                                                            <label for="inputEmail3" class="col-sm-2 control-label">Porteuse</label>
                                                                            <input type="hidden" name="patient" id="idPatientConsult">
                                                                            <div class="col-sm-10 patientInfo" id="patientInfo">
                                                                                <p class="alert alert-warning">Aucune patiente n'est selectionnée</p>
                                                                            </div>
                                                                        </div>
                                                                        <!--
                                                                        <div class="form-group">
                                                                            <label for="inputEmail3" class="col-sm-2 control-label">Acte médical</label>
                                                                            <div class="col-sm-10">
                                                                                <select class="form-control" name="acte_medical">
                                                                        <?php
                                                                        $cle = null;
                                                                        if (count($listActes) > 0) {
                                                                            foreach ($listActes as $key => $itemActe) {

                                                                                if ($cle !== $itemActe->id_cat) {
                                                                                    ?>
                                                                                                                                                                                                                                    <optgroup label="<?= $itemActe->category ?>" data-category_acte='<?= $itemActe->id_cat ?>'>
                                                                                                                                                                                                                                    <option value="<?= $itemActe->id ?>" data-category_acte='<?= $itemActe->id_cat ?>' data-id='<?= $itemActe->id ?>' ><?= $itemActe->acte ?></option>
                                                                                                                                                                                                                                    
                                                                                    <?php
                                                                                    $cle = $itemActe->id_cat;
                                                                                } else {
                                                                                    ?>
                                                                                                                                                                                                                                    <option value="<?= $itemActe->id ?>" data-category_acte='<?= $itemActe->id_cat ?>'  data-id='<?= $itemActe->id ?>'><?= $itemActe->acte ?></option>
                                                                                    <?php
                                                                                }
                                                                                ?>
                                                                                <?php
                                                                            }
                                                                        }
                                                                        ?>
                                                                                </select>
                                                                            </div>
                                                                        </div>-->


                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <div>Informations personnelles</div>
                                                                                <hr>
                                                                                <div class="form-group">
                                                                                    <label class="control-label col-lg-4">Image de l'enfant</label>
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
                                                                                        <input type="text" id="nom" name="nom" placeholder="Nom"value="<?= (isset($nom)) ? $nom : "" ?>" class="form-control">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label for="text1" class="control-label col-lg-4">Post-nom</label>

                                                                                    <div class="col-lg-8">
                                                                                        <input type="text" id="postnom"  name="postnom" value="<?= (isset($postnom)) ? $postnom : "" ?>"placeholder="Post-nom" class="form-control">
                                                                                    </div>

                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label for="text1"  class="control-label col-lg-4">Prénom</label>

                                                                                    <div class="col-lg-8">
                                                                                        <input type="text" id="prenom" name="prenom" value="<?= (isset($prenom)) ? $prenom : "" ?>" placeholder="Prénom" class="form-control">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label for="text1"  class="control-label col-lg-4">Date de naissance</label>

                                                                                    <div class="col-lg-8">
                                                                                        <input type="date" id="datenaiss" name="datenaiss" value="<?= (isset($datenaiss)) ? $datenaiss : "" ?>" placeholder="Date de naissance du bébé" class="form-control">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label class="control-label col-lg-4">Sexe</label>

                                                                                    <div class="col-lg-8">
                                                                                        <select class="form-control" id="sexe" name="sexe">
                                                                                            <option value="">Choisir votre sexe</option>
                                                                                            <option value="M" <?= (isset($sexe) && $sexe == "M") ? "selected" : "" ?>>Masculin</option>
                                                                                            <option value="F" <?= (isset($sexe) && $sexe == "F") ? "selected" : "" ?>>Féminin</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label for="text1"  class="control-label col-lg-4">Groupe Sanguin</label>

                                                                                    <div class="col-lg-8">
                                                                                        <select type="text" id="group_sang" name="sang" value="<?= (isset($sang)) ? $sang : "" ?>" placeholder="Groupe Sanguin" class="form-control">
                                                                                            <option value="A" <?= isset($sang) && $sang == "A" ? "selected" : "" ?>>A</option>
                                                                                            <option value="B" <?= isset($sang) && $sang == "B" ? "selected" : "" ?>>B</option>
                                                                                            <option value="AB" <?= isset($sang) && $sang == "AB" ? "selected" : "" ?>>AB</option>
                                                                                            <option value="O" <?= isset($sang) && $sang == "O" ? "selected" : "" ?>>O</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>


                                                                            </div>
                                                                        </div>

                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <div>Informations corporelle</div>
                                                                                <hr>
                                                                                <div class="form-group">
                                                                                    <label for="text1" class="control-label col-lg-12">Corpulence </label>
                                                                                    <div class="col-lg-6">
                                                                                        <input type="number" id="poids" name="poids" placeholder="Pois en kilogramme"value="<?= (isset($poids)) ? $poids : "" ?>" class="form-control">
                                                                                    </div>
                                                                                    <div class="col-lg-6">
                                                                                        <input type="number" id="taille" name="taille" placeholder="Taille en cm"value="<?= (isset($taille)) ? $taille : "" ?>" class="form-control">
                                                                                    </div>                                                                                    
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label for="text1" class="control-label col-lg-12">&nbsp; </label>
                                                                                    <div class="col-lg-6">
                                                                                        <input type="text" id="apgar" name="apgar" placeholder="APGAR"value="<?= (isset($apgar)) ? $apgar : "" ?>" class="form-control">
                                                                                    </div>
                                                                                    <div class="col-lg-6">
                                                                                        <input type="number" id="pc" name="pc" placeholder="PC"value="<?= (isset($pc)) ? $pc : "" ?>" class="form-control">
                                                                                    </div>                                                                                    
                                                                                </div>

                                                                            </div>
                                                                        </div>

                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <div>Informations sur accouchement</div>
                                                                                <hr>
                                                                                <div class="form-group">
                                                                                    <label for="text1" class="control-label col-lg-4">Mode </label>

                                                                                    <div class="col-lg-8">
                                                                                        <select id="mode" name="mode" placeholder="Mode d'accouchement"  class="form-control">
                                                                                            <option value="0">Normal</option>
                                                                                            <option value="1">Césarienne</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label for="text1" class="control-label col-lg-4">Etat </label>

                                                                                    <div class="col-lg-8">
                                                                                        <select id="mode" name="etat" placeholder="Etat du bébé"  class="form-control">
                                                                                            <option value="0">En vie</option>
                                                                                            <option value="1">Décédé</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label for="text1" class="control-label col-lg-4">Heure </label>

                                                                                    <div class="col-lg-8">
                                                                                        <input type="time" id="heureAccouchement" name="heureAccouchement" placeholder="Heure Accouchement"value="<?= (isset($heureAccouchement)) ? $heureAccouchement : "" ?>" class="form-control">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label for="text1" class="control-label col-lg-4">Durée </label>

                                                                                    <div class="col-lg-8">
                                                                                        <input type="time" id="dureAccouchement" name="duree" placeholder="La durée de l'accouchement exprimer en minutes"value="<?= (isset($duree)) ? $duree : "" ?>" class="form-control">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <div>Renseignements maternels </div>
                                                                                <hr>

                                                                                <div class="form-group">
                                                                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                                                                        <input type="text" id="gestite" name="gestite" placeholder="Gestité"value="<?= (isset($gestite)) ? $gestite : "" ?>" class="form-control">
                                                                                    </div>
                                                                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                                                                        <input type="text" id="parite" name="parite" placeholder="Parité"value="<?= (isset($parite)) ? $parite : "" ?>" class="form-control">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                                                                        <select type="text" id="diabete" name="diabete" placeholder="Diabete" class="form-control">
                                                                                            <option value="">Diabete</option>
                                                                                            <option value="1">Oui</option>
                                                                                            <option value="0">Non</option>
                                                                                        </select>
                                                                                    </div>
                                                                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                                                                        <input type="text" id="glycemie" name="glycemie" placeholder="Dernière glycémie"value="<?= (isset($glycemie)) ? $glycemie : "" ?>" class="form-control">
                                                                                    </div>
                                                                                </div>

                                                                                <div class="form-group">
                                                                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                                                                        <select type="text" id="hta" name="hta" placeholder="Diabete" class="form-control">
                                                                                            <option value="">HTA</option>
                                                                                            <option value="1">Oui</option>
                                                                                            <option value="0">Non</option>
                                                                                        </select>
                                                                                    </div>
                                                                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                                                                        <input type="text" id="ta" name="ta" placeholder="Dernière TA"value="<?= (isset($ta)) ? $ta : "" ?>" class="form-control">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                                                                        <input type="text" id="hiv" name="hiv" placeholder="Test HIV" value="<?= (isset($hiv)) ? $hiv : "" ?>" class="form-control">
                                                                                    </div>
                                                                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                                                                        <input type="text" id="tbc" name="tbc" placeholder="TBC"value="<?= (isset($tbc)) ? $tbc : "" ?>" class="form-control">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                                                                        <input type="text" id="ddr" name="ddr" placeholder="DDR"value="<?= (isset($ddr)) ? $ddr : "" ?>" class="form-control">
                                                                                    </div>
                                                                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                                                                        <input type="text" id="tp" name="tp" placeholder="TP"value="<?= (isset($tp)) ? $tp : "" ?>" class="form-control">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">                                                                                    
                                                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                                                        <textarea type="text" id="cpn" name="cpn" placeholder="CPN"value="<?= (isset($cpn)) ? $cpn : "" ?>" class="form-control"></textarea>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <div class="col-lg-9 col-md-9 col-sm-12">
                                                                                        <input type="text" id="echo" name="echo" placeholder="Echo"value="<?= (isset($echo)) ? $echo : "" ?>" class="form-control">
                                                                                    </div>
                                                                                    <div class="col-lg-3 col-md-3 col-sm-12">
                                                                                        <input type="text" id="urogen" name="urogen" placeholder="Inf. urogen"value="<?= (isset($urogen)) ? $urogen : "" ?>" class="form-control">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                                                                        <input type="text" id="rpm" name="rpm" placeholder="RPM" value="<?= (isset($rpm)) ? $rpm : "" ?>" class="form-control">
                                                                                    </div>
                                                                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                                                                        <input type="text" id="la" name="la" placeholder="La"value="<?= (isset($la)) ? $la : "" ?>" class="form-control">
                                                                                    </div>
                                                                                </div>

                                                                            </div>
                                                                        </div>

                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <div>Informations sur Examens physiques</div>
                                                                                <div>Examen Morphologique</div>
                                                                                <hr>
                                                                                <div class="form-group">
                                                                                    <label for="text1" class="control-label col-lg-12">Race </label>

                                                                                    <div class="col-lg-6">
                                                                                        <input  id="teint" name="teint" placeholder="Teint" value="<?= (isset($fc)) ? $fc : "" ?>" class="form-control">
                                                                                    </div>
                                                                                    <div class="col-lg-6">
                                                                                        <input id="tt" name="t" placeholder="T°"value="<?= (isset($t)) ? $t : "" ?>" class="form-control">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label for="text1" class="control-label col-lg-12">Tête </label>

                                                                                    <div class="col-lg-12">
                                                                                        <input  id="conjonctives" name="conjonctives" placeholder="Conjonctives"value="<?= (isset($conjonctives)) ? $conjonctives : "" ?>" class="form-control">
                                                                                    </div>

                                                                                </div>

                                                                                <div class="form-group">
                                                                                    <label for="text1" class="control-label col-lg-12">Thorax </label>

                                                                                    <div class="col-lg-6">
                                                                                        <input  id="fc" name="fc" placeholder="Coeur (FC)" value="<?= (isset($fc)) ? $fc : "" ?>" class="form-control">
                                                                                    </div>
                                                                                    <div class="col-lg-6">
                                                                                        <input id="fr" name="fr" placeholder="Poumons (FR)"value="<?= (isset($fr)) ? $fr : "" ?>" class="form-control">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">

                                                                                    <div class="col-lg-12">
                                                                                        <textarea  id="abdomen" name="abdomen" placeholder="Abdomen"value="<?= (isset($duree)) ? $duree : "" ?>" class="form-control"></textarea>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">                                                                                   
                                                                                    <div class="col-lg-12">
                                                                                        <textarea  id="ogf" name="ogf" placeholder="Organes génitaux externes"value="<?= (isset($ogf)) ? $ogf : "" ?>" class="form-control"></textarea>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">                                                                                   
                                                                                    <div class="col-lg-12">
                                                                                        <textarea  id="autres" name="autres" placeholder="Autres"value="<?= (isset($autres)) ? $autres : "" ?>" class="form-control"></textarea>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <div>Examen Neurologique</div>

                                                                                <hr>
                                                                                <div class="form-group">
                                                                                    <label for="text1" class="control-label col-lg-12">Comportement </label>

                                                                                    <div class="col-md-12">
                                                                                        <textarea  id="vigilance" name="vigilance" placeholder="Vigilance" value="<?= (isset($vigilance)) ? $vigilance : "" ?>" class="form-control"></textarea>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <div class="col-md-12">
                                                                                        <textarea  id="motilite" name="motilite" placeholder="Motilité spontanée et réactivité" value="<?= (isset($motilite)) ? $motilite : "" ?>" class="form-control"></textarea>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <div class="col-md-12">
                                                                                        <textarea  id="eri" name="eri" placeholder="Eri" value="<?= (isset($eri)) ? $eri : "" ?>" class="form-control"></textarea>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label for="text1" class="control-label col-lg-12">Tonus </label>
                                                                                    <div class="col-md-12">
                                                                                        <textarea  id="tonus_actif" name="tonus_actif" placeholder="Actif" value="<?= (isset($tonus_actif)) ? $tonus_actif : "" ?>" class="form-control"></textarea>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <div class="col-md-12">
                                                                                        <textarea  id="tonus_passif" name="tonus_passif" placeholder="Passif" value="<?= (isset($tonus_passif)) ? $tonus_actif : "" ?>" class="form-control"></textarea>
                                                                                    </div>

                                                                                </div>

                                                                                <div class="form-group">
                                                                                    <label for="text1" class="control-label col-lg-12">Reflexes </label>
                                                                                    <div class="col-md-12">
                                                                                        <textarea  id="succion" name="succion" placeholder="Succin-deglutition" value="<?= (isset($succion)) ? $succion : "" ?>" class="form-control"></textarea>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <div class="col-md-12">
                                                                                        <textarea  id="grasping" name="grasping" placeholder="Grasping " value="<?= (isset($grasping)) ? $grasping : "" ?>" class="form-control"></textarea>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <div class="col-md-12">
                                                                                        <textarea  id="moro" name="moro" placeholder="Moro " value="<?= (isset($moro)) ? $moro : "" ?>" class="form-control"></textarea>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <div class="col-md-12">
                                                                                        <textarea  id="extension_croisee" name="extension_croisee" placeholder="Extension croisee " value="<?= (isset($extension_croisee)) ? $extension_croisee : "" ?>" class="form-control"></textarea>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <div class="col-md-12">
                                                                                        <textarea  id="galand_incurvation" name="galand_incurvation" placeholder="Galand incurvation " value="<?= (isset($galand_incurvation)) ? $galand_incurvation : "" ?>" class="form-control"></textarea>
                                                                                    </div>
                                                                                </div>
                                                                                <hr>
                                                                                <div class="form-group">
                                                                                    <div class="col-md-12">
                                                                                        <button type="button" class="form-control btn btn-metis-6 btn-grad" id="btn-add-baby"><i class="glyphicon glyphicon-save-file"></i> Ajouter</button></div>
                                                                                </div>
                                                                            </div>
                                                                        </div>



                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <h3 style="margin: 0; padding: 0">
                                                                                    Liste des enfants              </h3>
                                                                                <div class="box-options" style="margin: 0; padding: 0">
                                                                                    <a href="#" class="btn btn-success" id="btn-reset-babies"><span class="glyphicon glyphicon-refresh"></span> </a>
                                                                                    <a href="#" class="btn btn-success" id="btn-confirm-babies"><span class="glyphicon glyphicon-ok"></span> </a>

                                                                                </div>
                                                                                <br>
                                                                                <hr>
                                                                            </div>
                                                                            <div class="col-md-12" id="stat_babies_form">
                                                                                <div class="p-3 m-2">
                                                                                    Nombre de bébés : <span class="nb_bb">0</span>
                                                                                </div>
                                                                                <hr>
                                                                            </div>
                                                                            
                                                                            <div class="col-md-12" id="list_baby">

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <!--
                                                    <div class="tab-pane" id="tab3">
                                                        <form class="form-horizontal" role="form" id="formDiagnostic" method="post" action="/controls/control.php?mod=acte&act=addDiagnostic">
                                                            <div class="form-group">
                                                                <label for="inputEmail3" class="col-sm-2 control-label">Recherche acte</label>
                                                                <div class="col-sm-10">
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control refCat" name="acte_pose" id="" placeholder="Recherche Réf Acte/Consultation...">

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
                                                                    <h3 style="padding: 0; margin: 0">KAPENA PATRICK</h3>                                                                                                                                                                      
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-sm-2">

                                                                </div>
                                                                <div class="col-sm-10 patientInfo" id="patientInfo">
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
                                                                    <div class="input-group">
                                                                        <select class="form-control" name="listExamen" id="listExamen">
                                                    <?php
                                                    if (count($listExamen) > 0) {
                                                        foreach ($listExamen as $key => $itemActe) {
                                                            ?>
                                                                                                                                                                                                                                <option value="<?= $itemActe->id ?>" data-id='<?= $itemActe->id ?>'><?= $itemActe->lib ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                                        </select>
                                                                        <span class="input-group-btn">
                                                                            <a id="btn-add-examen" class="btn btn-default" href="/controls/control.php?mod=acte&act=addexamen&id" type="button"><span class="glyphicon glyphicon-plus"></span></a>
                                                                        </span>
                                                                    </div>
                                                                    <div class="col-lg-12" style="padding: 10px 0px" id="listExamenAfaire">
                                                                        <ul>
                                                                            <li>VIH <a href="" class="text-danger"><span class="glyphicon glyphicon-remove"></span></a></li>

                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-sm-2 control-label">Observations</label>
                                                                <div class="col-sm-10">
                                                                    <textarea class="form-control" placeholder="Textarea" name="obs" rows="6"></textarea>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <button type="submit" class="form-control btn btn-metis-6 btn-grad"><i class="glyphicon glyphicon-save-file"></i> Enregistrer</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="tab-pane" id="tab4">
                                                        <form class="form-horizontal" role="form">
                                                            <div class="form-group">
                                                                <label for="inputEmail3" class="col-sm-2 control-label">Recherche acte</label>
                                                                <div class="col-sm-10">
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control refDiagnostic" id="" placeholder="Recherche Réf Acte/Consultation...">
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
                                                    </ul>--><br><br><br>
                                                </div>	
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <?php
                            }//Fin etape processus Initialisation acte, consultation, diagnostic, labo et prescription 
                            // Fin $_GET['etape']
                            break; //fin swith add   
                            ?>
                            <?php
                            break; // Fin add                     
                        case "view" :
                            if (isset($_GET['id']) && !empty($_GET['id'])) {
                                $seeActe = $controller->getlistacte($_GET);

                                if (count($seeActe) > 0) {
                                    $seeActe = $seeActe[0];
                                    $accDetail = $controlerAccouchment->getDetail(["idacte" => $seeActe->idactepose]);

                                    if ($accDetail != null && count($accDetail) > 0) {
                                        $accDetail = $accDetail[0];
                                        $enfants = $controlerAccouchment->getEnfantByAccouchement(["accouchement" => $accDetail->id_accouchement]);
                                        ?>
                                        <div class="col-lg-12 col-md-12">
                                            <div class="col-lg-12">
                                                <div class="panel panel-primary panel-group">
                                                    <div class="panel-heading panel-primary">
                                                        <h4>REF ACTE : <span class="text" style="font-weight: bolder">SMGR-<?= $seeActe->idactepose ?></span></h4>
                                                        <p><i class="glyphicon glyphicon-time"></i>&nbsp; Créé <?= $seeActe->date ?> par : <?= $seeActe->nomagent . " " . $seeActe->prenomagent . "(" . $seeActe->fonctionagent . ")" ?> </p>

                                                        <p><i class="glyphicon glyphicon-baby-formula"></i>&nbsp; <?= $seeActe->acte ?></p>
                                                    </div>
                                                    <div class="panel-body">
                                                        <div class="col"><h6>Pour :</h6><hr></div>   
                                                        <div class="row">
                                                            <div class="col-lg-3">
                                                                <div class="wrapImgProfile">
                                                                    <img src="/img/personnel/<?= $seeActe->filename . "." . $seeActe->type ?>">


                                                                </div>
                                                                <div class="">
                                                                    <br>
                                                                    <?php
                                                                    unset($condition);
                                                                    $condition['where'] = " WHERE acte_pose.id ='" . $_GET['id'] . "'";
                                                                    $hospi = $controller->gethospitalisation($condition)['results'];
                                                                    ?>
                                                                    <div class="row">
                                                                        <div class="col-lg-12">
                                                                            <a href="/controls/control.php?mod=patient&act=view&id=<?= $seeActe->idPatient ?>" class="btn btn-success btn-grad col-lg-6 "><span class="glyphicon glyphicon-eye-open"></span> Voir Fiche </a>
                                                                            <a href="/public/print.php?print&id=<?= $seeActe->idactepose ?>" class="printbtn btn btn-metis-3 btn-grad col-lg-6"><span class="glyphicon glyphicon-print"></span> Jéton</a>                                                        
                                                                            <a href="/public/actes_medicaux.php?action=addExtrat&id=<?= $seeActe->idactepose ?>" class="btn btn-primary btn-metis-3 col-lg-12"><span class="glyphicon glyphicon-bullhorn"></span> Extra </a><br><br>

                                                                        </div>
                                                                        <div class="col-lg-12" style="margin-top: 7px">
                                                                            <a href="/public/actes_medicaux.php?action=consulter&id=<?= $seeActe->idactepose ?>" class="btn btn-metis-2 btn-grad col-lg-12"><span class="glyphicon glyphicon-cutlery"></span> Prélever </a><br><br>     
                                                                            <?php if ($_SESSION['user']['idFonction'] == 2 || $_SESSION['user']['idFonction'] == 1 || $_SESSION['user']['idFonction'] == 0) { ?>
                                                                                <a href="/public/actes_medicaux.php?action=diagnostiquer&id=<?= $seeActe->idactepose ?>" class="btn btn-primary btn-grad col-lg-12"><span class="glyphicon glyphicon-cutlery"></span> Diagnostiquer </a><br><br>
                                                                                <a href="/public/actes_medicaux.php?action=prescrire&m=init&id=<?= $seeActe->idactepose ?>" class="btn btn-metis-6 btn-grad col-lg-12" style="margin-top: 7px"><span class="glyphicon glyphicon-cutlery"></span> Prescrire </a>

                                                                                <?php
                                                                                if (count($hospi) > 0) {
                                                                                    ?>
                                                                                    <!-- <?= count($hospi) > 0 || (!Date::isValid(date('d-m-Y'), $hospi[0]->date_sortie)) && isset($hospi[0]) ? "<a hidden href=\"/controls/control.php?mod=acte&act=deshospitaliser&id=" . $seeActe->idactepose . '" class="btn btn-metis-2 btn-grad col-lg-12" style="margin-top: 7px"><span class="glyphicon glyphicon-cutlery"></span> Libérer </a>' : ' <a href="/public/actes_medicaux.php?action=hospitaliser&id=' . $seeActe->idactepose . '"' . 'class="btn btn-metis-2 btn-grad col-lg-12" style="margin-top: 7px"><span class="glyphicon glyphicon-cutlery"></span> Hospitaliser </a>' ?>-->
                                                                                <?php } else {
                                                                                    ?>
                                                                                    <a href="/public/actes_medicaux.php?action=hospitaliser&id=<?= $seeActe->idactepose ?>" class="btn btn-metis-2 btn-grad col-lg-12" style="margin-top: 7px"><span class="glyphicon glyphicon-cutlery"></span> Hospitaliser </a>
                                                                                    <?php
                                                                                }
                                                                            }
                                                                            ?>
                                                                            <a href="/public/actes_medicaux.php?action=nursing&id=<?= $seeActe->idactepose ?>" class="btn btn-metis-1 btn-grad col-lg-12" style="margin-top: 7px"><span class="glyphicon glyphicon-cutlery"></span> Nursing </a>
                                                                        </div>
                                                                    </div>
                                                                    <br>              
                                                                </div>
                                                                <br>
                                                            </div>
                                                            <div class="col-lg-9 personne-info">
                                                                <div class="line-personne-info"><span class="champ">Num fiche interne :</span><span class="val-line-personne-info"><?= $seeActe->numinterne ?></span></div> 
                                                                <div class="line-personne-info"><span class="champ">Num unique :</span><span class="val-line-personne-info"><?= isset($seeActe->nu) && !empty($seeActe->nu) ? isset($seeActe->nu) : "" ?></span></div> 
                                                                <div class="line-personne-info"><span class="champ">Nom :</span><span class="val-line-personne-info"><?= $seeActe->nompatient ?></span></div> 
                                                                <div class="line-personne-info"><span class="champ">Prénom :</span><span class="val-line-personne-info"><?= $seeActe->prenompatient ?></span></div> 
                                                                <div class="line-personne-info"><span class="champ">Post-nom :</span><span class="val-line-personne-info"><?= $seeActe->postnompatient ?></span></div> 

                                                                <div class="line-personne-info"><span class="champ">Date de naissance :</span><span class="val-line-personne-info"><?= $seeActe->agepatient ?></span></div> 
                                                                <div class="line-personne-info"><span class="champ">Etat civil :</span><span class="val-line-personne-info"><?= $seeActe->etatcivil ?></span></div> 
                                                                <div class="line-personne-info"><span class="champ">Nombre d'enfants :</span><span class="val-line-personne-info"><?= ($enfants != null && is_array($enfants)) ? count($enfants) : 0 ?></span></div> 
                                                                <?php
                                                                if (count($hospi) > 0) {

                                                                    $datesortie = $hospi[0]->date_sortie;
                                                                    ?>
                                                                    <div class="line-personne-info"><span class="champ">hospitalisé (e) :</span><span class="val-line-personne-info"> <?= (count($hospi) > 0) ? "Depuis " . Date::dateToFr($hospi[0]->date_entree) : "Pas" ?></span></div>
                                                                    <?php
                                                                    if (!is_null($datesortie) && Date::isValid(date('d-m-Y'), $datesortie)) {
                                                                        ?>
                                                                        <div class="line-personne-info"><span class="champ"> <?= $hospi[0]->statuthosp == 1 ? "Sortie (e)" : $hospi[0]->statuthosp == 2 ? "Transféré le " : "" ?> :</span><span class="val-line-personne-info"> <?= (count($hospi) > 0) ? Date::dateToFr($datesortie) : "" ?> <?= $hospi[0]->statuthosp == 2 ? ' à (' . $hospi[0]->destination . ")" : "" ?></span></div>                                                    

                                                                        <?php
                                                                    }
                                                                    ?>
                                                                    <div class="line-personne-info"><span class="champ">&nbsp;</span><span class="val-line-personne-info">
                                                                            <div class="input-group">
                                                                                <?php
                                                                                if ($hospi[0]->statuthosp == 0) {
                                                                                    ?>
                                                                                    <a href="/public/actes_medicaux.php?action=dehospitaliser&id=<?= $seeActe->idactepose ?>" class="btn btn-default  " style="margin-top: 7px"><span class="glyphicon glyphicon-off"></span> Libérer </a>

                                                                                    <a href="/public/actes_medicaux.php?action=transferer&id=<?= $seeActe->idactepose ?>" class="btn btn-default  " style="margin-top: 7px"><span class="glyphicon glyphicon-sort"></span> Transféré </a>

                                                                                <?php } ?>
                                                                            </div>

                                                                        </span>
                                                                    </div>
                                                                <?php }
                                                                ?>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12">
                                                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                                                <div class="panel panel-default">
                                                                    <div class="panel-heading" role="tab" id="headingOne">
                                                                        <h4 class="panel-title">
                                                                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseFour" class="collapsed">
                                                                                SIGNES VITAUX
                                                                                <span class="icone-drop"> </span>
                                                                            </a>
                                                                        </h4>
                                                                    </div>
                                                                    <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne" aria-expanded="false" style="height: 0px;">
                                                                        <?php
                                                                        $condition['where'] = " WHERE consultation.id_acte= $seeActe->idactepose ";
                                                                        $condition['order'] = " consultation.date DESC ";
                                                                        $consultationInfo = $controller->consultationInfo($condition);
                                                                        if (count($consultationInfo) > 0) {
                                                                            $allConsultation = $consultationInfo;
                                                                            $consultationInfo = $consultationInfo[0];
                                                                            ?>
                                                                            <div class="panel-body">
                                                                                <div class="grid-data">
                                                                                    <div class="item-grid-data">
                                                                                        <span class="item-grid-data-icone">Taille</span>
                                                                                        <span class="item-grid-data-val"><?= $consultationInfo->taille ?></span>
                                                                                        <span>cm</span>
                                                                                    </div>
                                                                                    <div class="item-grid-data">
                                                                                        <span class="item-grid-data-icone">Poids</span>
                                                                                        <span class="item-grid-data-val"><?= $consultationInfo->poids ?></span>
                                                                                        <span>Kg</span>
                                                                                    </div>
                                                                                    <div class="item-grid-data">
                                                                                        <span class="item-grid-data-icone">Température</span>
                                                                                        <span class="item-grid-data-val"><?= $consultationInfo->temp ?></span>
                                                                                        <span>C°</span>
                                                                                    </div>
                                                                                    <div class="item-grid-data">
                                                                                        <span class="item-grid-data-icone">Tension</span>
                                                                                        <span class="item-grid-data-val"><?= $consultationInfo->tension ?></span>
                                                                                    </div>
                                                                                    <div class="item-grid-data">
                                                                                        <span class="item-grid-data-icone">Pouls</span>
                                                                                        <span class="item-grid-data-val"><?= $consultationInfo->pouls ?></span>
                                                                                    </div>
                                                                                    <div class="item-grid-data">
                                                                                        <span class="item-grid-data-icone">F.R</span>
                                                                                        <span class="item-grid-data-val"><?= $consultationInfo->fr ?></span>
                                                                                    </div>
                                                                                    <div class="item-grid-data">
                                                                                        <span class="item-grid-data-icone">SPO2</span>
                                                                                        <span class="item-grid-data-val"><?= $consultationInfo->spo ?></span>
                                                                                    </div>
                                                                                    <!--
                                                                                    <div class="item-grid-data">
                                                                                        <span class="item-grid-data-icone">Taille</span>
                                                                                        <span class="item-grid-data-val">230</span>
                                                                                    </div>
                                                                                    -->
                                                                                    <div class="anamnese">
                                                                                        <h3>Observation</h3>                                                                        
                                                                                        <div>
                                                                                            <hr>
                                                                                            <?= $consultationInfo->anamnese ?>
                                                                                            <hr>
                                                                                        </div>                                                                        
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-lg-12">
                                                                                        <h5 class="text-center">Toutes les consultations</h5>
                                                                                        <table class="table">
                                                                                            <thead class="bg-warning">
                                                                                            <th>#</th>
                                                                                            <th>Tension</th>
                                                                                            <th>Température</th>
                                                                                            <th>Poids</th>
                                                                                            <th>Taille</th>
                                                                                            <th>Date</th>
                                                                                            </thead>
                                                                                            <tbody>
                                                                                                <?php
                                                                                                $count = 0;
                                                                                                foreach ($allConsultation as $item) {
                                                                                                    $count++;
                                                                                                    ?>
                                                                                                    <tr>
                                                                                                        <td><?= $count ?></td>
                                                                                                        <td><?= $item->tension ?></td>
                                                                                                        <td><?= $item->temp ?></td>
                                                                                                        <td><?= $item->poids ?></td>
                                                                                                        <td><?= $item->taille ?></td>
                                                                                                        <td><?= Date::dateToFr($item->date) ?></td>
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
                                                                        }//Fin test consultation trouvée
                                                                        else {
                                                                            ?>
                                                                            <div class="row"><div class="col-md-12"><h5 class="grid-data text-center alert alert-info alert-secondary alert-dismissible">Aucune information sur la consultation...</h5></div></div>
                                                                            <?php
                                                                        }//Fin test consultation non trouvée
                                                                        ?>
                                                                    </div>
                                                                </div>

                                                                <div class="panel panel-default">
                                                                    <div class="panel-heading" role="tab" id="enfants">
                                                                        <h4 class="panel-title">
                                                                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseEnfant" aria-expanded="false" aria-controls="collapseFour" class="collapsed">
                                                                                ENFANTS
                                                                                <span class="icone-drop"> </span>
                                                                            </a>
                                                                        </h4>
                                                                    </div>
                                                                    <div id="collapseEnfant" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFive" aria-expanded="false" >
                                                                        <div class="panel-body">
                                                                            <?php
                                                                            if ($enfants != null && count($enfants) > 0) {
                                                                                
                                                                                $count = 0;
                                                                                ?>

                                                                                <?php
                                                                                //composants\Utilitaire::debug($enfants);
                                                                                foreach ($enfants as $item) {
                                                                                    $count++;
                                                                                    ?>
                                                                                    <div class='bady'>
                                                                                        <div class="row">
                                                                                            <div class="col-md-7">
                                                                                                <div class=" personne-info">
                                                                                                    <div class="line-personne-info"><span class="champ">Statut :</span><span class="val-line-personne-info v_statut"><?= ($item->statut == 0 ? "En vie " : "Décédé") ?></span></div> 
                                                                                                    <div class="line-personne-info"><span class="champ">Nom :</span><span class="val-line-personne-info " id="nom_v"><?= $item->nom ?></span></div> 
                                                                                                    <div class="line-personne-info"><span class="champ">Prénom :</span><span class="val-line-personne-info" id="prenom_v"><?= $item->prenom?></span></div> 
                                                                                                    <div class="line-personne-info"><span class="champ">Post-nom :</span><span class="val-line-personne-info" id="postnom_v"><?= $item->postnom?></span></div> 
                                                                                                    <div class="line-personne-info"><span class="champ">Date de naissance :</span><span class="val-line-personne-info" id="postnom_v"><?= $item->age?></span></div> 
                                                                                                    <div class="line-personne-info"><span class="champ">Groupe Sanguin :</span><span class="val-line-personne-info" id="groupe_sang_v"> <?= $item->group_sanguin?></span></div>                                                                                            
                                                                                                    <div class="line-personne-info"><span class="champ">Sexe :</span><span class="val-line-personne-info" id="sexe_v"><?= $item->sexe?> </span></div> 
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-md-5">
                                                                                                <div class="wrapImgProfile">
                                                                                                    <img src="/img/personnel/avatar.jpg" id="img_v">
                                                                                                </div>
                                                                                            </div>

                                                                                        </div>
                                                                                        <hr>
                                                                                        <div class="row">
                                                                                            <div class="col-md-12">
                                                                                                <div class="form-group">
                                                                                                    <label for="text1" class="control-label col-lg-12">Corpulences </label>
                                                                                                </div>
                                                                                                <hr>
                                                                                                <div class="grid-data">
                                                                                                    <div class="item-grid-data" style="">
                                                                                                        <span class="item-grid-data-icone">Taille</span>
                                                                                                        <span class="item-grid-data-val" id="taille_v"><?= $item->taille?></span>
                                                                                                        <span>cm</span>
                                                                                                    </div>
                                                                                                    <div class="item-grid-data"style="" >
                                                                                                        <span class="item-grid-data-icone">Poids</span>
                                                                                                        <span class="item-grid-data-val" id="poids_v"><?= $item->poids ?></span>
                                                                                                        <span>Kg</span>
                                                                                                    </div>
                                                                                                    <div class="item-grid-data" style="">
                                                                                                        <span class="item-grid-data-icone">PC</span>
                                                                                                        <span class="item-grid-data-val" id="pc"><?= $item->pc?></span>
                                                                                                        <span>C°</span>
                                                                                                    </div>
                                                                                                    <div class="item-grid-data" style="">
                                                                                                        <span class="item-grid-data-icone">APGAR</span>
                                                                                                        <span class="item-grid-data-val" id="apgar_v"><?= $item->apgar?></span>
                                                                                                        <span>&nbsp;</span>
                                                                                                    </div>


                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-md-12">
                                                                                                <div class="form-group">
                                                                                                    <label for="text1" class="control-label col-lg-12">Accouchement </label>
                                                                                                </div>
                                                                                                <div class="col-md-12">
                                                                                                    <div class=" personne-info">
                                                                                                        <div class="line-personne-info"><span class="champ">Mode :</span><span class="val-line-personne-info" id="mode_v"> <?= $item->mode == 0 ? "En vie" : "Décédé"?></span></div> 
                                                                                                        <div class="line-personne-info"><span class="champ">Heure  :</span><span class="val-line-personne-info" id="heure_v"><?= $item->heure?></span></div> 
                                                                                                        <div class="line-personne-info"><span class="champ">Durée :</span><span class="val-line-personne-info" id="duree_v"><?= $item->duree?></span></div> 
                                                                                                        <div class="line-personne-info"><span class="champ">Avortement Spontané :</span><span class="val-line-personne-info" id="avortSpon_v"></span></div> 

                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-md-12">
                                                                                                <div class="form-group">
                                                                                                    <label for="text1" class="control-label col-lg-12">Renseignements maternels </label>
                                                                                                </div>
                                                                                                <div class="col-md-12">
                                                                                                    <div class=" personne-info">
                                                                                                        <div class="line-personne-info"><span class="champ">Gestité/Parité :</span><span class="val-line-personne-info" id="gestite_v"><?= $item->gestite . " | " . $item->parite?></span></div> 
                                                                                                        <div class="line-personne-info"><span class="champ">Avortement spont.  :</span><span class="val-line-personne-info" id="avortement_spont_v"></span></div> 
                                                                                                        <div class="line-personne-info"><span class="champ">IVG :</span><span class="val-line-personne-info" id="ivg_v"></span></div> 
                                                                                                        <div class="line-personne-info"><span class="champ">GS :</span><span class="val-line-personne-info" id="gs_v"></span></div> 
                                                                                                        <div class="line-personne-info"><span class="champ">Diabete/Glycemie :</span><span class="val-line-personne-info" id="diabete_v"><?= $item->diabete . " | ". $item->glycemie ?></span></div> 
                                                                                                        <div class="line-personne-info"><span class="champ">HTA/Dernière Ta :</span><span class="val-line-personne-info" id="hta_v"><?= $item->hta ?></span></div> 
                                                                                                        <div class="line-personne-info"><span class="champ">Test HIV :</span><span class="val-line-personne-info" id="hiv_v"><?= $item->hiv ?></span></div>
                                                                                                        <div class="line-personne-info"><span class="champ">TPC :</span><span class="val-line-personne-info" id="tbc_v"><?= $item->tbc ?></span></div> 
                                                                                                        <div class="line-personne-info"><span class="champ">DDR :</span><span class="val-line-personne-info" id="ddr_v"><?= $item->ddr?></span></div>
                                                                                                        <div class="line-personne-info"><span class="champ">TP :</span><span class="val-line-personne-info" id="tp_v"><?= $item->tp ?></span></div> 
                                                                                                        <div class="line-personne-info"><span class="champ">CPN :</span><span class="val-line-personne-info" id="cpn_v"><?= $item->cpn ?> </span></div>
                                                                                                        <div class="line-personne-info"><span class="champ">Echo :</span><span class="val-line-personne-info" id="echo_v"><?= $item->echo ?></span></div> 
                                                                                                        <div class="line-personne-info"><span class="champ">RPM :</span><span class="val-line-personne-info" id="rpm_v"><?= $item->rpm ?></span></div> 
                                                                                                        <div class="line-personne-info"><span class="champ">LA :</span><span class="val-line-personne-info" id="la_v"><?= $item->la ?></span></div> 

                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>


                                                                                            <div class="col-md-12">
                                                                                                <div class="form-group">
                                                                                                    <label for="text1" class="control-label col-lg-12"> Examen Morphologique </label>
                                                                                                </div>
                                                                                                <div class="col-md-12">
                                                                                                    <div class=" personne-info">
                                                                                                        <div class="line-personne-info"><span class="champ">Teint/T :</span><span class="val-line-personne-info" id="teint_v"><?= $item->teint . " | " . $item->t_num?>></span></div> 
                                                                                                        <div class="line-personne-info"><span class="champ">Conjonctives  :</span><span class="val-line-personne-info" id="conjonctives_v"><?= $item->conjonctives?></span></div> 
                                                                                                        <div class="line-personne-info"><span class="champ">Thorax (Coeur (FC) & Poumons(FR)) :</span><span class="val-line-personne-info" id="thorax_v"><?= $item->fc . " | " . $item->fr?></span></div> 
                                                                                                        <div class="line-personne-info"><span class="champ">Abdomen :</span><span class="val-line-personne-info" id="abdomen_v"><?= $item->abdomen?></span></div>                                                                                                 
                                                                                                        <div class="line-personne-info"><span class="champ">Organes Génitaux externes :</span><span class="val-line-personne-info" id="ogf_v"><?= $item->ogf ?></span></div> 
                                                                                                        <div class="line-personne-info"><span class="champ">Autres :</span><span class="val-line-personne-info" id="autres_v"><?= $item->autres ?></span></div>                                                                                                

                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>

                                                                                            <div class="col-md-12">
                                                                                                <div class="form-group">
                                                                                                    <label for="text1" class="control-label col-lg-12"> Examen Neurologique </label>
                                                                                                </div>
                                                                                                <div class="col-md-12">
                                                                                                    <div class=" personne-info">
                                                                                                        <div class="line-personne-info"><span class="champ">Vigilance :</span><span class="val-line-personne-info" id="vigilance_v"><?= $item->vigilance ?>}</span></div> 
                                                                                                        <div class="line-personne-info"><span class="champ">Motilité spontanée et réactive  :</span><span class="val-line-personne-info" id="motilite_v"><?= $item->motilite?></span></div> 
                                                                                                        <div class="line-personne-info"><span class="champ">Eric :</span><span class="val-line-personne-info" id="eri_v"><?= $item->eri?></span></div> 
                                                                                                        <div class="line-personne-info"><span class="champ">Tonus passif :</span><span class="val-line-personne-info" id="tonus_passif_v"><?= $item->tonus_passif?></span></div> 
                                                                                                        <div class="line-personne-info"><span class="champ">Tonus actif :</span><span class="val-line-personne-info" id="tonus_actif_v"><?= $item->tonus_actif?></span></div> 
                                                                                                        <div class="line-personne-info"><span class="champ">Succion déglutition :</span><span class="val-line-personne-info" id="succion_v"><?= $item->succion?></span></div> 
                                                                                                        <div class="line-personne-info"><span class="champ">Grasping :</span><span class="val-line-personne-info" id="grasping_v"><?= $item->grasping?></span></div>
                                                                                                        <div class="line-personne-info"><span class="champ">Moro :</span><span class="val-line-personne-info" id="moro_v"><?= $item->moro?></span></div>
                                                                                                        <div class="line-personne-info"><span class="champ">Extension croisée :</span><span class="val-line-personne-info" id="extension_croisee_v"><?= $item->extension_croisee?></span></div>
                                                                                                        <div class="line-personne-info"><span class="champ">Galand incurvation :</span><span class="val-line-personne-info" id="galand_incurvation_v"><?= $item->galand_incurvation?></span></div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>


                                                                                        </div>
                                                                                    </div>
                                                                                    <?php
                                                                                }
                                                                                ?>


                                                                            <?php } else {
                                                                                ?>
                                                                                <div class="row"><div class="col-md-12"><h5 class="text-center alert alert-info alert-secondary alert-dismissible">Aucune information n'est trouvé</h5> </div></div>
                                                                            <?php }
                                                                            ?>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="panel panel-default">
                                                                    <div class="panel-heading" role="tab" id="headingOne">
                                                                        <h4 class="panel-title">
                                                                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseDiagnostic" aria-expanded="false" aria-controls="collapseFour" class="collapsed">
                                                                                DIAGNOSTIC
                                                                                <span class="icone-drop"> </span>
                                                                            </a>
                                                                        </h4>
                                                                    </div>
                                                                    <div id="collapseDiagnostic" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne" aria-expanded="false" style="height: 0px;">
                                                                        <div class="panel-body">
                                                                            <div class="grid-data">     
                                                                                <?php
                                                                                $conditions['where'] = " WHERE diagnostic.id_acte = " . $_GET['id'] . "";
                                                                                $conditions['order'] = " diagnostic.date DESC";
                                                                                $diagnosticbyActe = $controller->getcustomediagnostic($conditions);
                                                                                if (count($diagnosticbyActe) > 0) {
                                                                                    $diagnosticbyActe = $diagnosticbyActe[0];
                                                                                    $idDiagnostic = $diagnosticbyActe->id_diagnostic;
                                                                                    ?>
                                                                                    <div class="anamnese">
                                                                                        <h3>OBSERVATION/DISCUSSION</h3>
                                                                                        <div>
                                                                                            <hr>
                                                                                            <?= $diagnosticbyActe->obs_diagnostic ?>
                                                                                            <hr>
                                                                                        </div>
                                                                                        <div class="col-lg-12">
                                                                                            <h4>Liste examens recommandés</h4>
                                                                                            <hr>
                                                                                            <?php
                                                                                            $condition = " WHERE acte_pose.id ='$_GET[id]' && diagnostic.id = '$idDiagnostic'";
                                                                                            $listExamenRecommandes = $controller->getcustomexamenitem($condition);
                                                                                            if (count($listExamenRecommandes) > 0) {

                                                                                                $count = 0;
                                                                                                ?>
                                                                                                <table class="table">
                                                                                                    <thead>
                                                                                                        <tr>
                                                                                                            <th>#</th>
                                                                                                            <th>
                                                                                                                <span class="glyphicon glyphicon-time">
                                                                                                                </span></th><th>Examen</th>
                                                                                                            <th>Résultat</th>
                                                                                                            <th>Statut</th>
                                                                                                        </tr>
                                                                                                    </thead>


                                                                                                    <tbody>
                                                                                                        <?php
                                                                                                        foreach ($listExamenRecommandes as $examen) {
                                                                                                            $count++;
                                                                                                            ?>    
                                                                                                            <tr>
                                                                                                                <td><?= $count ?></td>
                                                                                                                <td>Principale</td>
                                                                                                                <td><?= $examen->libexamen ?></td>
                                                                                                                <td><?= !empty($examen->resultat) ? $examen->resultat : "Pas disponible" ?></td>
                                                                                                                <td><?= $examen->fait ?></td>
                                                                                                            </tr>
                                                                                                        <?php }
                                                                                                        ?>
                                                                                                    </tbody>
                                                                                                </table>
                                                                                                <div class="col-lg-12">
                                                                                                    <div><a href="/public/actes_medicaux.php?action=examen&m=doexamen&id=<?= $idDiagnostic ?>" class="btn btn-grad btn-metis-1 btn-lg"> <span class="glyphicon glyphicon-arrow-right"></span> Go Labo</a></div>
                                                                                                </div>
                                                                                            <?php } else {//Fin aucun examen trouvé pour c @ID
                                                                                                ?>
                                                                                                <h5 class="text-center alert alert-error alert-info alert-dismissable">Aucun examen recommandé pour cet acte</h5>
                                                                                                <?php
                                                                                            }
                                                                                            ?>
                                                                                        </div>
                                                                                    </div>
                                                                                <?php } else {
                                                                                    ?>
                                                                                    <div class="row"><div class="col-md-12"><h5 class="text-center alert alert-info alert-secondary alert-dismissible">Aucun diagnostic pour cet acte<br><br>
                                                                                                <a href="/public/actes_medicaux.php?action=diagnostiquer&id=<?= $_GET['id'] ?>" class="btn btn-grad btn-metis-4">Diagnostiquer maintenant </a>
                                                                                            </h5></div></div>
                                                                                    <?php
                                                                                }
                                                                                ?>                                                           
                                                                            </div>
                                                                        </div>                                                                                                                    
                                                                    </div>
                                                                </div>
                                                                <div class="panel panel-default">
                                                                    <div class="panel-heading" role="tab" id="headingTwo">
                                                                        <h4 class="panel-title">
                                                                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseOne" class="collapse">
                                                                                PRESCRIPTIONS
                                                                                <span class="icone-drop"> </span>
                                                                            </a>
                                                                        </h4>
                                                                    </div>
                                                                    <div id="collapseThree" class="panel-collapse collapse " role="tabpanel" aria-labelledby="headingTwo" aria-expanded="false" style="">
                                                                        <div class="panel-body">
                                                                            <?php
                                                                            unset($condition);
                                                                            $condition['where'] = " WHERE acte_pose.id ='" . $_GET['id'] . "'";
                                                                            $listPrescription = $controller->getPrescriptionCountEle($condition);
                                                                            $count = 0;

                                                                            if (count($listPrescription) > 0) {
                                                                                ?>
                                                                                <table class="table">
                                                                                    <thead>
                                                                                        <tr>
                                                                                            <th>#</th>                                                                            
                                                                                            </span></th><th>Ref</th>
                                                                                            <th>Observation</th>
                                                                                            <th>nb Elements prescrits</th>
                                                                                            <th><span class="glyphicon glyphicon-time" <="" th="">
                                                                                                    <th>&nbsp;</th>

                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                        <?php
                                                                                        foreach ($listPrescription as $prescription) {
                                                                                            $count++
                                                                                            ?>
                                                                                            <tr>
                                                                                                <td><?= $count ?></td>
                                                                                                <td><?= $prescription->idPrescription ?></td>
                                                                                                <td><?= $prescription->observation ?></td>
                                                                                                <td><?= $prescription->nElement ?></td>
                                                                                                <td><?= $prescription->datePrescrit ?></td>
                                                                                                <td><a href="/public/actes_medicaux.php?action=prescrire&m=viewdetail&id=<?= $prescription->idPrescription ?>"><span class="glyphicon glyphicon-eye-open"></span></a></td>
                                                                                            </tr>

                                                                                            <?php
                                                                                        }
                                                                                        ?>

                                                                                    </tbody>
                                                                                </table>
                                                                            <?php } else {
                                                                                ?>     
                                                                                <div class="row"><div class="col-md-12"><h5 class="text-center alert alert-info alert-secondary alert-dismissible">Aucune prescription n'est faite</h5> </div></div>
                                                                                <?php
                                                                            }
                                                                            ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="panel panel-default">
                                                                    <div class="panel-heading" role="tab" id="headingTwo">
                                                                        <h4 class="panel-title">
                                                                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#soins" aria-expanded="false" aria-controls="" class="collapse">
                                                                                SOINS & TRAITEMENT APPLIQUES
                                                                                <span class="icone-drop"> </span>
                                                                            </a>
                                                                        </h4>
                                                                    </div>
                                                                    <div id="soins" class="panel-collapse  collapse" role="tabpanel" aria-labelledby="" aria-expanded="false" style="">
                                                                        <div class="panel-body">
                                                                            <?php
                                                                            $nursings = $controller->getnursing(['id' => $_GET['id']]);
                                                                            if (count($nursings) > 0) {
                                                                                $count = 0;
                                                                                ?>
                                                                                <table class="table">
                                                                                    <thead>
                                                                                    <th>#</th>
                                                                                    <th>Réf</th>
                                                                                    <th>Acte</th>
                                                                                    <th>Observation</th>
                                                                                    <th>Agent/Infirmier</th>
                                                                                    <th>Date</th>
                                                                                    <th>&nbsp;</th>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                        <?php
                                                                                        foreach ($nursings as $item) {
                                                                                            $count++;
                                                                                            ?>
                                                                                            <tr>
                                                                                                <td><?= $count ?></td>
                                                                                                <td><?= $item->idtraitement ?></td>
                                                                                                <td><?= $item->nursingpose ?></td>
                                                                                                <td><?= $item->obsnursing ?></td>
                                                                                                <td><?= $item->nom . " " . $item->prenom ?></td>
                                                                                                <td><?= $item->datenursing ?></td>
                                                                                            </tr>
                                                                                            <?php
                                                                                        }
                                                                                        ?>

                                                                                    </tbody>
                                                                                </table>
                                                                            <?php } else {
                                                                                ?>
                                                                                <div class="row"><div class="col-md-12"><h5 class="text-center alert alert-info alert-secondary alert-dismissible">Aucun traitement infirmier appliqué sur ce patient enregistré</h5> </div></div>
                                                                            <?php }
                                                                            ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!--View Extra-->
                                                                <div class="panel panel-default">
                                                                    <div class="panel-heading" role="tab" id="headingFive">
                                                                        <h4 class="panel-title">
                                                                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseExtra" aria-expanded="false" aria-controls="collapseFour" class="collapsed">
                                                                                EXTRA
                                                                                <span class="icone-drop"> </span>
                                                                            </a>
                                                                        </h4>
                                                                    </div>
                                                                    <div id="collapseExtra" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFive" aria-expanded="false" >
                                                                        <div class="panel-body">
                                                                            <?php
                                                                            $extrats = $controller->getRecommandListExtra(['id' => $_GET['id']]);
                                                                            if ($extrats != null && count($extrats) > 0) {
                                                                                $count = 0;
                                                                                ?>
                                                                                <table class="table">
                                                                                    <thead>
                                                                                    <th>#</th>
                                                                                    <th>Réf</th>
                                                                                    <th>Libelle</th>
                                                                                    <th>Observation</th>
                                                                                    <th>Agent/Infirmier</th>                                                                       
                                                                                    <th>Date</th>

                                                                                    <th>&nbsp;</th>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                        <?php
                                                                                        //composants\Utilitaire::debug($extrats);
                                                                                        foreach ($extrats as $item) {
                                                                                            $count++;
                                                                                            ?>
                                                                                            <tr>

                                                                                                <td><?= $count ?></td>
                                                                                                <td><?= $item->idext ?></td>
                                                                                                <td><?= $item->extrat ?></td>
                                                                                                <td><?= substr($item->details, 0, 50) ?></td>
                                                                                                <td><?= $item->nom . " " . $item->prenom ?></td>
                                                                                                <td><?= $item->dateextrat ?></td>
                                                                                                <td> <a class="btn btn-info" href="/public/actes_medicaux.php?action=viewextrat&id=<?= $item->id ?>"> <i ></i> voir</a></td>
                                                                                            </tr>   
                                                                                            <?php
                                                                                        }
                                                                                        ?>

                                                                                    </tbody>
                                                                                </table>
                                                                            <?php } else {
                                                                                ?>
                                                                                <div class="row"><div class="col-md-12"><h5 class="text-center alert alert-info alert-secondary alert-dismissible">Aucune information n'est trouvé</h5> </div></div>
                                                                            <?php }
                                                                            ?>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <!--View Produit livrés-->
                                                                <div class="panel panel-default">
                                                                    <div class="panel-heading" role="tab" id="headingFive">
                                                                        <h4 class="panel-title">
                                                                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseProduit" aria-expanded="false" aria-controls="collapseFour" class="collapsed">
                                                                                PRODUITS LIVRES (Médicaments & autres)
                                                                                <span class="icone-drop"> </span>
                                                                            </a>
                                                                        </h4>
                                                                    </div>
                                                                    <div id="collapseProduit" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFive" aria-expanded="false" >
                                                                        <div class="panel-body">
                                                                            <?php
                                                                            $condition['where'] = " WHERE livraison_patient.fk_acte ='" . $_GET['id'] . "'";
                                                                            $listproductlivre = $controllerPharmacy->getlistlivraisonByActe($condition);
                                                                            //\composants\Utilitaire::debug($listproductlivre);
                                                                            if ($listproductlivre != null && count($listproductlivre) > 0) {
                                                                                $count = 0;
                                                                                ?>
                                                                                <div class="col-lg-12">

                                                                                    <table class="table table-primary table-condensed table-striped table-responsive ">
                                                                                        <thead class="bg-black">
                                                                                        <th>#</th>
                                                                                        <th>ref</th>
                                                                                        <th>Designation</th>
                                                                                        <th>Quantité</th>
                                                                                        <th>Prix vente</th>
                                                                                        <th>Date livraison</th>
                                                                                        <th>&nbsp;</th>
                                                                                        </thead>
                                                                                        <?php
                                                                                        if (count($listproductlivre) > 0) {
                                                                                            $count = 0;
                                                                                            $totalPrixachat = 0;
                                                                                            $totalprixvente = 0;
                                                                                            $quantite = 0;
                                                                                            ?>
                                                                                            <tbody>
                                                                                                <?php
                                                                                                foreach ($listproductlivre as $product) {
                                                                                                    $count++;
                                                                                                    $totalprixvente += $product->prixvente;
                                                                                                    $quantite += $product->qtelivre;
                                                                                                    ?>
                                                                                                    <tr>
                                                                                                        <td><?= $count ?></td>

                                                                                                        <td><?= $product->idproduitlivre ?></td>
                                                                                                        <td><?= $product->produitlivre ?></td>
                                                                                                        <td><?= $product->qtelivre ?></td>
                                                                                                        <td><?= number_format($product->prixvente, 2) ?></td>
                                                                                                        <td><?= $product->date_create ?></td>
                                                                                                        <td>
                                                                                                        </td></tr>
                                                                                                    <?php
                                                                                                }
                                                                                                ?>                                                            
                                                                                            </tbody>
                                                                                            <tfoot>
                                                                                                <tr class="bg-blue" style="font-weight: bolder">
                                                                                                    <td colspan="3" style="text-align: left">Total</td>
                                                                                                    <td ><?= $quantite ?></td>
                                                                                                    <td ><?= number_format($totalprixvente, 2) ?> USD</td>
                                                                                                    <td ><?= "" ?></td>                                                            
                                                                                                </tr>
                                                                                                <tr class="bg-blue" style="font-weight: bolder">
                                                                                                    <td colspan="3" style="text-align: left">Total en CDF</td>
                                                                                                    <td ><?= "" ?></td>
                                                                                                    <td ><?= number_format($totalprixvente * $listproductlivre[0]->tauxapplique, 2) ?> CDF</td>
                                                                                                    <td ><?= "" ?></td>                                                            
                                                                                                </tr>
                                                                                            </tfoot>
                                                                                        <?php }
                                                                                        ?>
                                                                                    </table>
                                                                                </div>
                                                                            <?php } else {
                                                                                ?>
                                                                                <div class="row"><div class="col-md-12"><h5 class="text-center alert alert-info alert-secondary alert-dismissible">Aucune information n'est trouvé</h5> </div></div>
                                                                            <?php }
                                                                            ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="panel-footer">
                                                        <a class="btn btn-info"  href="/public/printfacturemedicale.php?id=<?= $_GET['id'] ?>&fiche"><span class="glyphicon glyphicon-file"></span> Facturer avec fiche</a>
                                                        <a class="btn btn-success" href="/public/printfacturemedicale.php?id=<?= $_GET['id'] ?>"><span class="glyphicon glyphicon-print"></span> Facturer</a>
                                                    </div>
                                                </div>
                                            </div>


                                            <?php
                                        } else {//Accouchement non trouvé
                                        }
                                    } else {
                                        ?>
                                        <h5 class="text-center alert alert-error alert-info alert-dismissable">Aucune information de l'acte médical en référence <?php $_GET['id'] ?> n'a été initialisée <br><br> <a class="btn btn-grad btn-metis-5" href="/public/actes_medicaux.php">Cliquez pour rentrer à la liste des actes médicaux</a></h5>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <h5 class="text-center alert alert-error alert-warning alert-dismissable">Vous avez sélectionné aucun acte à visualiser <br><br> <a class="btn btn-grad btn-metis-5" href="/public/actes_medicaux.php">Cliquez pour rentrer à la liste des actes médicaux</a></h5>
                                    <?php
                                }

                                break; //fin view acte detail
                            case "viewextrat":
                                if (isset($_GET['id'])) {
                                    $ext = $controller->getExtraDetail(['id' => $_GET['id']]);
                                    if ($ext != null && count($ext) > 0) {
                                        $seeActe = $controller->get(['id' => $ex[0]->idactepose]);
                                        composants\Utilitaire::debug($seeActe, true);
                                        if (count($seeActe) > 0) {
                                            $seeActe = $seeActe[0];
                                            ?>
                                            <div class="col-lg-12 col-md-12">
                                                <div class="col-lg-12">
                                                    <div class="panel panel-primary panel-group">
                                                        <div class="panel-heading panel-primary">
                                                            <h4>REF ACTE : <span class="text" style="font-weight: bolder">SMGR-<?= $seeActe->idactepose ?></span></h4>
                                                            <p><i class="glyphicon glyphicon-time"></i>&nbsp; Créé <?= $seeActe->date ?> par : <?= $seeActe->nomagent . " " . $seeActe->prenomagent . "(" . $seeActe->fonctionagent . ")" ?> </p>
                                                            <p><i class="glyphicon glyphicon-baby-formula"></i>&nbsp; <?= $seeActe->category ?></p>
                                                            <p><i class="glyphicon glyphicon-baby-formula"></i>&nbsp; <?= $seeActe->acte ?></p>
                                                        </div>
                                                        <div class="panel-body">
                                                            <div class="col"><h6>Pour :</h6><hr></div>   
                                                            <div class="row">
                                                                <div class="col-lg-3">
                                                                    <div class="wrapImgProfile">
                                                                        <img src="/img/personnel/<?= $seeActe->filename . "." . $seeActe->type ?>">
                                                                    </div>
                                                                    <div class="">
                                                                        <br>
                                                                        <a href="/controls/control.php?mod=patient&act=view&id=<?= $seeActe->idPatient ?>" class="btn btn-success col-lg-12"><span class="glyphicon glyphicon-eye-open"></span> Voir Fiche </a>
                                                                        <br>              
                                                                    </div>
                                                                    <br>
                                                                </div>
                                                                <div class="col-lg-9 personne-info">
                                                                    <div class="line-personne-info"><span class="champ">Nom :</span><span class="val-line-personne-info"><?= $seeActe->nompatient ?></span></div> 
                                                                    <div class="line-personne-info"><span class="champ">Prénom :</span><span class="val-line-personne-info"><?= $seeActe->prenompatient ?></span></div> 
                                                                    <div class="line-personne-info"><span class="champ">Post-nom :</span><span class="val-line-personne-info"><?= $seeActe->postnompatient ?></span></div> 
                                                                    <div class="line-personne-info"><span class="champ">Date de naissance :</span><span class="val-line-personne-info"><?= $seeActe->agepatient ?></span></div> 
                                                                    <div class="line-personne-info"><span class="champ">Etat civil :</span><span class="val-line-personne-info"><?= $seeActe->etatcivil ?></span></div> 
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <div class="col-lg-12">
                                                                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                                                    <div class="col-lg-12">
                                                                        <form class="form-horizontal" role="form" id="formDiagnostic" method="post" action="/controls/control.php?mod=acte&act=addnursing">
                                                                            <div class="form-group">
                                                                                <label class="col-sm-2 control-label">Acte infirmier</label>
                                                                                <div class="col-sm-10">
                                                                                    <select class="form-control" name="actenursing">
                                                                                        <?php
                                                                                        $nurginglist = $controller->getActeNursing();
                                                                                        if (count($nurginglist) > 0) {
                                                                                            foreach ($nurginglist as $value) {
                                                                                                ?>
                                                                                                <option value="<?= $value->id_acte_infirmier ?>"><?= $value->lib ?></option>
                                                                                                <?php
                                                                                            }
                                                                                        }
                                                                                        ?>

                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label class="col-sm-2 control-label">Observations</label>
                                                                                <div class="col-sm-10">
                                                                                    <textarea class="form-control" placeholder="Ecrivez votre conversation, observation faite pendant le nursing" name="obs" rows="6"></textarea>
                                                                                </div>
                                                                            </div>
                                                                            <input type="hidden" class="form-control refCat" name="acte_pose" value="<?= $seeActe->idactepose ?>">

                                                                            <div class="form-group">
                                                                                <button type="submit" class="form-control btn btn-metis-6 btn-grad"><i class="glyphicon glyphicon-save-file"></i> Enregistrer</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>

                                                                </div>



                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="panel-footer">
                                                        <a class="btn btn-info" href="/public/patients.php?action=view&id<?= $seeActe->idPatient ?>"><span class="glyphicon glyphicon-file"></span>Voir toutes</a>
                                                    </div>
                                                </div>
                                            </div>

                                        <?php } else {
                                            ?>
                                            <div class="row"><div class="col-md-12"><h5 class="text-center alert alert-info alert-secondary alert-dismissible">Aucun acte n'a été trouvé</h5> </div></div>
                                            <?php
                                        }
                                    } else {
                                        
                                    }
                                } else {
                                    ?>
                                    <div class="row"><div class="col-md-12"><h5 class="text-center alert alert-info alert-secondary alert-dismissible">Vous n'avez sélectionné aucun acte</h5> </div></div>
                                    <?php
                                }
                                ?>

                                <?php
                                break; //Sortie view extrat            


                                break; //fin view acte detail
                            case "nursing":
                                if (isset($_GET['id'])) {
                                    $seeActe = $controller->getlistacte(['id' => $_GET['id']]);
                                    if (count($seeActe) > 0) {
                                        $seeActe = $seeActe[0];
                                        ?>
                                        <div class="col-lg-12 col-md-12">
                                            <div class="col-lg-12">
                                                <div class="panel panel-primary panel-group">
                                                    <div class="panel-heading panel-primary">
                                                        <h4>REF ACTE : <span class="text" style="font-weight: bolder">SMGR-<?= $seeActe->idactepose ?></span></h4>
                                                        <p><i class="glyphicon glyphicon-time"></i>&nbsp; Créé <?= $seeActe->date ?> par : <?= $seeActe->nomagent . " " . $seeActe->prenomagent . "(" . $seeActe->fonctionagent . ")" ?> </p>
                                                        <p><i class="glyphicon glyphicon-baby-formula"></i>&nbsp; <?= $seeActe->category ?></p>
                                                        <p><i class="glyphicon glyphicon-baby-formula"></i>&nbsp; <?= $seeActe->acte ?></p>
                                                    </div>
                                                    <div class="panel-body">
                                                        <div class="col"><h6>Pour :</h6><hr></div>   
                                                        <div class="row">
                                                            <div class="col-lg-3">
                                                                <div class="wrapImgProfile">
                                                                    <img src="/img/personnel/<?= $seeActe->filename . "." . $seeActe->type ?>">
                                                                </div>
                                                                <div class="">
                                                                    <br>
                                                                    <a href="/controls/control.php?mod=patient&act=view&id=<?= $seeActe->idPatient ?>" class="btn btn-success col-lg-12"><span class="glyphicon glyphicon-eye-open"></span> Voir Fiche </a>
                                                                    <br>              
                                                                </div>
                                                                <br>
                                                            </div>
                                                            <div class="col-lg-9 personne-info">
                                                                <div class="line-personne-info"><span class="champ">Nom :</span><span class="val-line-personne-info"><?= $seeActe->nompatient ?></span></div> 
                                                                <div class="line-personne-info"><span class="champ">Prénom :</span><span class="val-line-personne-info"><?= $seeActe->prenompatient ?></span></div> 
                                                                <div class="line-personne-info"><span class="champ">Post-nom :</span><span class="val-line-personne-info"><?= $seeActe->postnompatient ?></span></div> 
                                                                <div class="line-personne-info"><span class="champ">Date de naissance :</span><span class="val-line-personne-info"><?= $seeActe->agepatient ?></span></div> 
                                                                <div class="line-personne-info"><span class="champ">Etat civil :</span><span class="val-line-personne-info"><?= $seeActe->etatcivil ?></span></div> 
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div class="col-lg-12">
                                                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                                                <div class="col-lg-12">
                                                                    <form class="form-horizontal" role="form" id="formDiagnostic" method="post" action="/controls/control.php?mod=acte&act=addnursing">
                                                                        <div class="form-group">
                                                                            <label class="col-sm-2 control-label">Acte infirmier</label>
                                                                            <div class="col-sm-10">
                                                                                <select class="form-control" name="actenursing">
                                                                                    <?php
                                                                                    $nurginglist = $controller->getActeNursing();
                                                                                    if (count($nurginglist) > 0) {
                                                                                        foreach ($nurginglist as $value) {
                                                                                            ?>
                                                                                            <option value="<?= $value->id_acte_infirmier ?>"><?= $value->lib ?></option>
                                                                                            <?php
                                                                                        }
                                                                                    }
                                                                                    ?>

                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-sm-2 control-label">Observations</label>
                                                                            <div class="col-sm-10">
                                                                                <textarea class="form-control" placeholder="Ecrivez votre conversation, observation faite pendant le nursing" name="obs" rows="6"></textarea>
                                                                            </div>
                                                                        </div>
                                                                        <input type="hidden" class="form-control refCat" name="acte_pose" value="<?= $seeActe->idactepose ?>">

                                                                        <div class="form-group">
                                                                            <button type="submit" class="form-control btn btn-metis-6 btn-grad"><i class="glyphicon glyphicon-save-file"></i> Enregistrer</button>
                                                                        </div>
                                                                    </form>
                                                                </div>

                                                            </div>



                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="panel-footer">
                                                    <a class="btn btn-info" href="/public/patients.php?action=view&id<?= $seeActe->idPatient ?>"><span class="glyphicon glyphicon-file"></span>Voir toutes</a>
                                                </div>
                                            </div>
                                        </div>

                                    <?php } else {
                                        ?>
                                        <div class="row"><div class="col-md-12"><h5 class="text-center alert alert-info alert-secondary alert-dismissible">Aucun acte n'a été trouvé</h5> </div></div>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <div class="row"><div class="col-md-12"><h5 class="text-center alert alert-info alert-secondary alert-dismissible">Vous n'avez sélectionné aucun acte</h5> </div></div>
                                    <?php
                                }
                                ?>

                                <?php
                                break; //Sortie nursing




                            case 'listdiagnistic':
                                $listDiagnosticByDate = $controller->getdiagnosticbydate();
                                $listDiagnostic = $controller->getdiagnostic();
                                ?>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="box">
                                            <header>
                                                <h5>LES DIAGNOSTICS D'AUJOURD'HUI</h5>
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
                                                <div class="col-lg-12">
                                                </div>
                                                <div id="stripedTable" class="body collapse in">
                                                    <?php
                                                    if (isset(($listDiagnosticByDate)) && count($listDiagnosticByDate) > 0) {
                                                        $count = 0;
                                                        ?>                                                


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
                                                                foreach ($listDiagnosticByDate as $item) {
                                                                    $count++;
                                                                    ?>
                                                                    <tr class="">
                                                                        <td><?= $count ?> </td>
                                                                        <td><?= $item->id_diagnostic ?></td>
                                                                        <td>
                                                                            <a href="/controls/control.php?mod=patient&act=view&id=<?= $item->idPatient ?>"><img src="/img/personnel/<?= $item->filename . "." . $item->type ?>" class="user-profile">
                                                                                <h5><?= $item->nompatient . " " . $item->prenompatient ?></h5></a>
                                                                        </td>

                                                                        <td><?= $item->nomagent . " " . $item->prenomagent ?><br>(<?= $item->fonction ?>)</td>
                                                                        <td><?= $item->acte_pose ?></td>                                                    
                                                                        <td><?= $item->category ?></td>
                                                                        <td><?= Date::dateToFr($item->datediagnostic) ?></td>
                                                                        <td>
                                                                            <a href="/public/actes_medicaux.php?action=examen&m=addexamen&id=<?= $item->id_diagnostic ?>" class=""><img src="/public/img/icone/microscope-16.png" style="margin-top: -5px"/></a>                                                        
                                                                            <a href="" class="danger text-danger"><span class="glyphicon glyphicon-remove"></span></a></td>

                                                                    </tr>        
                                                                    <?php
                                                                }
                                                                ?>

                                                            </tbody>     

                                                        </table>
                                                    <?php } else {// Si aujourd'hui aucun diagnostic n'a été effectué today
                                                        ?>

                                                        <h2 class=" col-lg-12 text-center alert alert-info alert-secondary alert-dismissible">Aucun diagnostic n'est enregistré pour aujourd'hui</h2>

                                                        <?php
                                                    }
                                                    ?>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="box">
                                            <header>
                                                <h5>TOUS LES DIAGNOSTICS</h5>
                                                <div class="toolbar">
                                                    <ul class="nav">
                                                        <li>
                                                            <form action="/controls/control.php?mod=acte&amp;act=searchactes" method="get" class="form-inline searchform" autocomplete="off">
                                                                <div class=" form-group top_search">
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control input-search-diagnostic" name="q" placeholder="Recherche...">
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
                                                <div class="col-lg-12">
                                                </div>
                                                <div id="stripedTable" class="body collapse in">
                                                    <?php
                                                    if (count($listDiagnostic['results']) > 0) {
                                                        $count = 0;
                                                        ?>                                                

                                                        <div class="col-lg-12"><?php \composants\Utilitaire::pagination($listDiagnostic['nbPages'], 2, "/public/actes_medicaux.php?action=listdiagnistic"); ?><hr></div>                   
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
                                                                foreach ($listDiagnostic['results'] as $item) {
                                                                    $count++;
                                                                    ?>
                                                                    <tr class="">
                                                                        <td><?= $count ?> </td>
                                                                        <td><?= $item->id_diagnostic ?></td>
                                                                        <td>
                                                                            <a href="/controls/control.php?mod=patient&act=view&id=<?= $item->idPatient ?>"><img src="/img/personnel/<?= $item->filename . "." . $item->type ?>" class="user-profile">
                                                                                <h5><?= $item->nompatient . " " . $item->prenompatient ?></h5></a>
                                                                        </td>

                                                                        <td><?= $item->nomagent . " " . $item->prenomagent ?><br>(<?= $item->fonction ?>)</td>
                                                                        <td><?= $item->acte_pose ?></td>                                                    
                                                                        <td><?= $item->category ?></td>
                                                                        <td><?= Date::dateToFr($item->datediagnostic) ?></td>
                                                                        <td>
                                                                            <a href="/public/actes_medicaux.php?action=examen&m=addexamen&id=<?= $item->id_diagnostic ?>" class="danger text-danger"><span class="glyphicon glyphicon-list"></span></a>
                                                                            <a href="/public/actes_medicaux.php?action=view&amp;id=1"><span class="glyphicon glyphicon-eye-open"></span></a>
                                                                            <!--
                                                                            <a href="" class="danger text-danger"><span class="glyphicon glyphicon-remove"></span></a>-->
                                                                        </td>

                                                                    </tr>        
                                                                    <?php
                                                                }
                                                                ?>

                                                            </tbody>     

                                                        </table>
                                                    <?php } else {// Si aujourd'hui aucun diagnostic n'a été effectué today
                                                        ?>
                                                        <h2 class=" col-lg-12 text-center alert alert-info alert-secondary alert-dismissible">Aucun diagnostic n'est enregistré pour aujourd'hui</h2>
                                                        <?php
                                                    }
                                                    ?>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>          
                                <?php
                                break; //Fin $_GET['action'] = listdiagnistic
                            case "hospitaliser":
                                if (isset($_GET['id']) && !empty($_GET['id'])) { //@ $id de la acte medicaux  
                                    unset($condition);
                                    $seeActe = $controller->getlistacte($_GET);
                                    $listChambre = $controller->getchambre();
                                    $listLits = $controller->getlits();
                                    if (count($seeActe) > 0) {
                                        $seeActe = $seeActe[0];
                                        ?>

                                        <div class="col-lg-12 col-md-12">
                                            <div class="col-lg-12">
                                                <div class="panel panel-primary panel-group">
                                                    <div class="panel-heading panel-primary">
                                                        <h4>REF ACTE : <span class="text" style="font-weight: bolder">SMGR-<?= $seeActe->idactepose ?></span></h4>
                                                        <p><i class="glyphicon glyphicon-time"></i>&nbsp; Créé <?= $seeActe->date ?> par : <?= $seeActe->nomagent . " " . $seeActe->prenomagent . "(" . $seeActe->fonctionagent . ")" ?> </p>
                                                        <p><i class="glyphicon glyphicon-baby-formula"></i>&nbsp; <?= $seeActe->category ?></p>
                                                        <p><i class="glyphicon glyphicon-baby-formula"></i>&nbsp; <?= $seeActe->acte ?></p>
                                                        <p><a href="/public/actes_medicaux.php?action=view&id=<?= $seeActe->idactepose ?>" class="btn btn-metis-1 btn-grad"><i class="glyphicon glyphicon-backward"></i> Back to viewer Acte</a></p>
                                                    </div>                                        
                                                    <div class="panel-body">                                            
                                                        <div class="col"><h6>Pour :</h6><hr></div>   
                                                        <div class="col-lg-3">
                                                            <div class="wrapImgProfile">
                                                                <img src="/img/personnel/<?= $seeActe->filename . "." . $seeActe->type ?>">
                                                            </div>
                                                            <div class="">

                                                                <br>              
                                                            </div>
                                                            <br>
                                                        </div>
                                                        <div class="col-lg-9 personne-info">
                                                            <div class="line-personne-info"><span class="champ">Nom :</span><span class="val-line-personne-info"><?= $seeActe->nompatient ?></span></div> 
                                                            <div class="line-personne-info"><span class="champ">Prénom :</span><span class="val-line-personne-info"><?= $seeActe->prenompatient ?></span></div> 
                                                            <div class="line-personne-info"><span class="champ">Post-nom :</span><span class="val-line-personne-info"><?= $seeActe->postnompatient ?></span></div> 
                                                            <div class="line-personne-info"><span class="champ">Date de naissance :</span><span class="val-line-personne-info"><?= $seeActe->agepatient ?></span></div> 
                                                            <div class="line-personne-info"><span class="champ">Etat civil :</span><span class="val-line-personne-info"><?= $seeActe->etatcivil ?></span></div> 
                                                        </div>                                                                                        
                                                        <hr>
                                                        <div class="col-lg-12">
                                                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                                                <div class="col-lg-12">

                                                                    <hr>                                              
                                                                    <div class="row">
                                                                        <div class="col-lg-12">
                                                                            <?php
                                                                            if ($_SESSION['user']['idFonction'] == "1" || $_SESSION['user']['idFonction'] == "2" || $_SESSION['user']['idFonction'] == "0") {
                                                                                ?>
                                                                                <form action="/controls/control.php?mod=acte&act=hospitaliser" class="form-horizontal" method="POST" >
                                                                                    <fieldset>
                                                                                        <legend style="font-size: 0.8em">
                                                                                            <div class="alert alert-info" ><i class="glyphicon glyphicon-info-sign text-warning" style="font-size: 1.6em"></i>
                                                                                                <br>Ici vous avez la possibilité de mettre un patient à l'état d'hospitalisation<br>

                                                                                                <br></div></legend>                                                                        
                                                                                        <input type="hidden" name="id_actepose" value="<?= $_GET['id'] ?>"/>
                                                                                        <!--
                                                                                        <div class="form-group">
                                                                                            <label class="col-md-2 control-label" for="textarea">Chambres </label>
                                                                                            <div class="col-md-10">
                                                                                                <select class="form-control" name="id_chambre">
                                                                                        <?php
                                                                                        if (count($listChambre) > 0) {
                                                                                            foreach ($listChambre as $chambre) {
                                                                                                ?>
                                                                                                                                                                                                                                        <option value="<?= $chambre->id_chambre ?>"><?= $chambre->chambre . "(" . $chambre->category . ")" ?></option>                                                                                    
                                                                                                <?php
                                                                                            }
                                                                                        }
                                                                                        ?>
                                                                                                    
                                                                                                </select>                                                                                
                                                                                            </div>                                                                            
                                                                                        </div>-->
                                                                                        <div class="form-group">
                                                                                            <label class="col-md-2 control-label" for="textarea">Chambre/Lit </label>
                                                                                            <div class="col-md-10">
                                                                                                <select class="form-control" name="id_lit">
                                                                                                    <?php
                                                                                                    if (count($listLits) > 0) {
                                                                                                        foreach ($listLits as $lit) {
                                                                                                            ?>
                                                                                                            <option value="<?= $lit->idlit ?>"><?= $lit->lit . " " . $lit->chambre . "(" . $lit->category . ")" ?></option>                                         
                                                                                                            <?php
                                                                                                        }
                                                                                                    }
                                                                                                    ?>                                                                                    
                                                                                                </select>                                                                                
                                                                                            </div>                                                                            
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label class="col-md-2 control-label" for="textarea">Observation</label>
                                                                                            <div class="col-md-10">									
                                                                                                <button class="btn btn-success form-control" type="submit">
                                                                                                    <i class="glyphicon glyphicon-ok"></i>
                                                                                                    Confirmer hospitalisation
                                                                                                </button>                                                                                
                                                                                            </div>                                                                            
                                                                                        </div>
                                                                                    </fieldset>
                                                                                </form>
                                                                            <?php } else {
                                                                                ?>
                                                                                <div class="row"><div class="col-md-12"><h5 class="text-center alert alert-warning alert-secondary alert-dismissible">Vous n'aviez ce privilege, Veuillez contacter MDE Services/IT pour plus d'info</h5> </div></div>
                                                                                <?php
                                                                            }
                                                                            ?>
                                                                        </div>
                                                                    </div>
                                                                </div>                                                    
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                                <br><br>
                                            </div>
                                        </div>


                                    <?php } else {
                                        ?>
                                        <h5 class="text-center alert alert-error alert-info alert-dismissable">Aucune information n'a été trouvée  pour l'acte médical de référence <?php $_GET['id'] ?> ... <br><br> Pour prescrire, veuillez cliquez <a class="btn btn-grad btn-metis-5" href="<?= $_SERVER['HTTP_REFERER'] ?>">BACK</a></h5>                                              <?php
                                    }
                                    ?>
                                    <div class="row">                                    
                                    </div>

                                <?php } else {
                                    ?>
                                    <h5 class="text-center alert alert-warning alert-secondary alert-dismissible">Aucune référence acte medical n'a été renseignée. <br>Si cette erreur persiste, vérifier bien que vous avez passé par la méthode logique pour y arriver et Si non, veuillez contacter MDE Services (IT) pour signaler l'erreur afin de consolider la sécurité du système<br><br><a href="<?= $_SERVER['HTTP_REFERER'] ?>">back</a></h5>                                


                                    <?php
                                }

                                break; //Sortie case hospitaliser


                            case "dehospitaliser":
                                if (isset($_GET['id']) && !empty($_GET['id'])) { //@ $id de la acte medicaux  
                                    unset($condition);
                                    $seeActe = $controller->getlistacte($_GET);
                                    $listChambre = $controller->getchambre();
                                    $listLits = $controller->getlits();



                                    if (count($seeActe) > 0) {
                                        $seeActe = $seeActe[0];
                                        $condition['where'] = " WHERE acte_pose.id ='" . $seeActe->idactepose . "'";
                                        $hospi = $controller->gethospitalisation($condition)['results'];

                                        if ($hospi != null && count($hospi) > 0) {
                                            ?>

                                            <div class="col-lg-12 col-md-12">
                                                <div class="col-lg-12">
                                                    <div class="panel panel-primary panel-group">
                                                        <div class="panel-heading panel-primary">
                                                            <h4>REF ACTE : <span class="text" style="font-weight: bolder">SMGR-<?= $seeActe->idactepose ?></span></h4>
                                                            <p><i class="glyphicon glyphicon-time"></i>&nbsp; Créé <?= $seeActe->date ?> par : <?= $seeActe->nomagent . " " . $seeActe->prenomagent . "(" . $seeActe->fonctionagent . ")" ?> </p>
                                                            <p><i class="glyphicon glyphicon-baby-formula"></i>&nbsp; <?= $seeActe->category ?></p>
                                                            <p><i class="glyphicon glyphicon-baby-formula"></i>&nbsp; <?= $seeActe->acte ?></p>
                                                            <p><a href="/public/actes_medicaux.php?action=view&id=<?= $seeActe->idactepose ?>" class="btn btn-metis-1 btn-grad"><i class="glyphicon glyphicon-backward"></i> Back to viewer Acte</a></p>
                                                        </div>                                        
                                                        <div class="panel-body">                                            
                                                            <div class="col"><h6>Pour :</h6><hr></div>   
                                                            <div class="col-lg-3">
                                                                <div class="wrapImgProfile">
                                                                    <img src="/img/personnel/<?= $seeActe->filename . "." . $seeActe->type ?>">
                                                                </div>
                                                                <div class="">

                                                                    <br>              
                                                                </div>
                                                                <br>
                                                            </div>
                                                            <div class="col-lg-9 personne-info">
                                                                <div class="line-personne-info"><span class="champ">Nom :</span><span class="val-line-personne-info"><?= $seeActe->nompatient ?></span></div> 
                                                                <div class="line-personne-info"><span class="champ">Prénom :</span><span class="val-line-personne-info"><?= $seeActe->prenompatient ?></span></div> 
                                                                <div class="line-personne-info"><span class="champ">Post-nom :</span><span class="val-line-personne-info"><?= $seeActe->postnompatient ?></span></div> 
                                                                <div class="line-personne-info"><span class="champ">Date de naissance :</span><span class="val-line-personne-info"><?= $seeActe->agepatient ?></span></div> 
                                                                <div class="line-personne-info"><span class="champ">Etat civil :</span><span class="val-line-personne-info"><?= $seeActe->etatcivil ?></span></div> 
                                                            </div>                                                                                        
                                                            <hr>
                                                            <div class="col-lg-12">
                                                                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                                                    <div class="col-lg-12">

                                                                        <hr>                                              
                                                                        <div class="row">
                                                                            <div class="col-lg-12">
                                                                                <?php
                                                                                if ($_SESSION['user']['idFonction'] == "1" || $_SESSION['user']['idFonction'] == "2" || $_SESSION['user']['idFonction'] == "0") {
                                                                                    ?>          
                                                                                    <form action="/controls/control.php?mod=acte&act=deshospitaliser" enctype="multipart/form-data" class="form-horizontal" method="POST" >
                                                                                        <fieldset>
                                                                                            <legend style="font-size: 0.8em">
                                                                                                <div class="alert alert-info" ><i class="glyphicon glyphicon-info-sign text-warning" style="font-size: 1.6em"></i>
                                                                                                    <br>Ici vous avez la possibilité de libérer un patient <br>

                                                                                                    <br></div></legend>                                                                        
                                                                                            <input type="hidden" name="id_hospitalisation" value="<?= $hospi[0]->idhospitalisation ?>"/>
                                                                                            <input type="hidden" name="id" value="<?= $_GET["id"] ?>"/>
                                                                                            <div class="form-group">
                                                                                                <label class="col-md-3 control-label" for="textarea">Télécharger le fichier</label>
                                                                                                <div class="col-md-9">									
                                                                                                    <input class="form-control" type="file" name="file[]">                                                                             
                                                                                                </div>                                                                            
                                                                                            </div>
                                                                                            <div class="form-group">
                                                                                                <label class="col-md-3 control-label"  for="textarea">Observation</label>
                                                                                                <div class="col-md-9">									
                                                                                                    <textarea class="form-control" name="observation" rows="10"></textarea>                                                                              
                                                                                                </div>                                                                            
                                                                                            </div>

                                                                                            <div class="form-group">
                                                                                                <label class="col-md-3 control-label" for="textarea">&nbsp;</label>
                                                                                                <div class="col-md-9">									
                                                                                                    <button class="btn btn-success form-control" type="submit">
                                                                                                        <i class="glyphicon glyphicon-ok"></i>
                                                                                                        Confirmer déshospitalisation
                                                                                                    </button>                                                                                
                                                                                                </div>                                                                            
                                                                                            </div>
                                                                                        </fieldset>
                                                                                    </form>
                                                                                <?php } else {
                                                                                    ?>
                                                                                    <div class="row"><div class="col-md-12"><h5 class="text-center alert alert-warning alert-secondary alert-dismissible">Vous n'aviez ce privilege, Veuillez contacter MDE Services/IT pour plus d'info</h5> </div></div>
                                                                                    <?php
                                                                                }
                                                                                ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>                                                    
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <br><br>
                                                </div>
                                            </div>


                                            <?php
                                        } else {
                                            //Hospitalisation not found
                                        }
                                    } else {
                                        ?>
                                        <h5 class="text-center alert alert-error alert-info alert-dismissable">Aucune information n'a été trouvée  pour l'acte médical de référence <?php $_GET['id'] ?> ... <br><br> Pour prescrire, veuillez cliquez <a class="btn btn-grad btn-metis-5" href="<?= $_SERVER['HTTP_REFERER'] ?>">BACK</a></h5>                                              <?php
                                    }
                                    ?>
                                    <div class="row">                                    
                                    </div>

                                <?php } else {
                                    ?>
                                    <h5 class="text-center alert alert-warning alert-secondary alert-dismissible">Aucune référence acte medical n'a été renseignée. <br>Si cette erreur persiste, vérifier bien que vous avez passé par la méthode logique pour y arriver et Si non, veuillez contacter MDE Services (IT) pour signaler l'erreur afin de consolider la sécurité du système<br><br><a href="<?= $_SERVER['HTTP_REFERER'] ?>">back</a></h5>                                


                                    <?php
                                }

                                break; //Sortie case deshospitaliser

                            case "transferer":
                                if (isset($_GET['id']) && !empty($_GET['id'])) { //@ $id de la acte medicaux  
                                    unset($condition);
                                    $seeActe = $controller->getlistacte($_GET);
                                    $listChambre = $controller->getchambre();
                                    $listLits = $controller->getlits();



                                    if (count($seeActe) > 0) {
                                        $seeActe = $seeActe[0];
                                        $condition['where'] = " WHERE acte_pose.id ='" . $seeActe->idactepose . "'";
                                        $hospi = $controller->gethospitalisation($condition)['results'];

                                        if ($hospi != null && count($hospi) > 0) {
                                            ?>

                                            <div class="col-lg-12 col-md-12">
                                                <div class="col-lg-12">
                                                    <div class="panel panel-primary panel-group">
                                                        <div class="panel-heading panel-primary">
                                                            <h4>REF ACTE : <span class="text" style="font-weight: bolder">SMGR-<?= $seeActe->idactepose ?></span></h4>
                                                            <p><i class="glyphicon glyphicon-time"></i>&nbsp; Créé <?= $seeActe->date ?> par : <?= $seeActe->nomagent . " " . $seeActe->prenomagent . "(" . $seeActe->fonctionagent . ")" ?> </p>
                                                            <p><i class="glyphicon glyphicon-baby-formula"></i>&nbsp; <?= $seeActe->category ?></p>
                                                            <p><i class="glyphicon glyphicon-baby-formula"></i>&nbsp; <?= $seeActe->acte ?></p>
                                                            <p><a href="/public/actes_medicaux.php?action=view&id=<?= $seeActe->idactepose ?>" class="btn btn-metis-1 btn-grad"><i class="glyphicon glyphicon-backward"></i> Back to viewer Acte</a></p>
                                                        </div>                                        
                                                        <div class="panel-body">                                            
                                                            <div class="col"><h6>Pour :</h6><hr></div>   
                                                            <div class="col-lg-3">
                                                                <div class="wrapImgProfile">
                                                                    <img src="/img/personnel/<?= $seeActe->filename . "." . $seeActe->type ?>">
                                                                </div>
                                                                <div class="">

                                                                    <br>              
                                                                </div>
                                                                <br>
                                                            </div>
                                                            <div class="col-lg-9 personne-info">
                                                                <div class="line-personne-info"><span class="champ">Nom :</span><span class="val-line-personne-info"><?= $seeActe->nompatient ?></span></div> 
                                                                <div class="line-personne-info"><span class="champ">Prénom :</span><span class="val-line-personne-info"><?= $seeActe->prenompatient ?></span></div> 
                                                                <div class="line-personne-info"><span class="champ">Post-nom :</span><span class="val-line-personne-info"><?= $seeActe->postnompatient ?></span></div> 
                                                                <div class="line-personne-info"><span class="champ">Date de naissance :</span><span class="val-line-personne-info"><?= $seeActe->agepatient ?></span></div> 
                                                                <div class="line-personne-info"><span class="champ">Etat civil :</span><span class="val-line-personne-info"><?= $seeActe->etatcivil ?></span></div> 
                                                            </div>                                                                                        
                                                            <hr>
                                                            <div class="col-lg-12">
                                                                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                                                    <div class="col-lg-12">

                                                                        <hr>                                              
                                                                        <div class="row">
                                                                            <div class="col-lg-12">
                                                                                <?php
                                                                                if ($_SESSION['user']['idFonction'] == "1" || $_SESSION['user']['idFonction'] == "2" || $_SESSION['user']['idFonction'] == "0") {
                                                                                    ?>          
                                                                                    <form action="/controls/control.php?mod=acte&act=transferer" enctype="multipart/form-data" class="form-horizontal" method="POST" >
                                                                                        <fieldset>
                                                                                            <legend style="font-size: 0.8em">
                                                                                                <div class="alert alert-info" ><i class="glyphicon glyphicon-info-sign text-warning" style="font-size: 1.6em"></i>
                                                                                                    <br>Ici vous avez la possibilité de transférer un patient. Le champs de télécharger permet de télécharger le document du transfèrs <br>

                                                                                                    <br></div></legend>                                                                        
                                                                                            <input type="hidden" name="id_hospitalisation" value="<?= $hospi[0]->idhospitalisation ?>"/>
                                                                                            <input type="hidden" name="id" value="<?= $_GET["id"] ?>"/>
                                                                                            <div class="form-group">
                                                                                                <label class="col-md-3 control-label" for="textarea">destination</label>
                                                                                                <div class="col-md-9">									
                                                                                                    <input class="form-control" type="text" name="destination" placeholder="Veuillez saisir l'hôpital où transférer le patient">                                                                             
                                                                                                </div>                                                                            
                                                                                            </div>
                                                                                            <div class="form-group">
                                                                                                <label class="col-md-3 control-label" for="textarea">Télécharger le fichier</label>
                                                                                                <div class="col-md-9">									
                                                                                                    <input class="form-control" type="file" name="file[]">                                                                             
                                                                                                </div>                                                                            
                                                                                            </div>
                                                                                            <div class="form-group">
                                                                                                <label class="col-md-3 control-label"  for="textarea">Observation</label>
                                                                                                <div class="col-md-9">									
                                                                                                    <textarea class="form-control" name="observation" rows="10"></textarea>                                                                              
                                                                                                </div>                                                                            
                                                                                            </div>

                                                                                            <div class="form-group">
                                                                                                <label class="col-md-3 control-label" for="textarea">&nbsp;</label>
                                                                                                <div class="col-md-9">									
                                                                                                    <button class="btn btn-success form-control" type="submit">
                                                                                                        <i class="glyphicon glyphicon-ok"></i>
                                                                                                        Confirmer déshospitalisation
                                                                                                    </button>                                                                                
                                                                                                </div>                                                                            
                                                                                            </div>
                                                                                        </fieldset>
                                                                                    </form>
                                                                                <?php } else {
                                                                                    ?>
                                                                                    <div class="row"><div class="col-md-12"><h5 class="text-center alert alert-warning alert-secondary alert-dismissible">Vous n'aviez ce privilege, Veuillez contacter MDE Services/IT pour plus d'info</h5> </div></div>
                                                                                    <?php
                                                                                }
                                                                                ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>                                                    
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <br><br>
                                                </div>
                                            </div>


                                            <?php
                                        } else {
                                            //Hospitalisation not found
                                        }
                                    } else {
                                        ?>
                                        <h5 class="text-center alert alert-error alert-info alert-dismissable">Aucune information n'a été trouvée  pour l'acte médical de référence <?php $_GET['id'] ?> ... <br><br> Pour prescrire, veuillez cliquez <a class="btn btn-grad btn-metis-5" href="<?= $_SERVER['HTTP_REFERER'] ?>">BACK</a></h5>                                              <?php
                                    }
                                    ?>
                                    <div class="row">                                    
                                    </div>

                                <?php } else {
                                    ?>
                                    <h5 class="text-center alert alert-warning alert-secondary alert-dismissible">Aucune référence acte medical n'a été renseignée. <br>Si cette erreur persiste, vérifier bien que vous avez passé par la méthode logique pour y arriver et Si non, veuillez contacter MDE Services (IT) pour signaler l'erreur afin de consolider la sécurité du système<br><br><a href="<?= $_SERVER['HTTP_REFERER'] ?>">back</a></h5>                                


                                    <?php
                                }

                                break; //Sortie case transferer


                            case "hospitalisation":
                                ?>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="" role="tabpanel" data-example-id="togglable-tabs">
                                            <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                                                <li role="presentation" class="active"><a href="#hospitalise" id="home-tab" role="tab" data-toggle="tab" aria-expanded="false">Hospitalisés</a>
                                                </li>
                                                <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Chambre/Lit</a>
                                                </li>
                                                <li role="presentation" hidden="" class=""><a href="#tab_content3" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="true">Transferts</a>
                                                </li>
                                            </ul>
                                            <div id="myTabContent" class="tab-content ">
                                                <div role="tabpanel" class="tab-pane fade in active" id="hospitalise" aria-labelledby="home-tab">                                                                
                                                    <div class="box">
                                                        <header>
                                                            <h5>TOUS LES HOSPITALISES</h5>
                                                            <div class="toolbar">
                                                                <ul class="nav">
                                                                    <li>
                                                                        <form action="" method="post" class="form-inline" autocomplete="off">
                                                                            <div class=" form-group top_search">
                                                                                <div class="input-group">
                                                                                    <input type="text" class="form-control" placeholder="Recherche...">
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
                                                                            <li><a href="#"><i class="icon-external-link"></i>Date Entrée</a></li>
                                                                            <li><a href="#"><i class="icon-external-link"></i>Résultat</a></li>
                                                                            <li class="divider"></li>
                                                                            <li><a href="#">Personnalisé</a></li>
                                                                        </ul>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </header>
                                                        <div class="body" id="trigo" style="height: auto;">
                                                            <div class="row">
                                                                <div class="col-lg-12">
                                                                    <form class="form-inline text-center" action="/public/actes_medicaux.php?action=hospitalisation&filter" method="post">
                                                                        <div class="col-9">
                                                                            <h3>Appliquer le filtre</h3>                             
                                                                        </div>

                                                                        <div class="row clearfix clear">
                                                                            <div class="input-group">
                                                                                <label>Debut</label>&nbsp;
                                                                                <input type="date" name="start" class="input-mini " value="">
                                                                            </div>
                                                                            <div class="input-group">
                                                                                <label>Limite</label> &nbsp;
                                                                                <input type="date" name="end" class="input-mini " value="">
                                                                            </div>
                                                                            <div class="input-group">
                                                                                <label>Statut</label> &nbsp;
                                                                                <select type="text" name="statut" class="input-mini " value="">
                                                                                    <option value="">Tous</option>
                                                                                    <option value="0">Hospitalisé (e)</option>
                                                                                    <option value="1">Libéré (e)</option>
                                                                                    <option value="2">Transféré (e)</option>
                                                                                </select>
                                                                            </div>

                                                                        </div><br>
                                                                        <div class="row">
                                                                            <button type="" class="btn btn-grad btn-metis-3">Rechercher</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                            <?php
                                                            $listHospitalises = [];
                                                            if (isset($_GET['filter'])) {

                                                                if (count($_POST) > 0) {
                                                                    if (isset($_POST['start']) && !empty($_POST['start']) && Date::isValid(Date::dateToFr($_POST['start'], '%d-%m-%Y'))) {
                                                                        $start = $_POST['start'];
                                                                    } else {
                                                                        $start = date('Y-m') . "-01";
                                                                    }
                                                                    if (isset($_POST['end']) && !empty($_POST['end']) && Date::isValid(Date::dateToFr($_POST['end'], '%d-%m-%Y'))) {
                                                                        $end = $_POST['end'];
                                                                    } else {
                                                                        $end = date('Y-m') . date('-t');
                                                                    }
                                                                    if (isset($_POST['statut']) && !empty($_POST['statut'])) {
                                                                        $statut = $_POST['statut'];
                                                                        $condition['where'] = " WHERE (DATE(hospitalisation.date_entree) BETWEEN '$start' AND '$end') AND hospitalisation.statut = '$statut' ";
                                                                    } else {
                                                                        $condition['where'] = " WHERE (DATE(hospitalisation.date_entree) BETWEEN '$start' AND '$end') ";
                                                                        //$start = date('Y-m') . "-01";
                                                                    }


                                                                    $listHospitalises = $controller->gethospitalisation($condition);
                                                                    //$end = $_POST['end'];
                                                                } else {
                                                                    $listHospitalises = $controller->gethospitalisation();
                                                                }
                                                            } else {
                                                                $listHospitalises = $controller->gethospitalisation();
                                                            }

                                                            if (isset($listHospitalises['results']) && count($listHospitalises['results']) > 0) {
                                                                $count = 0;
                                                                ?>
                                                                <div class="col-lg-12">
                                                                    <?= composants\Utilitaire::pagination($listHospitalises['nbPages'], 50, "actes_medicaux.php?action=hospitalisation") ?>
                                                                </div>
                                                                <div id="stripedTable" class="body collapse in">

                                                                    <table class="table table-striped responsive-table">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>#</th>
                                                                                <th>Patient</th>
                                                                                <th>Acte médical </th>
                                                                                <th>Chambre/Lit</th>
                                                                                <th>Date Entrée</th>
                                                                                <th>Date Sortie</th>
                                                                                <th>Statut</th>
                                                                                <th>Jours</th>
                                                                                <th>Montant</th>
                                                                                <th>&nbsp;</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php
                                                                            foreach ($listHospitalises['results'] as $hospitalise) {
                                                                                $count++;
                                                                                ?>
                                                                                <tr class="">
                                                                                    <td><?= $count ?></td>
                                                                                    <td>
                                                                                        <a href="/controls/control.php?mod=patient&act=view&id=">
                                                                                            <img src="/img/personnel/<?= $hospitalise->filename . "." . $hospitalise->type ?>" class="user-profile"/><br>
                                                                                            <h5><?= $hospitalise->nompatient . " " . $hospitalise->postnompatient . " " . $hospitalise->prenompatient ?></h5>
                                                                                        </a>
                                                                                    </td>
                                                                                    <td><?= $hospitalise->actepose ?></td>
                                                                                    <td><?= $hospitalise->nomchambreheberge . "/" . $hospitalise->nomlitheberge ?></td>
                                                                                    <td><?= Date::reFormat($hospitalise->date_entree) ?></td>
                                                                                    <td><?= (isset($hospitalise->date_sortie) && !empty($hospitalise->date_sortie)) ? Date::reFormat($hospitalise->date_sortie) : "" ?></td>

                                                                                    <td><?= ($hospitalise->statuthosp == 0) ? "Hospitalisé(e)" : ($hospitalise->statuthosp == 1) ? "Libéré(e)" : "Transféré(e)" ?></td>
                                                                                    <td><?= (new DateTime($hospitalise->date_entree))->diff(new DateTime(($hospitalise->date_sortie) ? $hospitalise->date_sortie : new DatiTime()))->days ?></td>
                                                                                    <td><?= $hospitalise->prixchambre * (new DateTime($hospitalise->date_entree))->diff(new DateTime(($hospitalise->date_sortie) ? $hospitalise->date_sortie : new DatiTime()))->days ?> $</td>
                                                                                    <td>                                                                                
                                                                                        <a href="/public/actes_medicaux.php?action=view&id=<?= $hospitalise->id_actepose ?>" class="text-success"><span class="glyphicon glyphicon-eye-open"></span></a>
                                                                                        <a href="/" hidden="" class="text-danger"><span class="glyphicon glyphicon-remove"></span></a>
                                                                                    </td>
                                                                                </tr>
                                                                            <?php }
                                                                            ?>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            <?php } else {
                                                                ?>
                                                                <h5 class="text-center alert alert-info alert-secondary alert-dismissible">Aucune hospitalisation trouvée</h5> 
                                                                <?php
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">

                                                    <div class="text-center">
                                                        <ul class="stats_box">
                                                            <li>
                                                                <div class="sparkline bar_week"></div>
                                                                <div class="stat_text">
                                                                    <strong>5</strong>Chambre
                                                                    <span class="percent up"> <i class="fa fa-caret-down"></i> 3</span>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="sparkline line_day"></div>
                                                                <?php
                                                                unset($condition);
                                                                $condition['where'] = " WHERE lit.busy = '1'";
                                                                $nLitFree = count($controller->getlits($condition));
                                                                ?>
                                                                <div class="stat_text">
                                                                    <strong><?= count($controller->getlits()); ?></strong>Lits
                                                                    <span class="percent up"> <i class="fa fa-caret-up"></i> <?= $nLitFree ?></span>
                                                                </div>
                                                            </li>                                                                                    
                                                        </ul>
                                                    </div>
                                                    <div class="box">
                                                        <header>
                                                            <h5>TOUTES LES CHAMBRE ET LEUR LIT</h5>

                                                        </header>
                                                        <div class="body" id="trigo" style="height: auto;">
                                                            <?php
                                                            unset($condition);
                                                            $condition['order'] = " chambre.id ASC ";
                                                            $lits = $controller->getlits();
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
                                                                            <th>Libérer</th>
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
                                                                                    &nbsp;
                                                                                </td>
                                                                            </tr> 
                                                                        <?php }
                                                                        ?>
                                                                    </tbody>                
                                                                </table>
                                                                <?php
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="profile-tab">
                                                    <p>Aucun transfert </p>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <?php
                                break; //sortie Hospitalisation
                            case 'addExtrat':
                                if (isset($_GET['id'])) {
                                    $seeActe = $controller->getlistacte(['id' => $_GET['id']]);
                                    if (count($seeActe) > 0) {
                                        $seeActe = $seeActe[0];
                                        ?>
                                        <div class="col-lg-12 col-md-12">
                                            <div class="col-lg-12">
                                                <div class="panel panel-primary panel-group">
                                                    <div class="panel-heading panel-primary">
                                                        <h4>REF ACTE : <span class="text" style="font-weight: bolder">SMGR-<?= $seeActe->idactepose ?></span></h4>
                                                        <p><i class="glyphicon glyphicon-time"></i>&nbsp; Créé <?= $seeActe->date ?> par : <?= $seeActe->nomagent . " " . $seeActe->prenomagent . "(" . $seeActe->fonctionagent . ")" ?> </p>
                                                        <p><i class="glyphicon glyphicon-baby-formula"></i>&nbsp; <?= $seeActe->category ?></p>
                                                        <p><i class="glyphicon glyphicon-baby-formula"></i>&nbsp; <?= $seeActe->acte ?></p>
                                                    </div>
                                                    <div class="panel-body">
                                                        <div class="col"><h6>Pour :</h6><hr></div>   
                                                        <div class="row">
                                                            <div class="col-lg-3">
                                                                <div class="wrapImgProfile">
                                                                    <img src="/img/personnel/<?= $seeActe->filename . "." . $seeActe->type ?>">
                                                                </div>
                                                                <div class="">
                                                                    <br>
                                                                    <a href="/controls/control.php?mod=patient&act=view&id=<?= $seeActe->idPatient ?>" class="btn btn-success col-lg-12"><span class="glyphicon glyphicon-eye-open"></span> Voir Fiche </a>
                                                                    <br>              
                                                                </div>
                                                                <br>
                                                            </div>
                                                            <div class="col-lg-9 personne-info">
                                                                <div class="line-personne-info"><span class="champ">Nom :</span><span class="val-line-personne-info"><?= $seeActe->nompatient ?></span></div> 
                                                                <div class="line-personne-info"><span class="champ">Prénom :</span><span class="val-line-personne-info"><?= $seeActe->prenompatient ?></span></div> 
                                                                <div class="line-personne-info"><span class="champ">Post-nom :</span><span class="val-line-personne-info"><?= $seeActe->postnompatient ?></span></div> 
                                                                <div class="line-personne-info"><span class="champ">Date de naissance :</span><span class="val-line-personne-info"><?= $seeActe->agepatient ?></span></div> 
                                                                <div class="line-personne-info"><span class="champ">Etat civil :</span><span class="val-line-personne-info"><?= $seeActe->etatcivil ?></span></div> 
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div class="col-lg-12">
                                                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                                                <div class="col-lg-12">
                                                                    <form class="form-horizontal" role="form" id="formDiagnostic" method="post" action="/controls/control.php?mod=acte&act=addextrat&id=<?= $_GET['id'] ?>">
                                                                        <div class="form-group">
                                                                            <label class="col-sm-2 control-label">Extra</label>
                                                                            <div class="col-sm-10">
                                                                                <select class="form-control" name="extra">
                                                                                    <?php
                                                                                    $listExtra = $controller->getListExtra();
                                                                                    if (count($listExtra) > 0) {
                                                                                        foreach ($listExtra as $value) {
                                                                                            ?>
                                                                                            <option value="<?= $value->id ?>"><?= $value->lib ?></option>
                                                                                            <?php
                                                                                        }
                                                                                    }
                                                                                    ?>

                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="col-sm-2 control-label">Observations</label>
                                                                            <div class="col-sm-10">
                                                                                <textarea class="form-control" placeholder="Ecrivez votre conversation, observation faite pendant le nursing" name="obs" rows="6"></textarea>
                                                                            </div>
                                                                        </div>
                                                                        <input type="hidden" class="form-control refCat" name="acte_pose" value="<?= $seeActe->idactepose ?>">

                                                                        <div class="form-group">
                                                                            <button type="submit" class="form-control btn btn-metis-6 btn-grad"><i class="glyphicon glyphicon-save-file"></i> Enregistrer</button>
                                                                        </div>
                                                                    </form>
                                                                </div>

                                                            </div>



                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="panel-footer">
                                                    <a class="btn btn-info" href="/public/patients.php?action=view&id<?= $seeActe->idPatient ?>"><span class="glyphicon glyphicon-file"></span>Voir toutes</a>
                                                </div>
                                            </div>
                                        </div>

                                    <?php } else {
                                        ?>
                                        <div class="row"><div class="col-md-12"><h5 class="text-center alert alert-info alert-secondary alert-dismissible">Aucun acte n'a été trouvé</h5> </div></div>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <div class="row"><div class="col-md-12"><h5 class="text-center alert alert-info alert-secondary alert-dismissible">Vous n'avez sélectionné aucun acte</h5> </div></div>
                                    <?php
                                }

                                break; //Sortie addExtra
                            case 'prescrire':
                                if (isset($_GET['m'])) {
                                    switch ($_GET['m']) {
                                        case "viewdetail" :
                                            if (isset($_GET['id']) && !empty($_GET['id'])) {
                                                $condition['where'] = " WHERE prescription.id = '" . $_GET["id"] . "'";
                                                $prescriptionInfo = $controller->getPrescription($condition);
                                                if (count($prescriptionInfo) > 0) {
                                                    $prescriptionInfo = $prescriptionInfo[0];
                                                    unset($condition);
                                                    $condition['where'] = " WHERE element_prescrit.id_prescription = '" . $_GET["id"] . "'";
                                                    $elementprescrits = $controller->getelementPrescritbyprescritionId($condition);
                                                    ?>

                                                    <div class="col-lg-12 col-md-12">
                                                        <div class="col-lg-12">
                                                            <div class="panel panel-primary panel-group">
                                                                <div class="panel-heading panel-primary">
                                                                    <h4>REF PRESC : <span class="text" style="font-weight: bolder"><?= $prescriptionInfo->idPrescription ?></span></h4>
                                                                    <h5>REF ACTE : <span class="text" style="font-weight: bolder">SMGR-<?= $prescriptionInfo->idactepose ?></span></h5>

                                                                    <p><i class="glyphicon glyphicon-time"></i>&nbsp; initialisé le <?= $prescriptionInfo->datePrescrit ?> par : <?= $prescriptionInfo->nomagent . " " . $prescriptionInfo->prenomagent . "(" . $prescriptionInfo->fonction . ")" ?> </p>
                                                                    <p><i class="glyphicon glyphicon-baby-formula"></i>&nbsp; <?= $prescriptionInfo->category ?></p>
                                                                    <p><i class="glyphicon glyphicon-baby-formula"></i>&nbsp; <?= $prescriptionInfo->acte ?></p>
                                                                    <p><a href="/public/actes_medicaux.php?action=view&id=<?= $prescriptionInfo->idactepose ?>" class="btn btn-metis-1 btn-grad"><i class="glyphicon glyphicon-backward"></i> Back to viewer Acte</a></p>
                                                                </div>
                                                                <div class="panel-body">
                                                                    <div class="col"><h6>Pour :</h6><hr></div>   
                                                                    <div class="row">
                                                                        <div class="col-lg-3">
                                                                            <div class="wrapImgProfile">
                                                                                <img src="/img/personnel/<?= $prescriptionInfo->filename . "." . $prescriptionInfo->type ?>">
                                                                            </div>
                                                                            <div class="">
                                                                                <br>
                                                                                <a href="/controls/control.php?mod=patient&act=view&id=<?= $prescriptionInfo->idPatient ?>" class="btn btn-success col-lg-12"><span class="glyphicon glyphicon-eye-open"></span> Voir Fiche </a>
                                                                                <br>              
                                                                            </div>
                                                                            <br>
                                                                        </div>
                                                                        <div class="col-lg-9 personne-info">
                                                                            <div class="line-personne-info"><span class="champ">Nom :</span><span class="val-line-personne-info"><?= $prescriptionInfo->nompatient ?></span></div> 
                                                                            <div class="line-personne-info"><span class="champ">Prénom :</span><span class="val-line-personne-info"><?= $prescriptionInfo->prenompatient ?></span></div> 
                                                                            <div class="line-personne-info"><span class="champ">Post-nom :</span><span class="val-line-personne-info"><?= $prescriptionInfo->postnompatient ?></span></div> 
                                                                            <div class="line-personne-info"><span class="champ">Date de naissance :</span><span class="val-line-personne-info"><?= $prescriptionInfo->agepatient ?></span></div> 
                                                                            <div class="line-personne-info"><span class="champ">Etat civil :</span><span class="val-line-personne-info"><?= $prescriptionInfo->etatcivil ?></span></div> 
                                                                        </div>
                                                                    </div>
                                                                    <hr>
                                                                    <div class="col-lg-12">
                                                                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                                                            <div class="col-lg-12">
                                                                                <h5 class="text-center">Liste des éléments prescrits</h5>   
                                                                                <hr>
                                                                                <?php
                                                                                if (count($elementprescrits) > 0) {
                                                                                    $count = 0;
                                                                                    ?>
                                                                                    <table class="table table-striped table-primary">
                                                                                        <thead>
                                                                                        <th>#</th>
                                                                                        <th>Id</th>
                                                                                        <th>Element</th>
                                                                                        <th>Mode d'emploi</th>
                                                                                        <th>Observation</th>
                                                                                        <th>&nbsp;</th>
                                                                                        </thead>                                                            
                                                                                        <tbody>
                                                                                            <?php
                                                                                            foreach ($elementprescrits as $element) {
                                                                                                $count++
                                                                                                ?>
                                                                                                <tr>
                                                                                                    <td>
                                                                                                        <?= $count ?>
                                                                                                    </td>
                                                                                                    <td><?= $element->idelementprescrit ?></td>
                                                                                                    <td><?= $element->element ?></td>
                                                                                                    <td><?= $element->mode_emploi ?></td>
                                                                                                    <td><?= $element->elem_observation ?></td>
                                                                                                    <td><a href="/controls/control.php?mod=acte&act=removeelementfromprescrire&idprescription=<?= $_GET['id'] ?>&idelement=<?= $element->idelementprescrit ?>"><span class="glyphicon glyphicon-remove"></span></a></td>
                                                                                                <tr>
                                                                                                    <?php
                                                                                                }
                                                                                                ?>
                                                                                        </tbody>
                                                                                    </table>                                                        
                                                                                    <?php
                                                                                }
                                                                                ?>
                                                                                <div class="row">
                                                                                    <div class="col-lg-12">
                                                                                        <?php
                                                                                        if ($_SESSION['user']['idFonction'] == "1" || $_SESSION['user']['idFonction'] == "2" || $_SESSION['user']['idFonction'] == "0") {
                                                                                            ?>
                                                                                            <form action="/controls/control.php?mod=acte&act=addelementoprescription&idprescription=<?= $_GET['id'] ?>" class="form-horizontal" method="POST">
                                                                                                <fieldset>
                                                                                                    <legend>Ajouter un nouvel élément dans la prescription <br></legend>
                                                                                                    <div class="form-group">
                                                                                                        <label class="col-md-2 control-label" for="text-field">Element</label>
                                                                                                        <div class="col-md-10">
                                                                                                            <input class="form-control" name="element" placeholder="Veuillez écrire le produit que vous vouliez prescrire au patient (Medicament, vaccin...)" type="text">
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <input type="hidden" name="idprescription" value="<?= $_GET['id'] ?>"/>
                                                                                                    <div class="form-group">
                                                                                                        <label class="col-md-2 control-label">Mode d'emploie</label>
                                                                                                        <div class="col-md-10">
                                                                                                            <input class="form-control" name="modeemploi" placeholder="Ecrire une mode d'emploi du produit recommandé" type="text" value="">
                                                                                                        </div>
                                                                                                    </div>

                                                                                                    <div class="form-group">
                                                                                                        <label class="col-md-2 control-label" for="textarea">Observation</label>
                                                                                                        <div class="col-md-10">
                                                                                                            <textarea class="form-control" name="observation" placeholder="Veuillez si possible une information supplémentaire en rapport avec element prescrit" rows="6"></textarea>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="col-md-12">

                                                                                                        <button class="btn btn-primary" type="submit">
                                                                                                            <i class="glyphicon glyphicon-plus"></i>
                                                                                                            Ajouter
                                                                                                        </button>
                                                                                                    </div>

                                                                                                </fieldset>
                                                                                            </form>
                                                                                            <?php
                                                                                        }
                                                                                        ?>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                        </div>



                                                                    </div>
                                                                </div>

                                                            </div>

                                                            <br><br>
                                                        </div>
                                                    </div>


                                                <?php } else {
                                                    ?>
                                                    <h5 class="text-center alert alert-error alert-info alert-dismissable">Aucune prescription n'a été initialisé pour l'acte médical de référence <?php $_GET['id'] ?> ... <br><br> Pour prescrire, veuillez cliquez <a class="btn btn-grad btn-metis-5" href="/public/actes_medicaux.php?action=prescrire&idactepose=9&m=newprescription">ICI</a></h5>                                              <?php
                                                }
                                                ?>
                                                <div class="row">                                    
                                                </div>

                                            <?php } else {
                                                ?>
                                                <h5 class="text-center alert alert-warning alert-secondary alert-dismissible">Aucune référence prescription n'a été renseignée. <br>Si cette erreur persiste, vérifier bien que vous avez passé par la méthode logique pour y arriver et Si non, veuillez contacter MDE Services (IT) pour signaler l'erreur afin de consolider la sécurité du système<br><br><a href="<?= $_SERVER['HTTP_REFERER'] ?>">back</a></h5>                                
                                                <?php
                                            }
                                            break; // Sortie $_GET['m'] = viewdetail

                                        case "init" ://Initialisation de la prescription               
                                            if (isset($_GET['id']) && !empty($_GET['id'])) { //@ $id de la acte medicaux  
                                                unset($condition);
                                                $seeActe = $controller->getlistacte($_GET);
                                                if (count($seeActe) > 0) {
                                                    $seeActe = $seeActe[0];
                                                    ?>

                                                    <div class="col-lg-12 col-md-12">
                                                        <div class="col-lg-12">
                                                            <div class="panel panel-primary panel-group">
                                                                <div class="panel-heading panel-primary">
                                                                    <h4>REF ACTE : <span class="text" style="font-weight: bolder">SMGR-<?= $seeActe->idactepose ?></span></h4>
                                                                    <p><i class="glyphicon glyphicon-time"></i>&nbsp; Créé <?= $seeActe->date ?> par : <?= $seeActe->nomagent . " " . $seeActe->prenomagent . "(" . $seeActe->fonctionagent . ")" ?> </p>
                                                                    <p><i class="glyphicon glyphicon-baby-formula"></i>&nbsp; <?= $seeActe->category ?></p>
                                                                    <p><i class="glyphicon glyphicon-baby-formula"></i>&nbsp; <?= $seeActe->acte ?></p>
                                                                    <p><a href="/public/actes_medicaux.php?action=view&id=<?= $seeActe->idactepose ?>" class="btn btn-metis-1 btn-grad"><i class="glyphicon glyphicon-backward"></i> Back to viewer Acte</a></p>
                                                                </div>

                                                                <div class="panel-body">

                                                                    <div class="col"><h6>Pour :</h6><hr></div>   
                                                                    <div class="col-lg-3">
                                                                        <div class="wrapImgProfile">
                                                                            <img src="/img/personnel/<?= $seeActe->filename . "." . $seeActe->type ?>">
                                                                        </div>
                                                                        <div class="">

                                                                            <br>              
                                                                        </div>
                                                                        <br>
                                                                    </div>
                                                                    <div class="col-lg-9 personne-info">
                                                                        <div class="line-personne-info"><span class="champ">Nom :</span><span class="val-line-personne-info"><?= $seeActe->nompatient ?></span></div> 
                                                                        <div class="line-personne-info"><span class="champ">Prénom :</span><span class="val-line-personne-info"><?= $seeActe->prenompatient ?></span></div> 
                                                                        <div class="line-personne-info"><span class="champ">Post-nom :</span><span class="val-line-personne-info"><?= $seeActe->postnompatient ?></span></div> 
                                                                        <div class="line-personne-info"><span class="champ">Date de naissance :</span><span class="val-line-personne-info"><?= $seeActe->agepatient ?></span></div> 
                                                                        <div class="line-personne-info"><span class="champ">Etat civil :</span><span class="val-line-personne-info"><?= $seeActe->etatcivil ?></span></div> 
                                                                    </div>                                                                                        
                                                                    <hr>
                                                                    <div class="col-lg-12">
                                                                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                                                            <div class="col-lg-12">

                                                                                <hr>                                              
                                                                                <div class="row">
                                                                                    <div class="col-lg-12">
                                                                                        <?php
                                                                                        if ($_SESSION['user']['idFonction'] == 1 || $_SESSION['user']['idFonction'] == 2 || $_SESSION['user']['idFonction'] == 0) {
                                                                                            ?>
                                                                                            <form action="/controls/control.php?mod=acte&act=initprescription&idprescription=<?= $_GET['id'] ?>" class="form-horizontal" method="POST">
                                                                                                <fieldset>
                                                                                                    <legend style="font-size: 0.8em"><div class="alert alert-info" ><i class="glyphicon glyphicon-info-sign text-warning" style="font-size: 1.6em"></i><br>Initialisation vous permet à obtenir un formulaire vous permettant à établir une liste des éléments à prescrire au patient<br>
                                                                                                            NB: la rubrique Observation n'est pas obligatoire si il y a pas une observation à faire pour la prescription.
                                                                                                            <br> En outre, Pour chaque élément à ajouter sur la liste de prescription, si il y a une observation à faire, ça sera faite sur le formulaire d'ajout des éléments à prescrire.
                                                                                                            <br></div></legend>                                                                        
                                                                                                    <input type="hidden" name="idactepose" value="<?= $_GET['id'] ?>"/>

                                                                                                    <div class="form-group">
                                                                                                        <label class="col-md-2 control-label" for="textarea">Observation</label>
                                                                                                        <div class="col-md-10">
                                                                                                            <textarea class="form-control" name="observation" placeholder="Veuillez si possible une information supplémentaire en rapport avec element prescrit" rows="6"></textarea>
                                                                                                            <br><br>
                                                                                                            <div class="form-group">												
                                                                                                                <button class="btn btn-success form-control" type="submit">
                                                                                                                    <i class="glyphicon glyphicon-ok"></i>
                                                                                                                    Confirmer initialisation prescription
                                                                                                                </button>
                                                                                                            </div>
                                                                                                        </div>

                                                                                                    </div>


                                                                                                </fieldset>
                                                                                            </form>
                                                                                        <?php } else {
                                                                                            ?>
                                                                                            <div class="row"><div class="col-md-12"><h5 class="text-center alert alert-warning alert-secondary alert-dismissible">Vous n'avez pas de privilèges de prescrire</h5> </div></div>
                                                                                            <?php
                                                                                        }
                                                                                        ?>
                                                                                    </div>
                                                                                </div>                                                    

                                                                            </div>

                                                                        </div>



                                                                    </div>
                                                                </div>

                                                            </div>

                                                            <br><br>
                                                        </div>
                                                    </div>


                                                <?php } else {
                                                    ?>
                                                    <h5 class="text-center alert alert-error alert-info alert-dismissable">Aucune information n'a été trouvée  pour l'acte médical de référence <?php $_GET['id'] ?> ... <br><br> Pour prescrire, veuillez cliquez <a class="btn btn-grad btn-metis-5" href="<?= $_SERVER['HTTP_REFERER'] ?>">BACK</a></h5>                                              <?php
                                                }
                                                ?>
                                                <div class="row">                                    
                                                </div>

                                            <?php } else {
                                                ?>
                                                <h5 class="text-center alert alert-warning alert-secondary alert-dismissible">Aucune référence acte medical n'a été renseignée. <br>Si cette erreur persiste, vérifier bien que vous avez passé par la méthode logique pour y arriver et Si non, veuillez contacter MDE Services (IT) pour signaler l'erreur afin de consolider la sécurité du système<br><br><a href="<?= $_SERVER['HTTP_REFERER'] ?>">back</a></h5>                                
                                                <?php
                                            }

                                            break; //Sortie init prescription
                                    }//Fin switch $_GET[m] of Prescrire;
                                } else {//fin test si $_GET['m'] n'existe pas
                                    ?>
                                    <h5 class="text-center alert alert-warning alert-secondary alert-dismissible">Mauvaise route. <br>Veuillez procéder logiquement</h5> 

                                    <?php
                                }//fin test si $_GET['m']

                                break; //Fin prescrire
                            case 'diagnostiquer':
                                if (isset($_GET['id']) && !empty($_GET['id'])) {
                                    $seeActe = $controller->getlistacte($_GET);
                                    if (count($seeActe) > 0) {
                                        $seeActe = $seeActe[0];
                                        ?>
                                        <div class="col-lg-12 col-md-12">
                                            <div class="col-lg-12">
                                                <div class="panel panel-primary panel-group">
                                                    <div class="panel-heading panel-primary">
                                                        <h4>REF ACTE : <span class="text" style="font-weight: bolder">SMGR-<?= $seeActe->idactepose ?></span></h4>
                                                        <p><i class="glyphicon glyphicon-time"></i>&nbsp; Créé <?= $seeActe->date ?> par : <?= $seeActe->nomagent . " " . $seeActe->prenomagent . "(" . $seeActe->fonctionagent . ")" ?> </p>
                                                        <p><i class="glyphicon glyphicon-baby-formula"></i>&nbsp; <?= $seeActe->category ?></p>
                                                        <p><i class="glyphicon glyphicon-baby-formula"></i>&nbsp; <?= $seeActe->acte ?></p>
                                                        <p><a class="btn btn-metis-1 btn-grad" href="/public/actes_medicaux.php?action=view&id=<?= $seeActe->idactepose ?>"><i class="glyphicon glyphicon-chevron-left"></i> Back</a></p>
                                                    </div>
                                                    <div class="panel-body">
                                                        <div class="col"><h6>Pour :</h6><hr></div>   
                                                        <div class="row">
                                                            <div class="col-lg-3">
                                                                <div class="wrapImgProfile">
                                                                    <img src="/img/personnel/<?= $seeActe->filename . "." . $seeActe->type ?>">
                                                                </div>
                                                                <div class="">
                                                                    <br>
                                                                    <a href="/controls/control.php?mod=patient&act=view&id=<?= $seeActe->idPatient ?>" class="btn btn-success col-lg-12"><span class="glyphicon glyphicon-eye-open"></span> Voir Fiche </a>
                                                                    <br>              
                                                                </div>
                                                                <br>
                                                            </div>
                                                            <div class="col-lg-9 personne-info">
                                                                <div class="line-personne-info"><span class="champ">Nom :</span><span class="val-line-personne-info"><?= $seeActe->nompatient ?></span></div> 
                                                                <div class="line-personne-info"><span class="champ">Prénom :</span><span class="val-line-personne-info"><?= $seeActe->prenompatient ?></span></div> 
                                                                <div class="line-personne-info"><span class="champ">Post-nom :</span><span class="val-line-personne-info"><?= $seeActe->postnompatient ?></span></div> 
                                                                <div class="line-personne-info"><span class="champ">Date de naissance :</span><span class="val-line-personne-info"><?= $seeActe->agepatient ?></span></div> 
                                                                <div class="line-personne-info"><span class="champ">Etat civil :</span><span class="val-line-personne-info"><?= $seeActe->etatcivil ?></span></div> 
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div class="col-lg-12">
                                                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                                                <div class="col-lg-12">
                                                                    <form class="form-horizontal" role="form" id="formDiagnostic" method="post" action="/controls/control.php?mod=acte&amp;act=addDiagnostic">
                                                                        <div class="form-group">
                                                                            <label class="col-sm-2 control-label">Anamnèses</label>
                                                                            <div class="col-sm-10">
                                                                                <textarea class="form-control" placeholder="Ecrivez votre conversation, observation fait pendant le diagnostique" name="obs" rows="6"></textarea>
                                                                            </div>
                                                                        </div>
                                                                        <input type="hidden" class="form-control refCat" name="acte_pose" value="<?= $seeActe->idactepose ?>">
                                                                        <div class="form-group">
                                                                            <label for="inputEmail3" class="col-sm-2 control-label">Examens</label>
                                                                            <div class="col-sm-10">
                                                                                <div class="input-group">
                                                                                    <p class="form-control  alert-info" name="listExamen" id="listExamen">
                                                                                        Pour recommander les examens veuillez terminer cette étape 
                                                                                    </p>
                                                                                    <!--
                                                                                    <span class="input-group-btn">
                                                                                        <a  class="btn btn-default" href="/public/actes_medicaux.php?action=examen&m=addexamen" type="button"><span class="glyphicon glyphicon-plus"></span>Ajouter les examens</a>
                                                                                    </span>-->
                                                                                </div>

                                                                            </div>
                                                                        </div>


                                                                        <div class="form-group">
                                                                            <button type="submit" class="form-control btn btn-metis-6 btn-grad"><i class="glyphicon glyphicon-save-file"></i> Enregistrer</button>
                                                                        </div>
                                                                    </form>
                                                                </div>

                                                            </div>



                                                        </div>
                                                    </div>

                                                </div>

                                            </div>
                                        </div>


                                    <?php } else {
                                        ?>
                                        <h5 class="text-center alert alert-error alert-info alert-dismissable">Aucune information de diagnostique en référence <?php $_GET['id'] ?> n'a été trouvée <br><br> <a class="btn btn-grad btn-metis-5" href="/public/actes_medicaux.php">Cliquez pour rentrer à la liste des actes médicaux</a></h5>
                                        <?php
                                    }
                                    ?>
                                    <div class="row">

                                    </div>

                                <?php } else {
                                    ?>
                                    <h5 class="text-center alert alert-warning alert-secondary alert-dismissible">Aucune référence acte médical n'a été renseignée. <br>Si cette erreur persiste, vérifier bien que vous avez passé par la méthode logique pour y arriver et Si non, veuillez contacter MDE Services (IT) pour signaler l'erreur afin de consolider la sécurité du système</h5> 

                                    <?php
                                }//Fin pas $_GET['iddiagnostic]

                                break; //fin diagnostiquer un patient

                            case 'examen':
                                if (isset($_GET['m'])) {
                                    switch ($_GET['m']) {
                                        case 'addexamen':
                                            if (isset($_GET['id']) && !empty($_GET['id'])) {
                                                $diagnosticInfo = $controller->getdiagnostic($_GET['id']);
                                                if (count($diagnosticInfo) > 0) {

                                                    $diagnosticInfo = $diagnosticInfo[0];
                                                    ?>

                                                    <div class="col-lg-12 col-md-12">
                                                        <div class="col-lg-12">
                                                            <div class="panel panel-primary panel-group">
                                                                <div class="panel-heading panel-primary">
                                                                    <h4>REF DIAGNOSTIQUE : <span class="text" style="font-weight: bolder"><?= $diagnosticInfo->id_diagnostic ?></span></h4>
                                                                    <h5>REF ACTE : <span class="text" style="font-weight: bolder">SMGR-<?= $diagnosticInfo->idactepose ?></span></h5>
                                                                    <p><i class="glyphicon glyphicon-time"></i>&nbsp; Diagnistiqué <?= $diagnosticInfo->datediagnostic ?> par : <?= $diagnosticInfo->nomagent . " " . $diagnosticInfo->prenomagent . "(" . $diagnosticInfo->fonction . ")" ?> </p>
                                                                    <p><i class="glyphicon glyphicon-baby-formula"></i>&nbsp; <?= $diagnosticInfo->category ?></p>
                                                                    <p><i class="glyphicon glyphicon-baby-formula"></i>&nbsp; <?= $diagnosticInfo->acte_pose ?></p>
                                                                    <p><a class="btn btn-metis-1 btn-grad" href="/public/actes_medicaux.php?action=view&id=<?= $diagnosticInfo->idactepose ?>"><i class="glyphicon glyphicon-chevron-left"></i> Back</a></p>
                                                                </div>
                                                                <div class="panel-body">
                                                                    <div class="col"><h6>Pour :</h6><hr></div>   
                                                                    <div class="row">
                                                                        <div class="col-lg-3">
                                                                            <div class="wrapImgProfile">
                                                                                <img src="/img/personnel/<?= $diagnosticInfo->filename . "." . $diagnosticInfo->type ?>">
                                                                            </div>
                                                                            <div class="">
                                                                                <br>
                                                                                <a href="/controls/control.php?mod=patient&act=view&id=<?= $diagnosticInfo->idPatient ?>" class="btn btn-success col-lg-12"><span class="glyphicon glyphicon-eye-open"></span> Voir Fiche </a>
                                                                                <a href="/public/actes_medicaux.php?action=prelever&id=<?= $diagnosticInfo->idPatient ?>" class="btn btn-success col-lg-12"><span class="glyphicon glyphicon-eye-open"></span> Préléver </a>
                                                                                <br>              
                                                                            </div>
                                                                            <br>
                                                                        </div>
                                                                        <div class="col-lg-9 personne-info">
                                                                            <div class="line-personne-info"><span class="champ">Nom :</span><span class="val-line-personne-info"><?= $diagnosticInfo->nompatient ?></span></div> 
                                                                            <div class="line-personne-info"><span class="champ">Prénom :</span><span class="val-line-personne-info"><?= $diagnosticInfo->prenompatient ?></span></div> 
                                                                            <div class="line-personne-info"><span class="champ">Post-nom :</span><span class="val-line-personne-info"><?= $diagnosticInfo->postnompatient ?></span></div> 
                                                                            <div class="line-personne-info"><span class="champ">Date de naissance :</span><span class="val-line-personne-info"><?= $diagnosticInfo->age ?></span></div> 
                                                                            <div class="line-personne-info"><span class="champ">Etat civil :</span><span class="val-line-personne-info"><?= $diagnosticInfo->etatcivil ?></span></div> 
                                                                        </div>
                                                                    </div>
                                                                    <hr>
                                                                    <div class="col-lg-12">
                                                                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                                                            <div class="col-lg-12">
                                                                                <form class="form-horizontal" role="form" method="post" action="/controls/control.php?mod=acte&act=addexamen">                                                        
                                                                                    <div class="form-group">
                                                                                        <input type="hidden" name="iddiagnostic" value="<?= $diagnosticInfo->id_diagnostic ?>" >
                                                                                        <label for="inputEmail3" class="col-sm-2 control-label">Liste des examens</label>
                                                                                        <div class="col-sm-10">
                                                                                            <select class="form-control" name="examen">                                
                                                                                                <?php
                                                                                                $listExamen = $controller->getListExamen();
                                                                                                if (count($listExamen) > 0) {
                                                                                                    foreach ($listExamen as $itemExamen) {
                                                                                                        ?>
                                                                                                        <option value="<?= $itemExamen->id ?>"><?= $itemExamen->lib ?></option>
                                                                                                        <?php
                                                                                                    }
                                                                                                    ?>

                                                                                                    <?php
                                                                                                }
                                                                                                ?>

                                                                                            </select>
                                                                                            <div class="col-lg-12 viewListExamenRecommand" >
                                                                                                <h5>Liste des examens recommandés</h5>
                                                                                                <hr>
                                                                                                <table class="table">
                                                                                                    <thead>
                                                                                                    <th>#</th>
                                                                                                    <th>Examen</th>
                                                                                                    <th>Observation</th>
                                                                                                    <th>résultat</th>
                                                                                                    <th>Fait</th>
                                                                                                    <th>&nbsp;</th>
                                                                                                    </thead>
                                                                                                    <tbody>
                                                                                                        <?php
                                                                                                        $listExamenRecommand = $controller->getrecommandexamen($_GET['id']);
                                                                                                        if (count($listExamenRecommand) > 0) {
                                                                                                            $count = 0;

                                                                                                            foreach ($listExamenRecommand as $itemExamenRecommand) {
                                                                                                                $count++;
                                                                                                                ?>
                                                                                                                <tr>
                                                                                                                    <td><?= $count ?></td>
                                                                                                                    <td><?= $itemExamenRecommand->examen ?> </td>
                                                                                                                    <td><?= $itemExamenRecommand->obs ?></td>
                                                                                                                    <td><?= $itemExamenRecommand->resultat ?></td>
                                                                                                                    <td><?= $itemExamenRecommand->fait ?></td>                                                                                

                                                                                                                    <td><a class="text-danger" href="/controls/control.php?mod=acte&act=removerecomamandexamen&id=<?= $itemExamenRecommand->id ?>"><i class="glyphicon glyphicon-remove"></i></a></td>

                                                                                                                </tr>
                                                                                                                <?php
                                                                                                            }
                                                                                                        }
                                                                                                        ?>
                                                                                                    </tbody>
                                                                                                </table>

                                                                                            </div>
                                                                                        </div>
                                                                                    </div>        

                                                                                    <div class="form-group">
                                                                                        <label class="col-sm-2 control-label">Observations</label>
                                                                                        <div class="col-sm-10">
                                                                                            <textarea class="form-control" placeholder="Textarea" name="observation" rows="6"></textarea>
                                                                                        </div>
                                                                                    </div>

                                                                                    <hr>
                                                                                    <div class="form-group">
                                                                                        <div class="col-sm-offset-2 col-sm-10">
                                                                                            <div class="checkbox">
                                                                                                <button type="submit" value="" class="btn btn-grad btn-success"><span class="glyphicon glyphicon-floppy-save"></span> Ajouter l'examen</button>
                                                                                                <button type="reset" value="" class="btn btn-grad btn-metis-5"><span class="glyphicon glyphicon-refresh"></span> Annuler</button>
                                                                                            </div>                                                                              
                                                                                        </div>
                                                                                    </div>
                                                                                </form>

                                                                            </div>

                                                                        </div>



                                                                    </div>
                                                                </div>

                                                            </div>

                                                        </div>
                                                    </div>


                                                <?php } else {
                                                    ?>
                                                    <h5 class="text-center alert alert-error alert-info alert-dismissable">Aucune information de diagnostique en référence <?php $_GET['id'] ?> n'a été trouvée, vous ne pouvez pas faire un examen... <br><br> <a class="btn btn-grad btn-metis-5" href="/public/actes_medicaux.php?action=listdiagnistic">Cliquez pour rentrer à la liste des diagnstics</a></h5>
                                                    <?php
                                                }
                                                ?>
                                                <div class="row">                                    
                                                </div>

                                            <?php } else {
                                                ?>
                                                <h5 class="text-center alert alert-warning alert-secondary alert-dismissible">Aucune référence diagnostic n'a été renseignée. <br>Si cette erreur persiste, vérifier bien que vous avez passé par la méthode logique pour y arriver et Si non, veuillez contacter MDE Services (IT) pour signaler l'erreur afin de consolider la sécurité du système</h5> 

                                                <?php
                                            }
                                            ?>

                                            <?php
                                            break; //fin newexamen
                                        case "doexamen":

                                            if (isset($_GET['id']) && !empty($_GET['id'])) {
                                                $diagnosticInfo = $controller->getdiagnostic($_GET['id']);

                                                if (count($diagnosticInfo) > 0) {
                                                    $diagnosticInfo = $diagnosticInfo[0];
                                                    ?>
                                                    <div class="col-lg-12 col-md-12">
                                                        <div class="col-lg-12">
                                                            <div class="panel panel-primary panel-group">
                                                                <div class="panel-heading panel-primary">
                                                                    <h4>REF DIAGNOSTIQUE : <span class="text" style="font-weight: bolder"><?= $diagnosticInfo->id_diagnostic ?></span></h4>
                                                                    <h5>REF ACTE : <span class="text" style="font-weight: bolder">SMGR-<?= $diagnosticInfo->idactepose ?></span></h5>
                                                                    <p><i class="glyphicon glyphicon-time"></i>&nbsp; Diagnistiqué <?= $diagnosticInfo->datediagnostic ?> par : <?= $diagnosticInfo->nomagent . " " . $diagnosticInfo->prenomagent . "(" . $diagnosticInfo->fonction . ")" ?> </p>
                                                                    <p><i class="glyphicon glyphicon-baby-formula"></i>&nbsp; <?= $diagnosticInfo->category ?></p>
                                                                    <p><i class="glyphicon glyphicon-baby-formula"></i>&nbsp; <?= $diagnosticInfo->acte_pose ?></p>
                                                                    <p><a class="btn btn-metis-1 btn-grad" href="/public/actes_medicaux.php?action=view&id=<?= $diagnosticInfo->idactepose ?>"><i class="glyphicon glyphicon-chevron-left"></i> Back</a></p>
                                                                </div>
                                                                <div class="panel-body">
                                                                    <div class="col"><h6>Pour :</h6><hr></div>   
                                                                    <div class="row">
                                                                        <div class="col-lg-3">
                                                                            <div class="wrapImgProfile">
                                                                                <img src="/img/personnel/<?= $diagnosticInfo->filename . "." . $diagnosticInfo->type ?>">
                                                                            </div>
                                                                            <div class="">
                                                                                <br>
                                                                                <a href="/controls/control.php?mod=patient&act=view&id=<?= $diagnosticInfo->idPatient ?>" class="btn btn-success col-lg-12"><span class="glyphicon glyphicon-eye-open"></span> Voir Fiche </a>
                                                                                <a href="/public/actes_medicaux.php?action=examen&m=doprelever&id=<?= $_GET['id'] ?>" style="margin-top: 10px" class="btn btn-success col-lg-12"><span class="glyphicon glyphicon-eye-open"></span> Préléver </a>
                                                                                <br>              
                                                                            </div>
                                                                            <br>
                                                                        </div>
                                                                        <div class="col-lg-9 personne-info">
                                                                            <div class="line-personne-info"><span class="champ">Nom :</span><span class="val-line-personne-info"><?= $diagnosticInfo->nompatient ?></span></div> 
                                                                            <div class="line-personne-info"><span class="champ">Prénom :</span><span class="val-line-personne-info"><?= $diagnosticInfo->prenompatient ?></span></div> 
                                                                            <div class="line-personne-info"><span class="champ">Post-nom :</span><span class="val-line-personne-info"><?= $diagnosticInfo->postnompatient ?></span></div> 
                                                                            <div class="line-personne-info"><span class="champ">Date de naissance :</span><span class="val-line-personne-info"><?= $diagnosticInfo->age ?></span></div> 
                                                                            <div class="line-personne-info"><span class="champ">Etat civil :</span><span class="val-line-personne-info"><?= $diagnosticInfo->etatcivil ?></span></div> 
                                                                        </div>
                                                                    </div>
                                                                    <hr>
                                                                    <div class="col-lg-12">
                                                                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                                                            <div class="col-lg-12">
                                                                                <form class="form-horizontal" role="form" method="post" action="/controls/control.php?mod=acte&act=doexamen">                                                        
                                                                                    <div class="form-group">
                                                                                        <input type="hidden" name="iddiagnostic" value="<?= $diagnosticInfo->id_diagnostic ?>" >
                                                                                        <input type="hidden" name="id_acte" value="<?= $diagnosticInfo->idactepose ?>" >
                                                                                        <label for="inputEmail3" class="col-sm-2 control-label">Liste des Exa. Recommandés</label>
                                                                                        <div class="col-sm-10">
                                                                                            <select class="form-control" name="examen">
                                                                                                <?php
                                                                                                $listExamen = $controller->getrecommandexamen($_GET['id']);
                                                                                                if (count($listExamen) > 0) {
                                                                                                    foreach ($listExamen as $itemExamen) {
                                                                                                        ?>
                                                                                                        <option value="<?= $itemExamen->id ?>"><?= $itemExamen->examen ?></option>
                                                                                                        <?php
                                                                                                    }
                                                                                                    ?>

                                                                                                    <?php
                                                                                                }
                                                                                                ?>

                                                                                            </select>
                                                                                            <div class="row">
                                                                                                <br>
                                                                                                <div class="col-lg-12">

                                                                                                    <textarea class="form-control" name="resultat" placeholder="Ecrire le résultat ici"></textarea>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="row">
                                                                                                <br>
                                                                                                <div class="col-lg-12">
                                                                                                    <button class="form-control btn btn-metis-3 btn-grad " placeholder="" type="submit">Confirmer </button>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-lg-12 viewListExamenRecommand" >
                                                                                                <h5>Liste des examens recommandés</h5>
                                                                                                <hr>
                                                                                                <table class="table">
                                                                                                    <thead>
                                                                                                    <th>#</th>
                                                                                                    <th>Examen</th>
                                                                                                    <th>Observation</th>
                                                                                                    <th>résultat</th>
                                                                                                    <th>Fait</th>
                                                                                                    <th>Voir prélèvement</th>

                                                                                                    <th>&nbsp;</th>
                                                                                                    </thead>
                                                                                                    <tbody>
                                                                                                        <?php
                                                                                                        $listExamenRecommand = $controller->getrecommandexamen($_GET['id']);

                                                                                                        if (count($listExamenRecommand) > 0) {
                                                                                                            $count = 0;
                                                                                                            foreach ($listExamenRecommand as $itemExamenRecommand) {
                                                                                                                $count++;
                                                                                                                ?>
                                                                                                                <tr>
                                                                                                                    <td><?= $count ?></td>
                                                                                                                    <td><?= $itemExamenRecommand->examen ?> </td>
                                                                                                                    <td><?= $itemExamenRecommand->obs ?></td>
                                                                                                                    <td><?= $itemExamenRecommand->resultat ?></td>
                                                                                                                    <td><?= $itemExamenRecommand->fait ?></td> 
                                                                                                                    <td><a href="/public/actes_medicaux.php?action=examen&id=<?= $itemExamenRecommand->id_diagnostic ?>&m=voirettiques&examen=<?= $itemExamenRecommand->id ?>">voir etiquette</a></td> 
                                                                                                                    <!--
                                                                                                                    <td><a class="text-danger" href="/controls/control.php?mod=acte&act=doexamen&id=<?= $itemExamenRecommand->id ?>"><i class="glyphicon glyphicon-remove"></i></a></td>-->

                                                                                                                </tr>
                                                                                                                <?php
                                                                                                            }
                                                                                                        }
                                                                                                        ?>
                                                                                                    </tbody>
                                                                                                </table>                                                                    
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>                                                            
                                                                                </form>      
                                                                            </div>                                                    
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>

                                                            <br><br>
                                                        </div>
                                                    </div>


                                                <?php } else {
                                                    ?>
                                                    <h5 class="text-center alert alert-error alert-info alert-dismissable">Aucune information de diagnostique en référence <?php $_GET['id'] ?> n'a été trouvée, vous ne pouvez pas faire un examen... <br><br> <a class="btn btn-grad btn-metis-5" href="/public/actes_medicaux.php?action=listdiagnistic">Cliquez pour rentrer à la liste des diagnstics</a></h5>
                                                    <?php
                                                }
                                                ?>
                                                <div class="row">                                    
                                                </div>

                                            <?php } else {
                                                ?>
                                                <h5 class="text-center alert alert-warning alert-secondary alert-dismissible">Aucune référence diagnostic n'a été renseignée. <br>Si cette erreur persiste, vérifier bien que vous avez passé par la méthode logique pour y arriver et Si non, veuillez contacter MDE Services (IT) pour signaler l'erreur afin de consolider la sécurité du système</h5> 

                                                <?php
                                            }

                                            break; //Fin doExamen

                                        case "voirettiques":

                                            if (isset($_GET['id']) && !empty($_GET['id'])) {
                                                $diagnosticInfo = $controller->getdiagnostic($_GET['id']);
                                                $prelDev = $controller->getPrelevementExamForExam($_GET);

                                                if (count($diagnosticInfo) > 0 && $prelDev != null && count($prelDev) > 0) {
                                                    $diagnosticInfo = $diagnosticInfo[0];
                                                    $prelDev = $prelDev[0];
                                                    $agentPrel = $controlUser->get(['username' => $prelDev->userprev]);
                                                    if ($agentPrel != null && count($agentPrel) > 0) {
                                                        $agentPrel = $agentPrel[0];
                                                    }
                                                    ?>
                                                    <div class="col-lg-12 col-md-12">
                                                        <div class="col-lg-12">
                                                            <div class="panel panel-primary panel-group">
                                                                <div class="panel-heading panel-primary">
                                                                    <h4>REF DIAGNOSTIQUE : <span class="text" style="font-weight: bolder"><?= $diagnosticInfo->id_diagnostic ?></span></h4>
                                                                    <h5>REF ACTE : <span class="text" style="font-weight: bolder">SMGR-<?= $diagnosticInfo->idactepose ?></span></h5>
                                                                    <p><i class="glyphicon glyphicon-time"></i>&nbsp; Diagnistiqué <?= $diagnosticInfo->datediagnostic ?> par : <?= $diagnosticInfo->nomagent . " " . $diagnosticInfo->prenomagent . "(" . $diagnosticInfo->fonction . ")" ?> </p>
                                                                    <p><i class="glyphicon glyphicon-baby-formula"></i>&nbsp; <?= $diagnosticInfo->category ?></p>
                                                                    <p><i class="glyphicon glyphicon-baby-formula"></i>&nbsp; <?= $diagnosticInfo->acte_pose ?></p>
                                                                    <p><a class="btn btn-metis-1 btn-grad" href="/public/actes_medicaux.php?action=view&id=<?= $diagnosticInfo->idactepose ?>"><i class="glyphicon glyphicon-chevron-left"></i> Back</a></p>
                                                                </div>
                                                                <div class="panel-body">
                                                                    <div class="col"><h6>Pour :</h6><hr></div>   
                                                                    <div class="row">
                                                                        <div class="col-lg-3">
                                                                            <div class="wrapImgProfile">
                                                                                <img src="/img/personnel/<?= $diagnosticInfo->filename . "." . $diagnosticInfo->type ?>">
                                                                            </div>
                                                                            <div class="">
                                                                                <br>
                                                                                <a href="/controls/control.php?mod=patient&act=view&id=<?= $diagnosticInfo->idPatient ?>" class="btn btn-success col-lg-12"><span class="glyphicon glyphicon-eye-open"></span> Voir Fiche </a>
                                                                                <a href="/public/actes_medicaux.php?action=examen&m=doprelever&id=<?= $_GET['id'] ?>" style="margin-top: 10px" class="btn btn-success col-lg-12"><span class="glyphicon glyphicon-eye-open"></span> Préléver </a>
                                                                                <br>              
                                                                            </div>
                                                                            <br>
                                                                        </div>
                                                                        <div class="col-lg-9 personne-info">
                                                                            <div class="line-personne-info"><span class="champ">Nom :</span><span class="val-line-personne-info"><?= $diagnosticInfo->nompatient ?></span></div> 
                                                                            <div class="line-personne-info"><span class="champ">Prénom :</span><span class="val-line-personne-info"><?= $diagnosticInfo->prenompatient ?></span></div> 
                                                                            <div class="line-personne-info"><span class="champ">Post-nom :</span><span class="val-line-personne-info"><?= $diagnosticInfo->postnompatient ?></span></div> 
                                                                            <div class="line-personne-info"><span class="champ">Date de naissance :</span><span class="val-line-personne-info"><?= $diagnosticInfo->age ?></span></div> 
                                                                            <div class="line-personne-info"><span class="champ">Etat civil :</span><span class="val-line-personne-info"><?= $diagnosticInfo->etatcivil ?></span></div> 
                                                                        </div>
                                                                    </div>
                                                                    <hr>
                                                                    <div class="col-lg-12">
                                                                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">


                                                                            <div class="col-lg-12">
                                                                                <h2>Détail examen </h2>
                                                                                <hr>
                                                                                <div class="row">
                                                                                    <div class="col-md-4">Examen :</div>
                                                                                    <div class="col-md-8"><?= $prelDev->examen ?> </div>
                                                                                </div>   
                                                                                <div class="row">
                                                                                    <div class="col-md-4">Agent préléveur :</div>
                                                                                    <?php
                                                                                    if ($agentPrel != null) {
                                                                                        ?>
                                                                                        <div class="col-md-8"><?= strtoupper($agentPrel->nom . " " . $agentPrel->prenom) ?> 
                                                                                            <?php
                                                                                            if (isset($agentPrel->matricule)) {
                                                                                                echo '(' . $agentPrel->matricule . ")";
                                                                                            }
                                                                                        }
                                                                                        ?>
                                                                                    </div>
                                                                                </div>   
                                                                                <div class="row">
                                                                                    <div class="col-md-4">Etiquette :</div>
                                                                                    <div class="col-md-8"><?= strtoupper($prelDev->label) ?></div>
                                                                                </div>   
                                                                                <div class="row">
                                                                                    <div class="col-md-4">Date prélèvement :</div>
                                                                                    <div class="col-md-8"> <?= Date::dateToFr($prelDev->date_prelevement) ?></div>
                                                                                </div>   
                                                                                <div class="row">
                                                                                    <div class="col-md-4">Résultat :</div>
                                                                                    <div class="col-md-8"> <?= ($prelDev->resultat) ?></div>
                                                                                </div>   
                                                                            </div>                                                    
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>

                                                            <br><br>
                                                        </div>
                                                    </div>


                                                <?php } else {
                                                    ?>
                                                    <h5 class="text-center alert alert-error alert-info alert-dismissable">Aucune information n'est trouve ou soit le prélèvement n'a pas encore été fait pour suite de processus <br> <a class="btn btn-metis-2" href="/public/actes_medicaux.php?action=examen&m=doexamen&id=<?= $_GET['id'] ?>">Cliquez ici pour rentrer </a></h5>
                                                    <?php
                                                }
                                                ?>
                                                <div class="row">                                    
                                                </div>

                                            <?php } else {
                                                ?>
                                                <h5 class="text-center alert alert-warning alert-secondary alert-dismissible">Aucune référence diagnostic n'a été renseignée. <br>Si cette erreur persiste, vérifier bien que vous avez passé par la méthode logique pour y arriver et Si non, veuillez contacter MDE Services (IT) pour signaler l'erreur afin de consolider la sécurité du système</h5> 

                                                <?php
                                            }

                                            break; //Fin voir etiquette


                                        case "doprelever":

                                            if (isset($_GET['id']) && !empty($_GET['id'])) {
                                                $diagnosticInfo = $controller->getdiagnostic($_GET['id']);
                                                if (count($diagnosticInfo) > 0) {
                                                    $diagnosticInfo = $diagnosticInfo[0];
                                                    ?>
                                                    <div class="col-lg-12 col-md-12">
                                                        <div class="col-lg-12">
                                                            <div class="panel panel-primary panel-group">
                                                                <div class="panel-heading panel-primary">
                                                                    <h4>REF DIAGNOSTIQUE : <span class="text" style="font-weight: bolder"><?= $diagnosticInfo->id_diagnostic ?></span></h4>
                                                                    <h5>REF ACTE : <span class="text" style="font-weight: bolder">SMGR-<?= $diagnosticInfo->idactepose ?></span></h5>
                                                                    <p><i class="glyphicon glyphicon-time"></i>&nbsp; Diagnistiqué <?= $diagnosticInfo->datediagnostic ?> par : <?= $diagnosticInfo->nomagent . " " . $diagnosticInfo->prenomagent . "(" . $diagnosticInfo->fonction . ")" ?> </p>
                                                                    <p><i class="glyphicon glyphicon-baby-formula"></i>&nbsp; <?= $diagnosticInfo->category ?></p>
                                                                    <p><i class="glyphicon glyphicon-baby-formula"></i>&nbsp; <?= $diagnosticInfo->acte_pose ?></p>
                                                                    <p><a class="btn btn-metis-1 btn-grad" href="/public/actes_medicaux.php?action=view&id=<?= $diagnosticInfo->idactepose ?>"><i class="glyphicon glyphicon-chevron-left"></i> Back</a></p>
                                                                </div>
                                                                <div class="panel-body">
                                                                    <div class="col"><h6>Pour :</h6><hr></div>   
                                                                    <div class="row">
                                                                        <div class="col-lg-3">
                                                                            <div class="wrapImgProfile">
                                                                                <img src="/img/personnel/<?= $diagnosticInfo->filename . "." . $diagnosticInfo->type ?>">
                                                                            </div>
                                                                            <div class="">
                                                                                <br>
                                                                                <a href="/controls/control.php?mod=patient&act=view&id=<?= $diagnosticInfo->idPatient ?>" class="btn btn-success col-lg-12"><span class="glyphicon glyphicon-eye-open"></span> Voir Fiche </a>
                                                                                <br>              
                                                                            </div>
                                                                            <br>
                                                                        </div>
                                                                        <div class="col-lg-9 personne-info">
                                                                            <div class="line-personne-info"><span class="champ">Nom :</span><span class="val-line-personne-info"><?= $diagnosticInfo->nompatient ?></span></div> 
                                                                            <div class="line-personne-info"><span class="champ">Prénom :</span><span class="val-line-personne-info"><?= $diagnosticInfo->prenompatient ?></span></div> 
                                                                            <div class="line-personne-info"><span class="champ">Post-nom :</span><span class="val-line-personne-info"><?= $diagnosticInfo->postnompatient ?></span></div> 
                                                                            <div class="line-personne-info"><span class="champ">Date de naissance :</span><span class="val-line-personne-info"><?= $diagnosticInfo->age ?></span></div> 
                                                                            <div class="line-personne-info"><span class="champ">Etat civil :</span><span class="val-line-personne-info"><?= $diagnosticInfo->etatcivil ?></span></div> 
                                                                        </div>
                                                                    </div>
                                                                    <hr>
                                                                    <div class="col-lg-12">
                                                                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                                                            <div class="col-lg-12">
                                                                                <form class="form-horizontal" role="form" method="post" action="/controls/control.php?mod=acte&act=doprelever">                                                        
                                                                                    <div class="form-group">
                                                                                        <input type="hidden" name="iddiagnostic" value="<?= $diagnosticInfo->id_diagnostic ?>" >
                                                                                        <label for="inputEmail3" class="col-sm-2 control-label">Liste des Exa. Recommandés</label>
                                                                                        <div class="col-sm-10">
                                                                                            <select class="form-control" name="examen">
                                                                                                <?php
                                                                                                $listExamen = $controller->getrecommandexamen($_GET['id']);
                                                                                                if (count($listExamen) > 0) {
                                                                                                    foreach ($listExamen as $itemExamen) {
                                                                                                        ?>
                                                                                                        <option value="<?= $itemExamen->id ?>"><?= $itemExamen->examen ?></option>
                                                                                                        <?php
                                                                                                    }
                                                                                                    ?>

                                                                                                    <?php
                                                                                                }
                                                                                                ?>

                                                                                            </select>
                                                                                            <div class="row">
                                                                                                <br>
                                                                                                <div class="col-lg-12">                                                                        
                                                                                                    <textarea class="form-control" name="label" placeholder="Ecrire l'étiquettage du recipiant"></textarea>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="row">
                                                                                                <br>
                                                                                                <div class="col-lg-12">
                                                                                                    <button class="form-control btn btn-metis-3 btn-grad " placeholder="" type="submit">Confirmer </button>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="col-lg-12 viewListExamenRecommand" >
                                                                                                <h5>Liste des examens recommandés</h5>
                                                                                                <hr>
                                                                                                <table class="table">
                                                                                                    <thead>
                                                                                                    <th>#</th>
                                                                                                    <th>Examen</th>
                                                                                                    <th>Observation</th>
                                                                                                    <th>résultat</th>
                                                                                                    <th>Fait</th>
                                                                                                    <th>&nbsp;</th>
                                                                                                    </thead>
                                                                                                    <tbody>
                                                                                                        <?php
                                                                                                        $listExamenRecommand = $controller->getrecommandexamen($_GET['id']);
                                                                                                        if (count($listExamenRecommand) > 0) {
                                                                                                            $count = 0;
                                                                                                            foreach ($listExamenRecommand as $itemExamenRecommand) {
                                                                                                                $count++;
                                                                                                                ?>
                                                                                                                <tr>
                                                                                                                    <td><?= $count ?></td>
                                                                                                                    <td><?= $itemExamenRecommand->examen ?> </td>
                                                                                                                    <td><?= $itemExamenRecommand->obs ?></td>
                                                                                                                    <td><?= $itemExamenRecommand->resultat ?></td>
                                                                                                                    <td><?= $itemExamenRecommand->fait ?></td> 
                                                                                                                    <!--
                                                                                                                    <td><a class="text-danger" href="/controls/control.php?mod=acte&act=doexamen&id=<?= $itemExamenRecommand->id ?>"><i class="glyphicon glyphicon-remove"></i></a></td>-->

                                                                                                                </tr>
                                                                                                                <?php
                                                                                                            }
                                                                                                        }
                                                                                                        ?>
                                                                                                    </tbody>
                                                                                                </table>                                                                    
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>                                                            
                                                                                </form>      
                                                                            </div>                                                    
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>

                                                            <br><br>
                                                        </div>
                                                    </div>


                                                <?php } else {
                                                    ?>
                                                    <h5 class="text-center alert alert-error alert-info alert-dismissable">Aucune information de diagnostique en référence <?php $_GET['id'] ?> n'a été trouvée, vous ne pouvez pas faire un examen... <br><br> <a class="btn btn-grad btn-metis-5" href="/public/actes_medicaux.php?action=listdiagnistic">Cliquez pour rentrer à la liste des diagnstics</a></h5>
                                                    <?php
                                                }
                                                ?>
                                                <div class="row">                                    
                                                </div>

                                            <?php } else {
                                                ?>
                                                <h5 class="text-center alert alert-warning alert-secondary alert-dismissible">Aucune référence diagnostic n'a été renseignée. <br>Si cette erreur persiste, vérifier bien que vous avez passé par la méthode logique pour y arriver et Si non, veuillez contacter MDE Services (IT) pour signaler l'erreur afin de consolider la sécurité du système</h5> 

                                                <?php
                                            }

                                            break; //Fin Prelever




                                        default:
                                            break;
                                    }
                                } else { //Fin $_GET['m'],  donc Affichage de la liste des exames medicaux
                                    ?>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="box">
                                                <header>
                                                    <h5>EXAMEN D'AUJOURD'HUI</h5>
                                                    <div class="toolbar">
                                                        <div class="btn-group">
                                                            <a href="/public/actes_medicaux.php?action=examen&m=newexamen" class="btn btn-sm btn-default minimize-box">
                                                                <i class="glyphicon glyphicon-plus"></i>
                                                            </a>
                                                            <a class="btn btn-metis-3 btn-grad btn-sm "><i class="glyphicon glyphicon-print"></i></a>
                                                            <a class="btn btn-danger btn-sm close-box"><i class="glyphicon glyphicon-search"></i></a>
                                                        </div>
                                                    </div>
                                                </header>
                                                <div class="body" id="trigo" style="height: auto;">
                                                    <?php
                                                    $condition = " WHERE diagnostic.date >= '" . date("Y-m-d") . "' ";
                                                    $allExamen = $controller->getcustomexamen($condition);
                                                    if (count($allExamen) > 0) {
                                                        $count = 0;
                                                        ?>
                                                        <div id="stripedTable" class="body collapse in">
                                                            <table class="table table-striped responsive-table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Réf Diagnostic</th>
                                                                        <th>Medecin </th>
                                                                        <th>N Exam. </th>
                                                                        <th>Acte Med.</th>
                                                                        <th>Date</th>
                                                                        <th>Fait</th>
                                                                        <th>&nbsp;</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    foreach ($allExamen as $item) {
                                                                        $count++
                                                                        ?>                                                                                                        
                                                                        <tr class="">
                                                                            <td><?= $count ?>  </td>
                                                                            <td>
                                                                                <a href="">
                                                                                    <h5><?= $item->id_diagnostic ?> </h5></a>
                                                                            </td>
                                                                            <td><?= $item->nommedecin . " " . $item->prenommedecin ?> </td>
                                                                            <td><?= $item->nExam ?></td>
                                                                            <td><?= $item->acte ?></td>
                                                                            <td><?= Helpers\Date::dateToFr($item->daterecommande) ?></td>
                                                                            <td><?= $item->fait ?></td>
                                                                            <td>
                                                                                <a href="/public/actes_medicaux.php?action=examen&m=doexamen&id=<?= $item->id_diagnostic ?>" class=""><span class="glyphicon glyphicon-th-list"></span></a>
                                                                                <a href="/" class="text-danger"><span class="glyphicon glyphicon-remove"></span></a>
                                                                            </td>
                                                                        </tr> 
                                                                    <?php }
                                                                    ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    <?php } else {
                                                        ?>
                                                        <h2 class="text-center alert alert-info alert-secondary alert-dismissible">Aucun examen enregistré</h2>     
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                            </div><!--Fin list html examen today -->
                                            <div class="box">
                                                <header>
                                                    <h5>TOUS EXAMENS</h5>
                                                    <div class="toolbar">
                                                        <ul class="nav">
                                                            <li>
                                                                <form action="/controls/control.php" method="get" class="form-inline searchform">
                                                                    <div class=" form-group top_search">
                                                                        <div class="input-group">
                                                                            <input type="text" class="form-control input-search-diagnostic" name="q" placeholder="Recherche...">
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
                                                <div class="body" id="trigo" style="height: auto;">
                                                    <?php
                                                    $allExamen = $controller->getcustomexamen();
                                                    if (count($allExamen) > 0) {
                                                        $count = 0;
                                                        ?>
                                                        <div id="stripedTable" class="body collapse in">
                                                            <table class="table table-striped responsive-table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Réf Diagnostic</th>
                                                                        <th>Medecin </th>
                                                                        <th>N Exam. </th>
                                                                        <th>Acte Med.</th>
                                                                        <th>Date</th>
                                                                        <th>Fait</th>
                                                                        <th>&nbsp;</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    foreach ($allExamen as $item) {
                                                                        $count++
                                                                        ?>                                                                                                        
                                                                        <tr class="">
                                                                            <td><?= $count ?>  </td>
                                                                            <td>
                                                                                <a href="">
                                                                                    <h5><?= $item->id_diagnostic ?> </h5></a>
                                                                            </td>
                                                                            <td><?= $item->nommedecin . " " . $item->prenommedecin ?> </td>
                                                                            <td><?= $item->nExam ?></td>
                                                                            <td><?= $item->acte ?></td>
                                                                            <td><?= Helpers\Date::dateToFr($item->daterecommande) ?></td>
                                                                            <td><?= $item->fait ?></td>
                                                                            <td>
                                                                                <a href="/public/actes_medicaux.php?action=examen&m=doexamen&id=<?= $item->id_diagnostic ?>" class=""><span class="glyphicon glyphicon-th-list"></span></a>
                                                                                <a href="/" class="text-danger"><span class="glyphicon glyphicon-remove"></span></a>
                                                                            </td>
                                                                        </tr> 
                                                                    <?php }
                                                                    ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    <?php } else {
                                                        ?>
                                                        <h2 class="text-center alert alert-info alert-secondary alert-dismissible">Aucun examen enregistré</h2>     
                                                        <?php
                                                    }
                                                    ?>
                                                </div>
                                            </div><!--Fin list html examen today -->

                                        </div>
                                    </div>
                                    <?php
                                }//Fin list des examens et FIn GET[m]                                           
                                break; //fin switch action = examen
                            case 'edition':
                                ?>
                                <div class="text-center">               
                                    <ul class="stats_box">
                                        <li>
                                            <div class="sparkline bar_week"></div>
                                            <div class="stat_text">
                                                <strong><?= number_format($counttoday[0]->totalpercu, 2, ",", " ") ?> $</strong>Hopital (Today)
                                                <span class="percent down"> <i class="fa fa-caret-down"></i> <?= $counttoday[0]->npercu ?> </span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="sparkline bar_week"></div>
                                            <div class="stat_text">
                                                <strong><?= number_format($counttoday[0]->totalpercu * $counttoday[0]->tauxapplique, 3, ",", " ") ?> CDF</strong>Hopital (Today)
                                                <span class="percent down"> <i class="fa fa-caret-down"></i> <?= $countmoi[0]->npercu ?></span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="sparkline line_day"></div>
                                            <div class="stat_text">
                                                <strong><?= number_format($countmoi[0]->totalpercu, 2, ",", " ") ?>$</strong>Hopital (Today | Moi)
                                                <span class="percent up"> <i class="fa fa-caret-up"></i> <?= $countmoi[0]->npercu ?></span>
                                            </div>
                                        </li>                           
                                        <li>
                                            <div class="sparkline stacked_month"></div>
                                            <div class="stat_text">
                                                <strong><?= number_format($countMonth[0]->totalpercu, 2, ",", " ") ?>$</strong>Hopital (Mois)
                                                <span class="percent down"> <i class="fa fa-caret-down"></i> <?= $countMonth[0]->npercu ?></span>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <form class="form-inline text-center" action="<?= $_SERVER['PHP_SELF'] . "?action=edition&filtre" ?>" method="post">
                                            <div class="col-9">
                                                <h3>Appliquer le filtre</h3>                             
                                            </div>

                                            <div class="row clearfix clear">
                                                <div class="input-group">
                                                    <label>Debut</label>&nbsp;
                                                    <input type="date" name="start" class="input-mini " value="<?= isset($_POST['start']) ? $_POST['start'] : "" ?>">
                                                </div>
                                                <div class="input-group">
                                                    <label>Limite</label> &nbsp;
                                                    <input type="date" name="end" class="input-mini " value="<?= isset($_POST['end']) ? $_POST['end'] : "" ?>">
                                                </div>
                                                <div class="input-group">
                                                    <label>Agent</label> &nbsp;
                                                    <input type="text" name="agent" class="input-mini " placeholder="Saisir votre matricule" value="<?= isset($_POST['agent']) ? $_POST['agent'] : "" ?>" >
                                                </div>                                    
                                            </div><br>
                                            <div class="row">
                                                <button type="" class="btn btn-grad btn-metis-3" >Rechercher</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <hr>
                                <?php
                                if (isset($_GET['filtre'])) {
                                    if (count($_POST) > 0) {
                                        if (isset($_POST['start']) && !empty($_POST['start']) && Date::isValid(Date::dateToFr($_POST['start'], '%d-%m-%Y'))) {
                                            $start = $_POST['start'];
                                        } else {
                                            $start = date('Y-m') . "-01";
                                        }
                                        if (isset($_POST['end']) && !empty($_POST['end']) && Date::isValid(Date::dateToFr($_POST['end'], '%d-%m-%Y'))) {
                                            $end = $_POST['end'];
                                        } else {
                                            $end = date('Y-m') . date('-t');
                                        }
                                        if (isset($_POST['agent']) && !empty($_POST['agent'])) {
                                            $agent = $_POST['agent'];
                                        }
                                        $condition['where'] = " WHERE (DATE(facture_acte.date_facture) BETWEEN '$start' AND '$end') ";
                                        if (isset($_POST['agent']) && !empty($_POST['agent'])) {
                                            $agent = $_POST['agent'];
                                            $condition['where'] .= " AND facture_acte.id_agent = '$agent'";
                                        }
                                        $factures = $controller->getfacture($condition);
                                        $end = $_POST['end'];
                                    }
                                    ?>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="box">
                                                <header>
                                                    <h5>FILTRE <?= (isset($_POST) && count($_POST) && !empty($_POST['start']) > 0) ? "(" . $_POST['start'] . " ET " . $_POST['end'] . ")" : "" ?></h5>
                                                    <div class="toolbar">                                        
                                                    </div>
                                                </header>
                                                <?php
                                                if (count($factures) > 0) {
                                                    ?>
                                                    <div id="" class="body">
                                                        <div class="col-lg-12">
                                                        </div>
                                                        <div id="stripedTable" class="body collapse in">
                                                            <table class="table table-striped responsive-table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Ref</th>
                                                                        <th>Agent</th>
                                                                        <th>Réel perçu</th>
                                                                        <th>Montant</th>
                                                                        <th>Date</th>
                                                                        <th>&nbsp;</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    $count = 0;
                                                                    $totalpercu = 0;
                                                                    $totalmontant = 0;
                                                                    foreach ($factures as $value) {
                                                                        $totalpercu += $value->percu;
                                                                        $totalmontant += $value->montant;
                                                                        ?>    
                                                                        <tr class="">
                                                                            <td><?= ++$count ?> </td>
                                                                            <td><?= $value->id_acte_pose ?></td> 
                                                                            <td><?= $value->nom . " " . $value->postnom . " " . $value->prenom . "<br>" . $value->libfonction ?></td>
                                                                            <td><?= $value->percu ?></td>                                                    
                                                                            <td><?= $value->montant ?></td>
                                                                            <td><?= Date::dateToFr($value->date_facture) ?></td>
                                                                            <td>                          
                                                                                <a href="" class="danger text-danger"><span class="glyphicon glyphicon-remove"></span></a>
                                                                            </td>
                                                                        </tr>    
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </tbody>     
                                                                <tfoot class="bg-primary">
                                                                    <tr style="font-weight: bolder">                                                    
                                                                        <td colspan="3" style="text-align: left">Total en USD ($)</td>
                                                                        <td><?= $totalpercu ?> USD</td>
                                                                        <td><?= $totalmontant ?> USD</td>
                                                                        <td colspan="2">&nbsp;</td>
                                                                    </tr>
                                                                    <tr style="font-weight: bolder">                                                    
                                                                        <td colspan="3" style="text-align: left">Total en CDF</td>
                                                                        <td><?= $totalpercu * $value->tauxapplique ?> CDF</td>
                                                                        <td><?= $totalmontant * $value->tauxapplique ?> CDF</td>
                                                                        <td colspan="2">&nbsp;</td>
                                                                    </tr>                                                
                                                                </tfoot>
                                                            </table>                                    
                                                        </div>                                    
                                                    </div>
                                                <?php } else {
                                                    ?>
                                                    <div class="row"><div class="col-md-12"><h5 class="text-center alert alert-info alert-secondary alert-dismissible">Aucune facturation établie pour entre le filtre appliqué</h5> </div></div>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                } else {
                                    $start = date('Y-m') . "-01";
                                    $end = date('Y-m') . date('-t');
                                    $condition['where'] = " WHERE DATE(facture_acte.date_facture) BETWEEN '$start' AND '$end'";
                                    $factures = $controller->getfacture($condition);
                                    unset($condition);
                                    $condition['where'] = " WHERE DATE(facture_acte.date_facture) LIKE '%" . $start = date('Y-m-d') . "%'";
                                    $today = $controller->getfacture($condition);
                                    ?>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="box">
                                                <header>
                                                    <h5>AUJOURD'HUI</h5>                                    
                                                </header>
                                                <?php
                                                if (count($today) > 0) {
                                                    ?>
                                                    <div id="" class="body">
                                                        <div class="col-lg-12">
                                                        </div>
                                                        <div id="stripedTable" class="body collapse in">
                                                            <table class="table table-striped responsive-table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Ref</th>
                                                                        <th>Agent</th>
                                                                        <th>Réel perçu</th>
                                                                        <th>Montant</th>
                                                                        <th>Date</th>
                                                                        <th>&nbsp;</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    $count = 0;
                                                                    $totalpercu = 0;
                                                                    $totalmontant = 0;
                                                                    foreach ($today as $value) {
                                                                        $totalpercu += $value->percu;
                                                                        $totalmontant += $value->montant;
                                                                        ?>    
                                                                        <tr class="">
                                                                            <td><?= ++$count ?> </td>
                                                                            <td><?= $value->id_acte_pose ?></td> 
                                                                            <td><?= $value->nom . " " . $value->postnom . " " . $value->prenom . "<br>" . $value->libfonction ?></td>
                                                                            <td><?= $value->percu ?></td>                                                    
                                                                            <td><?= $value->montant ?></td>
                                                                            <td><?= Date::dateToFr($value->date_facture) ?></td>
                                                                            <td>                          
                                                                                <a href="" class="danger text-danger"><span class="glyphicon glyphicon-remove"></span></a>
                                                                            </td>
                                                                        </tr>    
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </tbody>     
                                                                <tfoot class="bg-primary">
                                                                    <tr style="font-weight: bolder">                                                    
                                                                        <td colspan="3" style="text-align: left">Total en USD ($)</td>
                                                                        <td><?= $totalpercu ?> USD</td>
                                                                        <td><?= $totalmontant ?> USD</td>
                                                                        <td colspan="2">&nbsp;</td>
                                                                    </tr>
                                                                    <tr style="font-weight: bolder">                                                    
                                                                        <td colspan="3" style="text-align: left">Total en CDF</td>
                                                                        <td><?= $totalpercu * $value->tauxapplique ?> CDF</td>
                                                                        <td><?= $totalmontant * $value->tauxapplique ?> CDF</td>
                                                                        <td colspan="2">&nbsp;</td>
                                                                    </tr>                                                
                                                                </tfoot>
                                                            </table>                                    
                                                        </div>                                    
                                                    </div>
                                                <?php } else {
                                                    ?>
                                                    <div class="row"><div class="col-md-12"><h5 class="text-center alert alert-info alert-secondary alert-dismissible">Aucune facturation établie aujourd'hui</h5> </div></div>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="box">
                                                <header>
                                                    <h5>MOIS</h5>
                                                    <div class="toolbar">
                                                        <ul class="nav">
                                                            <li>
                                                                <form action="/controls/control.php?mod=acte&amp;act=searchfacture" method="get" class="form-inline searchform" autocomplete="off">
                                                                    <div class=" form-group top_search">
                                                                        <div class="input-group">
                                                                            <input type="text" class="form-control input-search-facture" name="q" placeholder="Recherche...">
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
                                                <?php
                                                if (count($factures) > 0) {
                                                    ?>
                                                    <div id="" class="body">
                                                        <div class="col-lg-12">
                                                        </div>
                                                        <div id="stripedTable" class="body collapse in">
                                                            <table class="table table-striped responsive-table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Ref</th>
                                                                        <th>Agent</th>
                                                                        <th>Réel perçu</th>
                                                                        <th>Montant</th>
                                                                        <th>Date</th>
                                                                        <th>&nbsp;</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    $count = 0;
                                                                    $totalpercu = 0;
                                                                    $totalmontant = 0;
                                                                    foreach ($factures as $value) {
                                                                        $totalpercu += $value->percu;
                                                                        $totalmontant += $value->montant;
                                                                        ?>    
                                                                        <tr class="">
                                                                            <td><?= ++$count ?> </td>
                                                                            <td><?= $value->id_acte_pose ?></td> 
                                                                            <td><?= $value->nom . " " . $value->postnom . " " . $value->prenom . "<br>" . $value->libfonction ?></td>
                                                                            <td><?= $value->percu ?></td>                                                    
                                                                            <td><?= $value->montant ?></td>
                                                                            <td><?= Date::dateToFr($value->date_facture) ?></td>
                                                                            <td>                          
                                                                                <a href="/controls/control.php?mod=acte&act=delfacture&id=<?= $value->idfacture ?>" class="danger text-danger"><span class="glyphicon glyphicon-remove"></span></a>
                                                                            </td>
                                                                        </tr>    
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </tbody>     
                                                                <tfoot class="bg-primary">
                                                                    <tr style="font-weight: bolder">                                                    
                                                                        <td colspan="3" style="text-align: left">Total en USD ($)</td>
                                                                        <td><?= $totalpercu ?> USD</td>
                                                                        <td><?= $totalmontant ?> USD</td>
                                                                        <td colspan="2">&nbsp;</td>
                                                                    </tr>
                                                                    <tr style="font-weight: bolder">                                                    
                                                                        <td colspan="3" style="text-align: left">Total en CDF</td>
                                                                        <td><?= $totalpercu * $value->tauxapplique ?> CDF</td>
                                                                        <td><?= $totalmontant * $value->tauxapplique ?> CDF</td>
                                                                        <td colspan="2">&nbsp;</td>
                                                                    </tr>                                                
                                                                </tfoot>
                                                            </table>                                    
                                                        </div>                                    
                                                    </div>
                                                <?php } else {
                                                    ?>
                                                    <div class="row"><div class="col-md-12"><h5 class="text-center alert alert-info alert-secondary alert-dismissible">Aucune facturation établie pour ce filtre</h5> </div></div>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }

                                break;
                            case 'consulter':
                                if (isset($_GET['id']) && !empty($_GET['id'])) {
                                    $seeActe = $controller->getlistacte($_GET);
                                    if (count($seeActe) > 0) {
                                        ?>
                                        <div class="body">
                                            <div class="col-lg-12" id="tab2">
                                                <form class="form-horizontal" role="form" id="formConsultation" method="POST" action="/controls/control.php?mod=acte&act=addconsultationinfo" autocomplete="off">
                                                    <div class="alert alert-info alert-error">
                                                        <h3>Bienvenue à l'enregistrement des informations de signes vitaux</h3>
                                                        <p>Etant donné une consultation est considérée comme un acte, vous devriez saisir la référence de l'acte initialisé pour ce patient pour enregistrer ses signes vitaux</p>
                                                        <p>Pour vous faciliter la tâche le système vous permet de retrouvez l'acte soit par le nom du patient soit en saisissant directement la référence Acte pour plus de précision</p>
                                                        <p>Attention !!! un meme patient pourrait avoir subi plusieurs actes dans cet établissement, qui justifie que son nom peut revenir zero ou plusieurs fois sur la liste
                                                            <br> Sur ce il ne faut sélectionner que la bonne référence
                                                        </p>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="inputEmail3" class="col-sm-2 control-label">Recherche Acte </label>
                                                        <div class="col-sm-10">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control ui-autocomplete-input refCat" name="acte_medical" class="" placeholder="Recherche Réf Acte/Consultation..." autocomplete="off" value="<?= (isset($_GET['id']) && !empty($_GET['id'])) ? $_GET['id'] : "" ?>">

                                                                <span class="input-group-btn">
                                                                    <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-search"></span></button>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div  class="form-group">
                                                        <label for="inputEmail3" class="col-sm-2 control-label">Patient</label>
                                                        <input type="hidden" name="patient" id="idPatientConsult">
                                                        <div class="col-sm-10 patientInfo" id="patientInfo">
                                                            <p class="alert alert-warning">Aucun patient selectionné</p>
                                                        </div>
                                                    </div>
                                                    <!--
                                                    <div class="form-group">
                                                        <label for="inputEmail3" class="col-sm-2 control-label">Acte médical</label>
                                                        <div class="col-sm-10">
                                                            <select class="form-control" name="acte_medical">
                                                    <?php
                                                    $cle = null;
                                                    if (count($listActes) > 0) {
                                                        foreach ($listActes as $key => $itemActe) {

                                                            if ($cle !== $itemActe->id_cat) {
                                                                ?>
                                                                                                                                                                                                                                        <optgroup label="<?= $itemActe->category ?>" data-category_acte='<?= $itemActe->id_cat ?>'>
                                                                                                                                                                                                                                        <option value="<?= $itemActe->id ?>" data-category_acte='<?= $itemActe->id_cat ?>' data-id='<?= $itemActe->id ?>' ><?= $itemActe->acte ?></option>
                                                                                                                                                                                                                                        
                                                                <?php
                                                                $cle = $itemActe->id_cat;
                                                            } else {
                                                                ?>
                                                                                                                                                                                                                                        <option value="<?= $itemActe->id ?>" data-category_acte='<?= $itemActe->id_cat ?>'  data-id='<?= $itemActe->id ?>'><?= $itemActe->acte ?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                            </select>
                                                        </div>
                                                    </div>-->
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">Observation</label>
                                                        <div class="col-sm-10">
                                                            <textarea class="form-control" placeholder="Anamnese" name="anamnse" rows="3">"<?= (isset($anamnese) ? $anamnese : "") ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="inputPassword3" class="col-sm-2 control-label">Signes vitaux</label>

                                                        <div class="col-sm-10" style="padding-left: 0; padding-right: 0" >
                                                            <div class="" style="height: auto; overflow: auto">
                                                                <div class="col-lg-6">
                                                                    <input type="number" class="form-control" id="inputPassword3" name="poids" placeholder="Poids (Kg)" value="<?= (isset($poids) ? $poids : "") ?>">
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <input type="number" class="form-control" id="inputPassword3" name="taille" placeholder="Taille (cm)" value="<?= (isset($taille) ? $taille : "") ?>">
                                                                </div>
                                                            </div>
                                                            <div class="" style="padding-top: 13px">
                                                                <div class="col-lg-6">
                                                                    <input type="text" class="form-control" id="inputPassword3" name="temperature" placeholder="Température (C°)" value="<?= (isset($temperature) ? $temperature : "") ?>">
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <input type="text" class="form-control" id="inputPassword3" name="tension" placeholder="Tension " value="<?= (isset($tension) ? $tension : "") ?>" >
                                                                </div>
                                                            </div>                                                                    
                                                            <div class="" style="padding-top: 13px">
                                                                <div class="col-lg-6">
                                                                    <input type="text" class="form-control" id="inputPassword3" name="fr" placeholder="F.R" value="<?= (isset($fr) ? $fr : "") ?>">
                                                                </div>   
                                                                <div class="col-lg-6">
                                                                    <input type="text" class="form-control" id="inputPassword3" name="pouls" placeholder="Pouls" value="<?= (isset($pouls) ? $pouls : "") ?>">
                                                                </div> 
                                                            </div>
                                                            <div class="" style="padding-top: 13px">
                                                                <div class="col-lg-6">
                                                                    <input type="text" class="form-control" id="inputPassword3" name="spo" placeholder="SPO2" value="<?= (isset($spo) ? $spo : "") ?>">
                                                                </div>   

                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="form-group">
                                                        <button type="submit" class="form-control btn btn-metis-6 btn-grad"><i class="glyphicon glyphicon-save-file"></i> Enregistrer</button>
                                                    </div>

                                                </form>
                                            </div>
                                        </div>
                                    <?php } else {
                                        ?>
                                        <div class="row"><div class="col-md-12"><h5 class="text-center alert alert-info alert-secondary alert-dismissible">Aucun acte n'a été retrouvé dans le système avec cette référence</h5> </div></div>
                                        <?php
                                    }
                                } else {
                                    ?>
                                    <div class="row"><div class="col-md-12"><h5 class="text-center alert alert-info alert-secondary alert-dismissible">Vous avez sélectionné aucun acte</h5> </div></div>
                                    <?php
                                }
                            default:
                                break;
                        }//fin switch action
                    } else {
                        ?>
                        <div class="text-center">
                            <ul class="stats_box">
                                <li>
                                    <div class="sparkline bar_week"></div>
                                    <div class="stat_text">
                                        <strong>0</strong>Naissances
                                        <span class="percent down"> <i class="fa fa-caret-down"></i> 0</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="sparkline line_day"></div>
                                    <div class="stat_text">
                                        <strong>0</strong>Cesarienne
                                        <span class="percent up"> <i class="fa fa-caret-up"></i> 0</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="sparkline pie_week"></div>
                                    <div class="stat_text">
                                        <strong>0</strong>Mort-nés
                                        <span class="percent"> 0</span>
                                    </div>
                                </li>
                                <li>
                                    <div class="sparkline stacked_month"></div>
                                    <div class="stat_text">
                                        <strong>0</strong>En accouchement
                                        <span class="percent down"> <i class="fa fa-caret-down"></i>0</span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <hr>
                        <!--
                        <div class="text-center">
                            <h2>POSER UN ACTE RAPIDEMENT</h2>
                            <div class="row">
                                <a class="quick-btn" href="#">
                                    <i class="fa fa-bolt fa-2x"></i>
                                    <span>Consultation</span>
                                    <span class="label label-default">2</span>
                                </a>
                                <a class="quick-btn" href="#">
                                    <i class="fa fa-check fa-2x"></i>
                                    <span>Echographie</span>
                                    <span class="label label-danger">2</span>
                                </a>
                                <a class="quick-btn" href="#">
                                    <i class="fa fa-building-o fa-2x"></i>
                                    <span>Chirurgie</span>
                                    <span class="label label-danger">2</span>
                                </a>
                                <a class="quick-btn" href="#">
                                    <i class="fa fa-envelope fa-2x"></i>
                                    <span>Gynécologie </span>
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
                        </div>
                        <hr>-->

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="box">
                                    <header>
                                        <h5>AUJOURD'HUI</h5>
                                    </header>
                                    <div id="" class="body">
                                        <?php
                                        $condition['where'] = " WHERE acte_pose.date >= '" . date("Y-m-d") . "' ";
                                        $todayactes = $controller->getcustomacte($condition);
                                        if (count($todayactes['results']) > 0) {
                                            $count = 0;
                                            $resultsToday = $todayactes['results'];
                                            ?>
                                            <div class="col-lg-12">
                                                <!--<?= composants\Utilitaire::pagination($todayactes['nbPages'], 2, "actes_medicaux.php") ?>-->
                                            </div>
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
                                                        $resultsToday = [];
                                                        foreach ($resultsToday as $item) {
                                                            $count++;
                                                            ?>
                                                            <tr class="">
                                                                <td><?= $count ?></td>
                                                                <td><?= $item->id ?></td>
                                                                <td>
                                                                    <a href="/public/actes_medicaux.php?action=view&id=<?= $item->id ?>"><img src="/img/personnel/<?= $item->filename . "." . $item->type ?>" class="user-profile">
                                                                        <h5><?= $item->nompatient . " " . $item->postnompatient . " " . $item->prenompatient ?></h5></a>
                                                                </td>                                                    
                                                                <td><?= $item->nomagent . " " . $item->prenomagent . "<br>(" . $item->fonctionagent . ")" ?></td>
                                                                <td><?= $item->acte_pose ?></td>                                                    
                                                                <td><?= $item->category ?></td>
                                                                <td><?= Helpers\Date::dateToFr($item->date) ?></td>
                                                                <td>
                                                                    <a href="/public/actes_medicaux.php?action=view&id=<?= $item->id ?>"><span class="glyphicon glyphicon-eye-open"></span></a>                                                       
                                                                    <a href="/public/print.php?id=<?= $item->id ?>" class="text-success printbtn"><i class="glyphicon glyphicon-print"></i></a>
                                                                    <a href="" class="danger text-danger"><span class="glyphicon glyphicon-remove"></span></a></td>

                                                            </tr>        

                                                            <?php
                                                            unset($item);
                                                        }
                                                        ?>


                                                    </tbody>     

                                                </table>

                                            </div>
                                        <?php } else {//Aucun acte posé
                                            ?>
                                            <h4 class="alert alert-dismissible alert-info text-center">Aucun acte n'a été enregistré aujourd'hui</h4>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="box">
                                    <header>
                                        <h5>TOUS LES ACTES</h5>
                                        <div class="toolbar">
                                            <ul class="nav">
                                                <div class="toolbar">
                                                    <ul class="nav">
                                                        <li>
                                                            <form action="/controls/control.php?mod=acte&act=searchactes" method="get" class="form-inline searchform">
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

                                        <div class="col-lg-12">
                                            <!--<?= composants\Utilitaire::pagination($actes['nbPages'], 50, '/public/actes_medicaux.php?') ?>-->
                                        </div>
                                        <div id="stripedTable" class="body collapse in">
                                            <table class="table table-striped responsive-table">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Ref</th>                                                            
                                                        <th>Patient</th>
                                                        <th>Agent</th>
                                                        <th>Acte posé</th>
                                                        <th>Nbr Enf.</th>
                                                        <th>Date</th>
                                                        <th>&nbsp;</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if (count($accouchement) > 0) {
                                                        $count = 0;
                                                        foreach ($accouchement as $item) {
                                                            $count++;
                                                            ?>       
                                                            <tr class="">
                                                                <td><?= $count ?></td>
                                                                <td><?= $item->fk_acte ?></td>
                                                                <td>
                                                                    <a href="/public/patients.php?action=view&id=<?= $item->idPatient ?>"><img src="/img/personnel/<?= $item->filename . "." . $item->type ?>" class="user-profile">
                                                                        <h5><?= $item->nom . " " . $item->prenom . " " . $item->postnom ?></h5></a>
                                                                </td>

                                                                <td><?= $item->nomagent . " " . $item->prenomagent . "<br>(" . $item->fonctionagent . ")" ?></td>
                                                                <td><?= $item->lib ?></td>

                                                                <td><?= $item->nbr ?></td>
                                                                <td><?= Helpers\Date::dateToFr($item->date) ?></td>
                                                                <td>
                                                                    <a href="/public/accouchement.php?action=view&id=<?= $item->fk_acte ?>"><span class="glyphicon glyphicon-eye-open"></span></a>                                                        
                                                                    <a href="/public/print.php?id=<?= $item->idactepose ?>" class="text-success printbtn"><i class="glyphicon glyphicon-print"></i></a>
                                                                    <a href="/controls/control.php?mod=accouchement&act=delacte&id=<?= $item->idactepose ?>" class="danger text-danger"><span class="glyphicon glyphicon-remove"></span></a></td>

                                                            </tr>        

                                                            <?php
                                                        }
                                                    } else {//Aucun acte posé
                                                        ?>
                                                    <div class="row"><div class="col-md-12"><h5 class="text-center alert alert-info alert-secondary alert-dismissible">Aucun acte n'est enregistré</h5> </div></div>
                                                    <?php
                                                }
                                                ?>

                                                </tbody>                                      
                                            </table>                                        
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
            <!-- .well well-small -->
            <div class="well well-small dark">
                <h4 style="padding: 0; margin: 0">TODAY</h4>
                <ul class="list-unstyled">
                    <li></li>
                </ul>
            </div>
            <!-- /.well well-small -->
            <!-- .well well-small -->
            <div class="well well-small dark" id="listTodayPatient">
                <?php
                $listToday = $controller->actetoday();
                if (count($listToday) > 0) {
                    foreach ($listToday as $todaypatient) {
                        ?>
                        <div class="item-patient"><a href="/public/actes_medicaux.php?action=view&id=<?= $todaypatient->id ?>" data-rerfact="<?= $todaypatient->id ?>"> <img style="float: left; margin-right: 5px" src="/img/personnel/<?= $todaypatient->filename . "." . $todaypatient->type ?>" ><span class="nompatient"><?= $todaypatient->nompatient . " " . $todaypatient->prenompatient ?></span><br><span><?= $todaypatient->acte_pose ?> </span><br><span class="refactlist">Ref acte : <?= $todaypatient->id ?></span></a></div>
                                <?php
                            }
                        }
                        ?>


            </div>

        </div>
        <!-- /#right -->
    </div>

    <?php
    include_once ROOT . DS . "squelette" . DS . "footer.php";
    include_once ROOT . DS . "squelette" . DS . "endPage.php";
    ?>          
