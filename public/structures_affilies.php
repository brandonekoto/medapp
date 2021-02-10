<?php
$config = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "config.php";
$config = str_replace("/", DIRECTORY_SEPARATOR, $config);
include_once $config;
if (isset($_SESSION['data'])) {
    extract($_SESSION['data']);
}

$controller = new \controls\Structureaffilie();
$controllerPatient = new \controls\Patient();
$controllerActe = new \controls\Acte();
$listStructure = $controller->getList();
$structureView = null;
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $structureView = $controller->get($_GET['id']);
    if (count($structureView) < 1) {
        $session->setFlash("Structure non trouvée", "danger");
    }
}

if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case "add":
            $filariane = array(
                'Structure Affiliée' => "/public/structures_affilies.php",
                'Liste des structures' => "/public/structures_affilies.php",
                "Création de nouvelle structure" => ""
            );
            $titlePage = "Création de nouvelle structure";
            break;
        case "view" :
            $filariane = array(
                'Structure Affiliée' => "/public/structures_affilies.php",
                'Liste des structures' => "/public/structures_affilies.php",
                "Visualisation " => "",
                $_GET['id'] => ""
            );
            $titlePage = "Visualisation de la structure";
            break;

        case "addacte" :
            $filariane = array(
                'Structure Affiliée' => "/public/structures_affilies.php",
                'Liste des structures' => "/public/structures_affilies.php",
                "Visualisation " => "",
                $_GET['id'] => "",
                "Ajout services " => "",
            );
            $titlePage = "Visualisation de la structure";
            break;
        case "bind" :
            $filariane = array(
                'Structure Affiliée' => "/public/structures_affilies.php",
                'Liste des structures' => "/public/structures_affilies.php",
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
        'Structure Affiliée' => "/public/structures_affilies.php",
        'Liste des structures' => "/public/structures_affilies.php",
    );
    $titlePage = "Liste des structures";
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
                    STRUCTURE AFFILIEE
                </h3>
                <div class="box-options">
                    <a href="/public/structures_affilies.php?action=add" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> </a>
                    <a href="/public/structures_affilies.php?action=del" class="btn btn-primary"><span class="glyphicon glyphicon-print"></span> </a>
                    <a href="/public/structures_affilies.php" class="btn btn-metis-5"><span class="glyphicon glyphicon-list"></span> </a>
                </div>
            </div>
            <br>
            <div class="showmessages">
                <div class="col-lg-12">
                    <?php
                    ($session->flash());
                    ?> 
                </div>

            </div>
            <br>
            <?php
            if (isset($_GET['action'])) {
                switch ($_GET['action']) {
                    case 'add':
                        ?>
                        <div id="div-1" class="body collapse in col-lg-8" aria-expanded="true" style="">
                            <form class="form-horizontal" action="/controls/control.php?mod=structureaffilie&act=add" method="POST" enctype="multipart/form-data">

                                <div class="form-group">
                                    <label for="text1" class="control-label col-lg-4">Nom Responsable</label>

                                    <div class="col-lg-8">
                                        <input type="text" id="text1" name="responsable" placeholder="nom du responsable" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="text1" class="control-label col-lg-4">Raison sociale</label>

                                    <div class="col-lg-8">
                                        <input type="text" id="text1"  name="raisonSociale"placeholder="La raison sociale (Nom de l'entreprise)" class="form-control">
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label for="text1"  class="control-label col-lg-4">Adresse</label>

                                    <div class="col-lg-8">
                                        <textarea type="text" id="text1" name="adresse" placeholder="Adresse physique" class="form-control"></textarea>
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
                                    <div class="col-lg-12">
                                        <button class="btn btn-success">
                                            <span class="glyphicon glyphicon-save">

                                            </span>
                                            Enregistrer
                                        </button>
                                        <button class="btn btn-metis-1">
                                            <span class="glyphicon glyphicon-refresh">

                                            </span>
                                            Annuler
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
                        break;
                    case 'view':
                        if (isset($_GET['id'])) {
                            if (count($structureView) > 0) {
                                $structureView = $structureView[0];
                                //$patients = $controllerPatient->getByStructure($structureView->id);
                                ?>
                                <div class="col-lg-12 col-md-12">
                                    <!--<div class="col-lg-3">
                                        <div class="wrapImgProfile">
                                            <img src="/img/personnel/10981441_932904300076295_8167041328504341445_n.jpg" />
                                        </div>
                                    </div>-->
                                    <div class="col-lg-12">
                                        <table class="table">
                                            <tbody class="tab-content">
                                                <tr>
                                                    <td>
                                                        Raison Sociale :
                                                    </td>
                                                    <td><?= $structureView->raisonsociale ?></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Responsable :
                                                    </td>
                                                    <td><?= $structureView->responsable ?> </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Adresse :
                                                    </td>
                                                    <td><?= $structureView->adresse ?> </td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        Téléphone 
                                                    </td>
                                                    <td><?= $structureView->contact ?> </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                    </div>

                                    <div class="col-lg-12">
                                        <br>
                                        <div class="panel panel-primary panel-group">
                                            <div class="panel-heading panel-primary">
                                                <h4>Actes médicaux</h4>

                                            </div>
                                            <div class="panel-body">
                                                <?php
                                                $structureActes = $controllerActe->getActeOfStructures($_GET['id']);

                                              
                                                if (isset($structureActes) && count($structureActes) > 0) {
                                                    $count = 0;
                                                    ?>
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Catégorie</th>
                                                                <th>Actes</th>
                                                                <th>&nbsp;</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            foreach ($structureActes as $member) {
                                                                $count++;
                                                                ?>                                                
                                                                <tr>
                                                                    <td><?= $count ?></td>
                                                                    <td><?= ucfirst($member->category) ?></td>
                                                                    <td><?= $member->acte ?></td>
                                                                                                                
                                                                    <td hidden=""><a href="" class="text-danger"><span class="glyphicon glyphicon-remove"></span></a></td>
                                                                </tr>
                                                            <?php }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                <?php } else {
                                                    ?>
                                                    <div class="row"><div class="col-md-12"><h2 class="text-center alert alert-info alert-secondary alert-dismissible">Aucun acte/service associé à cette structure</h2> </div></div>
                                                <?php }
                                                ?>

                                            </div>
                                            <div class="panel-footer" >

                                                <a class="btn btn-success" href="/public/structures_affilies.php?action=addacte&id=<?= $_GET['id'] ?>"><span class="glyphicon glyphicon-plus"></span>Ajouter </a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <br>
                                        <div class="panel panel-primary panel-group">
                                            <div class="panel-heading panel-primary">
                                                <h4>Personnel de la structure</h4>

                                            </div>
                                            <div class="panel-body">
                                                <?php
                                                $condition['where'] = " WHERE patient.idStructure ='" . $_GET['id'] . "'";
                                                $members = $controller->getMembers($condition);
                                                if (isset($members['results']) && count($members) > 0) {
                                                    $count = 0;
                                                    ?>
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th><span class="glyphicon glyphicon-user"</th>
                                                                        <th>Sexe</th>
                                                                        <th>Date de naissance</th>                                               
                                                                        <th>&nbsp;</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            foreach ($members['results'] as $member) {
                                                                $count++;
                                                                ?>                                                
                                                                <tr>
                                                                    <td><?= $count ?></td>
                                                                    <td><?= $member->nom . " " . $member->postnom . " " . $member->prenom ?></td>
                                                                    <td><?= $member->sexe ?></td>
                                                                    <td><?= $member->age ?></td>                                               
                                                                    <td hidden=""><a href="" class="text-danger"><span class="glyphicon glyphicon-remove"></span></a><a href=""><span class="glyphicon glyphicon-edit"></span></a><a href=""><span class="glyphicon glyphicon-file"></span></a></td>
                                                                </tr>
                                                            <?php }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                <?php } else {
                                                    ?>
                                                    <div class="row"><div class="col-md-12"><h2 class="text-center alert alert-info alert-secondary alert-dismissible">Aucun membre associé à cette structure</h2> </div></div>
                                                <?php }
                                                ?>

                                            </div>
                                            <div class="panel-footer" hidden="">
                                                <a class="btn btn-info"><span class="glyphicon glyphicon-file"></span>Voir toutes</a>
                                                <a class="btn btn-success"><span class="glyphicon glyphicon-edit"></span>Modifier</a>
                                                <a class="btn btn-success"><span class="glyphicon glyphicon-plus"></span>Ajouter Personnel</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"><br>
                                    <br></div>

                                <?php
                            } else {
                                //Aucune structure vue
                            }
                        } else {//Aucun id structure passé
                        }
                        break; //end view

                    case "edit":


                        break; //End editing
                    case "addacte":

                        if (isset($_GET['id']) && !empty($_GET['id'])) {
                            if ($structureView != null && count($structureView) > 0) {
                                $structureView = $structureView[0];
                                $actes = $controllerActe->getacteprices();
                                ?>
                                <div class="panel panel-primary panel-group">
                                    <div class="panel-heading panel-primary">
                                        <h4>List des actes</h4>

                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="input-group">
                                                    <input type="text" class="form-control ui-autocomplete-input refCat" name="acte_medical" placeholder="Filtrer les actes" autocomplete="off">

                                                    <span class="input-group-btn">
                                                        <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-search"></span></button>
                                                    </span>
                                                </div>
                                                <hr class="clear">

                                                <div class="col-md-12">
                                                    <input type="hidden" name="id" value="<?= $_GET['id'] ?>" id="id_structure"/>
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 100px">#</th>
                                                                <th>Actes</th>

                                                                <th style="width: 100px">choix</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                    <?php
                                                    if ($actes != null && count($actes) > 0) {
                                                        $len = count($actes);
                                                        $cur = null;
                                                        $count = 0;
                                                        foreach ($actes as $key => $value) {
                                                            $count++;
                                                            if ($cur == null) {
                                                                $cur = $value->id_cat;
                                                                ?>
                                                                <h3><?= ucfirst($value->acte) ?></h3>
                                                                <table class="table">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td style="width: 100px"><?= $count ?></td>
                                                                            <td><?= $value->acte ?></td>
                                                                            <td style="width: 100px">
                                                                                <input type="checkbox" class="form-control selected-acte"  data-id='<?= $value->id ?>'>
                                                                            </td>
                                                                        </tr>
                                                                        <?php if ($len == $count) { ?>
                                                                        </tbody>
                                                                    </table>

                                                                    <?php
                                                                }
                                                            } else {
                                                                if ($cur == $value->id_cat) {
                                                                    ?>
                                                                    <tr>
                                                                        <td style="width: 100px"><?= $count ?></td>
                                                                        <td><?= $value->acte ?></td>
                                                                        <td style="width: 100px">
                                                                            <input type="checkbox" class="form-control selected-acte"  data-id='<?= $value->id ?>'>
                                                                        </td>
                                                                    </tr>
                                                                    <?php if ($len == $count) { ?>
                                                                        </tbody>
                                                                        </table>

                                                                        <?php
                                                                    }
                                                                } else {
                                                                    ?>
                                                                    </tbody>
                                                                    </table>

                                                                    <h3><?= ucfirst($value->acte) ?></h3>
                                                                    <table class="table">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td style="width: 100px"><?= $count ?></td>
                                                                                <td><?= $value->acte ?></td>
                                                                                <td style="width: 100px">

                                                                                    <input type="checkbox" class="form-control selected-acte"  data-id='<?= $value->id ?>'>

                                                                                </td>
                                                                            </tr>

                                                                            <?php if ($len == $count) { ?>
                                                                            </tbody>
                                                                        </table>
                                                                        <?php
                                                                    }
                                                                    $cur = $value->id_cat;
                                                                }
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="panel-footer">
                                        <button type="button" class="btn btn-round btn-metis-3" id="confirm-structure-actes">Confirmer</button>
                                    </div>
                                </div>

                            <?php } else {//Structure not found 
                                ?>


                                <p class="alert alert-info">
                                    Aucune structure n'a été trouvée ou elle était supprimée
                                </p>
                                <?php
                            }
                        } else {
                            ?>

                            <p class="alert alert-info">
                                Aucune structure n'a été sélectionnée
                            </p>

                            <?php
                        }
                        break; //End editing 
                        ?>



                    <?php
                }//End switch action
            } else {//Aucune action donc liste des structures
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
                                            <th> <span class="glyphicon glyphicon-th-list"></span>&nbsp;Raison sociale</th>
                                            <th><span class="glyphicon glyphicon-user"></span>&nbsp;Responsable</th>

                                            <th><span class="glyphicon glyphicon-th"></span>&nbsp;Adresse</th>
                                            <th>Telephone</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $count = 0;
                                        foreach ($listStructure['results'] as $key => $structure) {
                                            $count++
                                            ?>
                                            <tr>
                                                <td><?= $count ?></td>
                                                <td><a href="/controls/control.php?mod=structureaffilie&act=view&id=<?= $structure->id ?>" >
                                                        <h5><?= $structure->raisonsociale ?></h5></a></td>
                                                <td><?= $structure->responsable ?></td>
                                                <td><?= $structure->adresse ?></td>
                                                <td><?= $structure->contact ?></td>
                                                <td><a class="text-danger" href="/controls/control.php?mod=structureaffilie&act=del&id=<?= $structure->id ?>"><span class="glyphicon glyphicon-remove"></span></a></td>
                                            </tr>                        
                                        <?php }
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