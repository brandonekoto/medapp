<?php
$config = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "config.php";
$config = str_replace("/", DIRECTORY_SEPARATOR, $config);
include_once $config;
$controller = new \controls\Pharmacy();
$controller->clearbasket();
$controllerActe = new controls\Acte();
$controllerPatient = new controls\Patient();
use Helpers\Date;

if (isset($_SESSION['data'])) {
    extract($_SESSION['data']);
}

$listCategory = $controller->getcategory();
$listConservation = $controller->getconservation();
$listForme = $controller->getforme();

$listUnit = $controller->getunite();
$listAgent = $controller->dao->get("agent");
$listfournisseur = $controller->getfournisseurs();
if (isset($_SESSION['patient']) && count($_SESSION['patient']) > 0) {
    extract($_SESSION['patient']);
}
if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case "add":
            $filariane = array(
                'Pharmacie' => "/public/pharmacy.php",
                'Liste des produits' => "/public/pharmacy.php",
                "Ajout de nouveau produit" => ""
            );
            $titlePage = "Ajout de nouveau produit";
            break;
        case "view" :
            $filariane = array(
                'Pharmacie' => "/public/pharmacy.php",
                'Liste des produits' => "/public/pharmacy.php",
                "Visualisation " => "",
                $_GET['id'] => ""
            );
            $titlePage = "Visualisation du produit";
            break;
        case "edit" :
            $filariane = array(
                'Pharmacie' => "/public/pharmacy.php",
                'Liste des produits' => "/public/pharmacy.php",
                "Modification " => "",
                $_GET['id'] => ""
            );
            $titlePage = "Modification du produit";
            break;

        case "bind" :
            $filariane = array(
                'Pharmacie' => "/public/pharmacy.php",
                'Liste des produits' => "/public/pharmacy.php",
                "Liaison à une structure " => "",
                $_GET['id'] => ""
            );
            $titlePage = "Liaison à une structure";
            break;
        default:
            break;
        case "fournisseur" :
            if (isset($_GET['m'])) {
                switch ($_GET['m']) {
                    case "addfournisseur":
                        $filariane = array(
                            'Pharmacie' => "/public/pharmacy.php",
                            'Liste des fournisseurs' => "/public/pharmacy.php?action=fournisseur",
                            "Ajout du nouveau fournisseur " => "/public/pharmacy.php?action=fournisseur&m=addfournisseur"
                        );
                        $titlePage = "Ajout du nouveau fournisseur";
                        break;
                    case "edit":
                        $filariane = array(
                            'Pharmacie' => "/public/pharmacy.php",
                            'Liste des fournisseurs' => "/public/pharmacy.php?action=fournisseur",
                            "Modification " => "/public/pharmacy.php?action=fournisseur&m=edit",
                            $_GET['id'] => ""
                        );
                        $titlePage = "Modification du fournisseur";
                        break;

                    default:
                        break;
                }
            } else {

                $filariane = array(
                    'Pharmacie' => "/public/pharmacy.php",
                    'Liste des fournisseurs' => "/public/pharmacy.php?action=fournisseur",
                );
                $titlePage = "Fournisseurs";
            }
            break; //Sortie fournisseur
        case "livraison" :
            if (isset($_GET['m'])) {
                switch ($_GET['m']) {
                    case "init":
                        $filariane = array(
                            'Pharmacie' => "/public/pharmacy.php",
                            'Livraison' => "/public/pharmacy.php?action=livraison",
                            "Initialisation livraison" => "/public/pharmacy.php?action=livraison&m=init"
                        );
                        $titlePage = "Initialisation livraison";
                        break;
                    case "addproduct":
                        $filariane = array(
                            'Pharmacie' => "/public/pharmacy.php",
                            'Livraison' => "/public/pharmacy.php?action=livraison",
                            "Ajout des produits " => "/public/pharmacy.php?action=livraison&m=addproduct",
                            $_GET['id'] => ""
                        );
                        $titlePage = "Ajouter des produits à livrer";
                        break;
                    case "listproductlivre":
                        $filariane = array(
                            'Pharmacie' => "/public/pharmacy.php",
                            'Livraison' => "/public/pharmacy.php?action=livraison",
                            "Bon de livraison" => "/public/pharmacy.php?action=livraison&m=listproductlivre",
                            $_GET['id'] => ""
                        );
                        $titlePage = "Visualisation de Bon de livraison";
                        break;

                    default:
                        break;
                }
            } else {

                $filariane = array(
                    'Pharmacie' => "/public/pharmacy.php",
                    'Livraison' => "/public/pharmacy.php?action=fournisseur",
                );
                $titlePage = "Livraison";
            }
            break; //Sortie livraison

        case "approvisionnement" :
            if (isset($_GET['m'])) {
                switch ($_GET['m']) {
                    case "init":
                        $filariane = array(
                            'Pharmacie' => "/public/pharmacy.php",
                            'Approvisionnement' => "/public/pharmacy.php?action=approvisionnement",
                            "Initialisation approvisionnement" => "/public/pharmacy.php?action=approvisionnement&m=init"
                        );
                        $titlePage = "Initialisation Approvisionnement";
                        break;
                    case "addproduct":
                        $filariane = array(
                            'Pharmacie' => "/public/pharmacy.php",
                            'Approvisionnement' => "/public/pharmacy.php?action=approvisionnement",
                            "Ajout des produits " => "/public/pharmacy.php?action=sale&m=addproduct",
                            $_GET['id'] => ""
                        );
                        $titlePage = "Ajouter des produits à approvisionner";
                        break;
                    case "listproductapprov":
                        $filariane = array(
                            'Pharmacie' => "/public/pharmacy.php",
                            'Livraison' => "/public/pharmacy.php?action=approvisionnement",
                            "Bon de livraison" => "/public/pharmacy.php?action=approvisionnement&m=listproductapprov",
                            $_GET['id'] => ""
                        );
                        $titlePage = "Visualisation de Bon de livraison fournisseur";
                        break;
                    default:
                        break;
                }
            } else {

                $filariane = array(
                    'Pharmacie' => "/public/pharmacy.php",
                    'Approvisionnement' => "/public/pharmacy.php?action=fournisseur",
                );
                $titlePage = "Approvisionnement";
            }
            break; //Sortie approvisionnement

        case "sale" :
            if (isset($_GET['id']) && !empty($_GET['id'])) {
                $filariane = array(
                    'Pharmacie' => "/public/pharmacy.php",
                    'Ventes' => "/public/pharmacy.php",
                    "Visualisation Facture " => "",
                    $_GET['id'] => ""
                );
                $titlePage = "Visualisation facture";
            } else {
                $filariane = array(
                    'Pharmacie' => "/public/pharmacy.php",
                    'Ventes' => "/public/pharmacy.php",
                );
                $titlePage = "Ventes";
            }
            break; //sortie sales (ventes)
        case "reporting" :
            $ventes = $controller->getsalesum();
            die();
            if (isset($_GET['filter'])) {
                $filariane = array(
                    'Pharmacie' => "/public/pharmacy.php",
                    'Ventes' => "/public/pharmacy.php",
                    'Reporting' => "/public/pharmacy.php&reporting",
                );
                $titlePage = "Edition des Rapports | Filter";
            } else {
                $filariane = array(
                    'Pharmacie' => "/public/pharmacy.php",
                    'Ventes' => "/public/pharmacy.php",
                    'Reporting' => "/public/pharmacy.php&reporting",
                );
                $titlePage = "Edition des Rapports ";
            }
            break; //sortie reporting (ventes)
        case "category" :
            if (isset($_GET['m'])) {
                switch ($_GET['m']) {
                    case "add":
                        $filariane = array(
                            'Pharmacie' => "/public/pharmacy.php",
                            'Categorie Produit/Médicament' => "/public/pharmacy.php?action=approvisionnement",
                            "Ajout de nouvelle catégorie" => "/public/pharmacy.php?action=category&m=add"
                        );
                        $titlePage = "Ajout de nouvelle catégorie";
                        break;
                    case "edit":
                        $filariane = array(
                            'Pharmacie' => "/public/pharmacy.php",
                            'Categorie Produit/Médicament' => "/public/pharmacy.php?action=approvisionnement",
                            "Modification" => "/public/pharmacy.php?action=category&m=edit",
                            $_GET['id'] => ""
                        );
                        $titlePage = "Modification";
                        break;

                    default:
                        break;
                }
            } else {

                $filariane = array(
                    'Pharmacie' => "/public/pharmacy.php",
                    'Categorie Produit/Médicament' => "/public/pharmacy.php?action=approvisionnement",
                );
                $titlePage = "Liste de toutes les catégories";
            }
            break; //Sortie approvisionnement
    }
} else {
    $filariane = array(
        'Pharmacie' => "/public/pharmacy.php",
        'Liste des produits' => "/public/pharmacy.php",
    );
    $titlePage = "Liste des produits";
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
                    <button type="button" class="btn btn-primary " data-toggle="modal" data-target="#myModal">
                        <span class="glyphicon glyphicon-trash"> Vendre</span>
                    </button>
                    <a href="/public/pharmacy.php?action=add" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> </a>
                    <a href="/public/pharmacy.php?action=print" class="btn btn-primary"><span class="glyphicon glyphicon-print"></span> </a>
                </div>
            </div>
            <div class="showmessages row">
                <div class="col-lg-12">
                    <?php
                    ($session->flash());
                    ?> 
                </div>

            </div>
            <!--
            <div>
                <div class="text-center">
                    <ul class="stats_box">
                        <li>
                            <div class="sparkline bar_week"></div>
                            <div class="stat_text">
                                <strong>3256 $</strong>Aujourd'hui
                                <span class="percent up"> <i class="fa fa-caret-down"></i> 16</span>
                            </div>
                        </li>
                        
                    </ul>
                </div>
                
            </div>-->
            <?php
            if (isset($_GET['action'])) {
                switch ($_GET['action']) {
                    case 'add':
                        ?>
                        <div class="row">
                            <div id="div-1" class="body collapse in col-lg-12" aria-expanded="true" style="">
                                <form class="form-horizontal" action="/controls/control.php?mod=pharmacy&act=add" method="POST" enctype="multipart/form-data" autocomplete="off">                           
                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Image du Produit/Medicament</label>
                                        <div class="col-lg-8">
                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;"></div>
                                                <div>
                                                    <span class="btn btn-default btn-file"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span><input  type="file" name="imgProduit[]" multiple="" ></span>

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="text1" class="control-label col-lg-4">Libellé</label>
                                        <div class="col-lg-8">
                                            <input type="text" id="text1" name="lib" placeholder="Designation"value="<?= (isset($lib)) ? $lib : "" ?>" class="form-control">
                                        </div>
                                    </div>
                                    <!--
                                                <div class="form-group">
                                                    <label for="text1" class="control-label col-lg-4">Quantité stock</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" id="text1"  name="quantite" value="<?= (isset($quantite)) ? $quantite : "" ?>"placeholder="Quantité en stock" class="form-control">
                                                    </div>                                       
                                                </div>-->

                                    <div class="form-group">
                                        <label for="text1" class="control-label col-lg-4">Quantité Alerte</label>
                                        <div class="col-lg-8">
                                            <input type="text" id="text1"  name="qtealert" value="<?= (isset($qtealert)) ? $qtealert : "" ?>"placeholder="Quantité alerte" class="form-control">
                                        </div>                                       
                                    </div>
                                    <div class="form-group">
                                        <label for="text1"  class="control-label col-lg-4">Cout d'achat</label>

                                        <div class="col-lg-8">
                                            <input type="text" id="text1" name="prixachat" value="<?= (isset($prixachat)) ? $prixachat : "" ?>" placeholder="Cout d'achat" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="text1"  class="control-label col-lg-4">Prix vente</label>

                                        <div class="col-lg-8">
                                            <input type="text" id="text1" name="prixvente" value="<?= (isset($prixvente)) ? $prixvente : "" ?>" placeholder="Prix de vente" class="form-control">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Catégorie</label>
                                        <div class="col-lg-8">
                                            <select class="form-control" name="category">
                                                <option value="">Choisir la catégorie</option>
                                                <?php
                                                if (count($listCategory) > 0) {
                                                    foreach ($listCategory as $cat) {
                                                        ?>
                                                        <option value="<?= $cat->idcategory ?>" <?= (isset($category) && $cat->id == $category) ? "selected" : "" ?>><?= $cat->category ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Condition</label>
                                        <div class="col-lg-8">
                                            <select class="form-control" name="conservation">
                                                <option value="">Choisir le mode de condition</option>
                                                <?php
                                                if (count($listConservation) > 0) {
                                                    foreach ($listConservation as $cat) {
                                                        ?>
                                                        <option value="<?= $cat->id ?>" <?= (isset($conservation) && $cat->id == $conservation ) ? "selected" : "" ?>><?= $cat->lib ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Forme</label>
                                        <div class="col-lg-8">
                                            <select class="form-control" name="forme">
                                                <option value="">Choisir forme</option>
                                                <?php
                                                if (count($listForme) > 0) {
                                                    foreach ($listForme as $cat) {
                                                        ?>
                                                        <option value="<?= $cat->id ?>" <?= (isset($forme) && $cat->id == $forme) ? "selected" : "" ?>><?= $cat->lib ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Unité cons.</label>
                                        <div class="col-lg-8">
                                            <select class="form-control" name="unite">
                                                <option value="">Choisir l'unité de consommation</option>
                                                <?php
                                                if (count($listUnit) > 0) {
                                                    foreach ($listUnit as $cat) {
                                                        ?>
                                                        <option value="<?= $cat->id ?>" <?= (isset($unite) && $cat->id == $unite) ? "selected" : "" ?>><?= $cat->lib ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="text1"  class="control-label col-lg-4">Valeur/Unite</label>

                                        <div class="col-lg-8">
                                            <input type="text" id="text1" name="valunite" value="<?= (isset($valunite)) ? $valunite : "" ?>" placeholder="Valeur par unité" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="text1"  class="control-label col-lg-4">Date de fabrication</label>

                                        <div class="col-lg-8">
                                            <input type="date" id="text1" name="dateFab" value="<?= (isset($dateFab)) ? $dateFab : "" ?>" placeholder="Date de naissance" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="text1"  class="control-label col-lg-4">Date d'expiration</label>

                                        <div class="col-lg-8">
                                            <input type="date" id="text1" name="dateExp" value="<?= (isset($dateFab)) ? $dateFab : "" ?>" placeholder="Date de naissance" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="text1"  class="control-label col-lg-4">Code bar</label>

                                        <div class="col-lg-8">
                                            <input type="text" id="text1" name="codebar" value="<?= (isset($codebar)) ? $codebar : "" ?>" placeholder="Code bar" class="form-control">
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
                        </div>

                        <?php
                        break; //Sortie $_GET['action']= add

                    case 'view':
                        ?>
                        <?php
                        if (isset($_GET['id']) && !empty($_GET['id']) > 0) {
                            $condition['where'] = " WHERE produit.id ='" . $_GET['id'] . "'";

                            $prod = $controller->getproduct($condition);
                            //var_dump($prod);
                            if (count($prod['results']) > 0) {
                                $prod = $prod['results'][0];
                                ?>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12">
                                        <div class="col-lg-3">
                                            <div class="wrapImgProfile">
                                                <img src="/img/produit/<?= $prod->filename . "." . $prod->type ?>" /><br>
                                                <div class="refproduit"><?= $prod->id ?></div>
                                            </div>
                                            <div class="">
                                                <br>
                                                <a href="/public/pharmacy.php?action=edit&id=<?= $prod->id ?>" class="btn btn-success"><span class="glyphicon glyphicon-edit"></span>Modifier </a>
                                                <a href="/controls/control.php?mod=pharmacy&act=statprod&id=<?= $prod->id ?>" class="btn btn-success"><span class="glyphicon glyphicon-print"></span> </a>
                                                <a href="/controls/control.php?mod=pharmacy&act=del&id=<?= $prod->id ?>" class="btn btn-metis-1"><span class="glyphicon glyphicon-remove"></span> </a>                               
                                                <br>              
                                            </div>
                                            <br>
                                        </div>                       
                                        <div class="col-lg-9 personne-info">
                                            <div class="line-personne-info"><span class="champ">Designation :</span><span class="val-line-personne-info"><?= $prod->lib ?></span></div> 
                                            <div class="line-personne-info"><span class="champ">Catégorie :</span><span class="val-line-personne-info"><?= $prod->category ?></span></div> 
                                            <div class="line-personne-info"><span class="champ">Conditionnement :</span><span class="val-line-personne-info"><?= $prod->libconservation ?></span></div> 
                                            <div class="line-personne-info"><span class="champ">Forme :</span><span class="val-line-personne-info"><?= $prod->forme ?></span></div>
                                            <div class="line-personne-info"><span class="champ">Unité de consommation :</span><span class="val-line-personne-info"><?= $prod->libunite ?></span></div> 
                                            <div class="line-personne-info"><span class="champ">Quantité en stock :</span><span class="val-line-personne-info"><?= $prod->quantite ?></span></div>
                                            <div class="line-personne-info"><span class="champ">Quantité alerte :</span><span class="val-line-personne-info"><?= $prod->qtealert ?></span></div>
                                            <div class="line-personne-info"><span class="champ">Prix unitaire vente:</span><span class="val-line-personne-info"><?= $prod->prixvente ?>$</span></div>
                                            <div class="line-personne-info"><span class="champ">Cout d'achat unitaire :</span><span class="val-line-personne-info"><?= $prod->prixachat ?>$</span></div>
                                            <div class="line-personne-info"><span class="champ">Date de fabrication :</span><span class="val-line-personne-info"><?= Date::dateToFr($prod->dateFab, 'Le %d-%m-%Y') ?></span></div>
                                            <div class="line-personne-info"><span class="champ">Date d'expiration :</span><span class="val-line-personne-info"><?= Date::dateToFr($prod->dateExp, 'Le %d-%m-%Y') ?></span></div>


                                        </div>

                                    </div>
                                </div>
                                <div class="clearfix"><br>
                                    <br></div>                    

                            <?php } else {
                                ?>
                                <div class="row"><div class="col-md-12"><h5 class="text-center alert alert-info alert-secondary alert-dismissible">Aucun produit n'a été retrouvé dans le système avec cette référence</h5> </div></div>
                                <?php
                            }
                        } else {
                            ?>
                            <div class="row"><div class="col-md-12"><h5 class="text-center alert alert-warning alert-secondary alert-dismissible">Aucun produit n'a été sélectionné</h5> </div></div>
                            <?php
                        }
                        break; //Sortie $_GET['action']= view
                    case "edit":
                        if (isset($_GET['id']) && !empty($_GET['id'])) {
                            $condition['where'] = " WHERE produit.id = '" . $_GET['id'] . "'";
                            $produit = $controller->product(['id' => $_GET['id']]);
                            if (count($produit) > 0) {
                                $produit = $produit[0];
                                ?>
                                <div class="row">
                                    <div id="div-1" class="body collapse in col-lg-12" aria-expanded="true" style="">
                                        <form class="form-horizontal" action="/controls/control.php?mod=pharmacy&act=edit" method="POST" enctype="multipart/form-data" autocomplete="off">                           

                                            <div class="form-group">
                                                <label for="text1" class="control-label col-lg-4">Libellé</label>
                                                <div class="col-lg-8">
                                                    <input type="text" id="text1" name="lib" placeholder="Designation"value="<?= (isset($lib)) ? $lib : $produit->lib ?>" class="form-control">
                                                </div>
                                            </div>                  
                                            <div class="form-group">
                                                <label for="text1" class="control-label col-lg-4">Quantité Alerte</label>
                                                <div class="col-lg-8">
                                                    <input type="text" id="text1"  name="qtealert" value="<?= (isset($quantite)) ? $quantite : $produit->qtealert ?>"placeholder="Quantité alerte" class="form-control">
                                                </div>                                       
                                            </div>
                                            <div class="form-group">
                                                <label for="text1"  class="control-label col-lg-4">Cout d'achat</label>
                                                <div class="col-lg-8">
                                                    <input type="text" id="text1" name="prixachat" value="<?= (isset($prixachat)) ? $prixachat : $produit->prixachat ?>" placeholder="Cout d'achat" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="text1"  class="control-label col-lg-4">Prix vente</label>

                                                <div class="col-lg-8">
                                                    <input type="text" id="text1" name="prixvente" value="<?= (isset($prixvente)) ? $prixvente : $produit->prixvente ?>" placeholder="Prix de vente" class="form-control">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-lg-4">Catégorie</label>

                                                <div class="col-lg-8">
                                                    <select class="form-control" name="category">
                                                        <option value="">Choisir la catégorie</option>
                                                        <?php
                                                        if (count($listCategory) > 0) {
                                                            foreach ($listCategory as $cat) {
                                                                ?>
                                                                <option value="<?= $cat->idcategory ?>" <?= ($cat->idcategory == $produit->category) ? "selected" : "" ?>><?= $cat->category ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>                
                                            <div class="form-group">
                                                <label class="control-label col-lg-4">Condition</label>
                                                <div class="col-lg-8">
                                                    <select class="form-control" name="conservation">
                                                        <option value="">Choisir le mode de condition</option>
                                                        <?php
                                                        if (count($listConservation) > 0) {
                                                            foreach ($listConservation as $cat) {
                                                                ?>
                                                                <option value="<?= $cat->id ?>" <?= (isset($conservation) && $cat->id == $conservation ) || ( $cat->id == $produit->idconservation ) ? "selected" : "" ?>><?= $cat->lib ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-lg-4">Forme</label>
                                                <div class="col-lg-8">
                                                    <select class="form-control" name="forme">
                                                        <option value="">Choisir forme</option>
                                                        <?php
                                                        if (count($listForme) > 0) {
                                                            foreach ($listForme as $cat) {
                                                                ?>
                                                                <option value="<?= $cat->id ?>" <?= (isset($forme) && $cat->id == $forme) || ($produit->idforme == $cat->id) ? "selected" : "" ?>><?= $cat->lib ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-lg-4">Unité cons.</label>
                                                <div class="col-lg-8">
                                                    <select class="form-control" name="unite">
                                                        <option value="">Choisir l'unité de consommation</option>
                                                        <?php
                                                        if (count($listUnit) > 0) {
                                                            foreach ($listUnit as $cat) {
                                                                ?>
                                                                <option value="<?= $cat->id ?>" <?= (isset($unite) && $cat->id == $unite) || ( $cat->id == $produit->idunite) ? "selected" : "" ?>><?= $cat->lib ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="text1"  class="control-label col-lg-4">Valeur/Unite</label>

                                                <div class="col-lg-8">
                                                    <input type="text" id="text1" name="valunite" value="<?= (isset($valunite)) ? $valunite : (isset($produit->valunite)) ? $produit->valunite : "" ?>" placeholder="Valeur par unité" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="text1"  class="control-label col-lg-4">Date de fabrication</label>

                                                <div class="col-lg-8">
                                                    <input type="date" id="text1" name="dateFab" value="<?= (isset($dateFab)) ? $dateFab : $produit->dateFab ?>" placeholder="Date de naissance" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="text1"  class="control-label col-lg-4">Date d'expiration</label>

                                                <div class="col-lg-8">
                                                    <input type="date" id="text1" name="dateExp" value="<?= (isset($dateFab)) ? $dateFab : $produit->dateExp ?>" placeholder="Date de naissance" class="form-control">
                                                </div>
                                            </div>
                                            <input type="hidden" value="<?= $produit->id ?>" name="idproduit">
                                            <div class="form-group">
                                                <label for="text1"  class="control-label col-lg-4">Code bar</label>

                                                <div class="col-lg-8">
                                                    <input type="text" id="text1" name="codebar" value="<?= (isset($codebar)) ? $codebar : $produit->codebar ?>" placeholder="Le code bar" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-lg-12">
                                                    <button class="btn btn-success">
                                                        <span class="glyphicon glyphicon-save">                                                         
                                                        </span> 
                                                        Modifier
                                                    </button>
                                                </div>
                                            </div>
                                            <br>
                                            <br>
                                            <!-- /.form-group -->

                                            <!-- /.form-group -->
                                        </form>
                                    </div>
                                </div>
                            <?php } else {
                                ?>
                                <div class="row"><div class="col-md-12"><h2 class="text-center alert alert-info alert-secondary alert-dismissible">Aucun produit enregistré avec cette référence</h2> </div></div>
                                <?php
                            }
                        } else {
                            ?>
                            <div class="row"><div class="col-md-12"><h2 class="text-center alert alert-info alert-secondary alert-dismissible">Aucun produit n'a été sélectionné<h2> </div></div>
                                            <?php
                                        }
                                        break;
                                    case "fournisseur":
                                        if (isset($_GET['m']) && !empty($_GET['m'])) {
                                            switch ($_GET['m']) {
                                                case "addfournisseur":
                                                    ?>
                                                    <div class="row">
                                                        <div id="div-1" class="body collapse in col-lg-12" aria-expanded="true" style="">
                                                            <form class="form-horizontal" action="/controls/control.php?mod=pharmacy&act=addfournisseur" method="POST" enctype="multipart/form-data" autocomplete="off">

                                                                <div class="form-group">
                                                                    <label for="text1" class="control-label col-lg-4">Nom fournisseur</label>

                                                                    <div class="col-lg-8">
                                                                        <input type="text" id="" name="nomfournisseur" placeholder="Nom du fournisseur"value="<?= (isset($nomfournisseur)) ? $nomfournisseur : "" ?>" class="form-control">
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="text1"  class="control-label col-lg-4">Téléphone</label>

                                                                    <div class="col-lg-8">
                                                                        <input type="text" id="" name="tel" value="<?= (isset($tel)) ? $tel : "" ?>" placeholder="Téléphone du fournisseur" class="form-control">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="text1"  class="control-label col-lg-4">Email</label>

                                                                    <div class="col-lg-8">
                                                                        <input type="email" id="" name="email" value="<?= (isset($email)) ? $email : "" ?>" placeholder="Email du fournisseur" class="form-control">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="text1"  class="control-label col-lg-4">Adresse</label>

                                                                    <div class="col-lg-8">
                                                                        <textarea type="adresse" id="" name="adresse" placeholder="Adresse du fournisseur" class="form-control"><?= (isset($adresse)) ? $adresse : "" ?>s</textarea>
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
                                                    </div>
                                                    <?php
                                                    break; //sortie addfournisseur
                                                case "edit":
                                                    if (isset($_GET['id']) && !empty($_GET['id'])) {
                                                        $condition['where'] = " WHERE id='" . $_GET['id'] . "'";
                                                        $fournisseur = $controller->getfournisseurs($condition);
                                                        if (count($fournisseur) > 0) {
                                                            ?>
                                                            <div class="row">
                                                                <div id="div-1" class="body collapse in col-lg-12" aria-expanded="true" style="">
                                                                    <form class="form-horizontal" action="/controls/control.php?mod=pharmacy&act=addfournisseur" method="POST" enctype="multipart/form-data" autocomplete="off">

                                                                        <div class="form-group">
                                                                            <label for="text1" class="control-label col-lg-4">Nom fournisseur</label>
                                                                            <div class="col-lg-8">
                                                                                <input type="text" id="" name="nomfournisseur" placeholder="Nom du fournisseur"value="<?= (isset($nomfournisseur)) ? $nomfournisseur : "" ?>" class="form-control">
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="text1"  class="control-label col-lg-4">Téléphone</label>

                                                                            <div class="col-lg-8">
                                                                                <input type="text" id="" name="tel" value="<?= (isset($tel)) ? $tel : "" ?>" placeholder="Téléphone du fournisseur" class="form-control">
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="text1"  class="control-label col-lg-4">Email</label>

                                                                            <div class="col-lg-8">
                                                                                <input type="email" id="" name="email" value="<?= (isset($email)) ? $email : "" ?>" placeholder="Email du fournisseur" class="form-control">
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="text1"  class="control-label col-lg-4">Adresse</label>

                                                                            <div class="col-lg-8">
                                                                                <textarea type="adresse" id="" name="adresse" placeholder="Adresse du fournisseur" class="form-control"><?= (isset($adresse)) ? $adresse : "" ?>s</textarea>
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
                                                            </div>

                                                        <?php } else {
                                                            ?>
                                                            <div class="col-md-12"><h2 class="text-center alert alert-info alert-secondary alert-dismissible">Aucun fournisseur n'a été enregistré avec cette référence</h2> </div>
                                                            <?php
                                                        }
                                                    } else {
                                                        ?>

                                                        <div class="col-md-12"><h2 class="text-center alert alert-info alert-secondary alert-dismissible">Aucun fournisseur n'a été sélectionné pour l'éditer</h2> </div>

                                                        <?php
                                                    }
                                                    ?>

                                                    <?php
                                                    break; //edit
                                                default:
                                                    break;
                                            }
                                        } else {
                                            $listFournisseurs = $controller->getfournisseurs();
                                            ?>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="box">
                                                        <header>
                                                            <h5>TOUS LES FOURNISSEURS</h5>
                                                            <div class="toolbar">
                                                                <ul class="nav">
                                                                    <li>
                                                                        <a href="/public/pharmacy.php?action=fournisseur&m=addfournisseur">
                                                                            <i class="glyphicon glyphicon-plus"></i>&nbsp; Ajouter fournisseur </a>
                                                                    </li>
                                                                    <li>
                                                                        <form action="/controls/control.php?mod=acte&amp;act=searchactes" method="get" class="form-inline searchform" autocomplete="off">
                                                                            <div class=" form-group top_search">
                                                                                <div class="input-group">
                                                                                    <input type="text" class="form-control input-search-fournirsseur" name="q" placeholder="Recherche...">
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
                                                                if (count($listFournisseurs) > 0) {
                                                                    $count = 0;
                                                                    ?>
                                                                    <table class="table table-striped responsive-table">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>#</th>
                                                                                <th>Code Fournisseur</th>                                                            
                                                                                <th>Nom</th>
                                                                                <th>Adresse</th>
                                                                                <th>Email</th>
                                                                                <th>Téléphone</th>
                                                                                <th>&nbsp;</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php
                                                                            foreach ($listFournisseurs as $fournisseur) {
                                                                                $count++;
                                                                                ?>
                                                                                <tr class="">
                                                                                    <td><?= $count ?> </td>
                                                                                    <td><?= $fournisseur->id ?></td>
                                                                                    <td>                                                                                
                                                                                        <h5><?= $fournisseur->nomfournisseur ?></h5>
                                                                                    </td>
                                                                                    <td><?= $fournisseur->adresse ?></td>
                                                                                    <td><?= $fournisseur->email ?></td> 
                                                                                    <td><?= $fournisseur->tel ?></td> 

                                                                                    <td>
                                                                                        <a href="/public/actes_medicaux.php?action=fournisseur&m=edit&=<?= $fournisseur->id ?>" class="danger text-danger"><span class="glyphicon glyphicon-edit"></span></a>
                                                                                        <a href="/controls/control.php?mod=pharmacy&act=delfournisseur&id=<?= $fournisseur->id ?>" class="danger text-danger"><span class="glyphicon glyphicon-remove"></span></a>
                                                                                    </td>

                                                                                </tr>        
                                                                                <?php
                                                                            }
                                                                            ?>
                                                                        </tbody>     

                                                                    </table>
                                                                <?php } else {
                                                                    ?>
                                                                    <div class="col-md-12"><h2 class="text-center alert alert-info alert-secondary alert-dismissible">Aucun fournisseur enregistré</h2> </div>
                                                                <?php }
                                                                ?>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        break; //Sortie fournisseur
                                    case "livraison":
                                        if (isset($_GET['m']) && !empty($_GET['m'])) {
                                            switch ($_GET['m']) {
                                                case "init":
                                                    ?>
                                                    <div class="row">
                                                        <div id="div-1" class="body collapse in col-lg-8 col-md-8" aria-expanded="true" style="">
                                                            <div class='panel panel-primary'>
                                                                <div class='panel-heading panel-primary'>Formulaire initialiser la livraison</div>
                                                                <div class='panel-body'>
                                                                    <form class="form-horizontal" id="formLivraison" action="/controls/control.php?mod=pharmacy&act=initLivraison" method="POST" enctype="multipart/form-data" autocomplete="off">                           
                                                                        <div class="form-group">
                                                                            <label class="control-label col-lg-4">Destination</label>
                                                                            <div class="col-lg-8">
                                                                                <select class="form-control selectdestination" name="selectdestination" >                
                                                                                    <option value="1">Patient</option>
                                                                                    <option value="2">Service|labo</option>
                                                                                </select>
                                                                                <input type="hidden" name="taux" value="<?= $_SESSION['TAUX'] ?>"/>
                                                                            </div>

                                                                        </div>            
                                                                        <div class="form-group">
                                                                            <label class="control-label col-lg-4">Service/Agent</label>
                                                                            <div class="col-lg-8">
                                                                                <select class="form-control" name="idagent">                
                                                                                    <?php
                                                                                    if (count($listAgent) > 0) {
                                                                                        foreach ($listAgent as $agent) {
                                                                                            ?>
                                                                                            <option value="<?= $agent->id ?>"><?= $agent->nom . " " . $agent->postnom . " " . $agent->prenom . " (" . $agent->fonction . ")" ?></option>
                                                                                            <?php
                                                                                        }
                                                                                    }
                                                                                    ?>
                                                                                </select>
                                                                                <input type="hidden" name="taux" value="<?= $_SESSION['TAUX'] ?>"/>
                                                                            </div>

                                                                        </div>    

                                                                        <div class="form-group searchpatientforlivraison" >
                                                                            <label for="inputEmail3" class="col-sm-4 control-label">Recherche Patient/Acte </label>
                                                                            <div class="col-sm-8">
                                                                                <div class="input-group">
                                                                                    <input type="text" class="form-control ui-autocomplete-input refCat" name="acte_medical" class="" placeholder="Recherche Réf Acte/Consultation..." autocomplete="off">

                                                                                    <span class="input-group-btn">
                                                                                        <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-search"></span></button>
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>  
                                                                        <div  class="form-group showselectedpatientforlivraison">
                                                                            <label for="inputEmail3" class="col-sm-2 control-label">Patient</label>
                                                                            <input type="hidden" name="patient" id="idPatientConsult">
                                                                            <div class="col-sm-10 patientInfo" id="patientInfo">
                                                                                <p class="alert alert-warning">Aucun patient selectionné</p>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="control-label col-lg-4">Observation</label>
                                                                            <div class="col-lg-8">
                                                                                <textarea class="form-control " name="observation" rows="6"  placeholder="Veuillez écrire une observation s'il y en existe"> </textarea>
                                                                              
                                                                            </div>

                                                                        </div>   
                                                                        <hr>
                                                                        <div class="form-group">
                                                                            <div class="col-lg-12">
                                                                                <button class="btn btn-success">
                                                                                    <span class="glyphicon glyphicon-plus">

                                                                                    </span>
                                                                                    Ajouter les produits
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                        <br>
                                                                        <br>
                                                                        <!-- /.form-group -->

                                                                        <!-- /.form-group -->
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="panel panel-primary">
                                                                <div class="panel-heading panel-primary">Autres menus</div>
                                                                <div class="panel-body">
                                                                    <ul class="list-group">
                                                                        <li class="list-group-item">Voir produits</li>
                                                                        <li class="list-group-item">Approvisionnement</li>
                                                                        <li class="list-group-item">Ventes</li>
                                                                        
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <?php
                                                    break; //Sortie init
                                                case 'addproduct':
                                                    if (isset($_GET['id']) && !empty($_GET['id'])) {
                                                        $condition['where'] = " WHERE livraison.id_livraison = '" . $_GET['id'] . "'";
                                                        $refLivraison = $controller->getlivraison($condition);
                                                        if (count($refLivraison) > 0) {
                                                            $refLivraison = $refLivraison[0]
                                                            ?>
                                                            <div class="">

                                                                <div class="col-lg-12">
                                                                    <div class="">
                                                                        <div class="alert alert-info alert-error">
                                                                            <h3>Merci d'initialiser le processus de Livraison</h3>
                                                                            <p>Vous devriez maintenant ajouter les produits que vous voulez livrer à un agent de Service </p>
                                                                            <p>Notez bien que le produit doit exister en amont. Si non, veuillez procéder à l'ajout de produit dans le système puis revenez pour l'ajouter à l'approvisionnement</p>
                                                                        </div>
                                                                        <form class="form-horizontal" role="form" id="formSearchProduct" action="/controls/control.php?mod=pharmacy&act=addproductlivraison&id=<?= $_GET['id'] ?>" method="POST" autocomplete="off">
                                                                            <div class="panel">
                                                                                <div class="panel-heading">
                                                                                    <h5>Référence : <?= $refLivraison->id_livraison ?></h5>                                               
                                                                                    <h5>Date : <?= Date::dateToFr($refLivraison->datelivraison, "Le %d-%m-%Y") ?></h5>
                                                                                    <h5>TAUX APPLIQUE : <?= $refLivraison->tauxapplique ?></h5>  
                                                                                    <hr>
                                                                                </div>
                                                                                <div class="panel-body" style="padding: 0">
                                                                                    <div class="col-lg-5">
                                                                                        <div class="form-group">
                                                                                            <label for="inputEmail3" class="col-sm-2 control-label">Produit</label>
                                                                                            <div class="col-sm-10">
                                                                                                <input class="searchproduct form-control" type="search" name="product" placeholder="Recherche product par Identifiant, désignation"><div class="wrapAutocompleListe" style="margin-top: 0px; display: none;"><ul><li class="item-suggestion" data-patient="13"><img src="/img/personnel/avatar.jpg"><div class="item-suggestion-data">Nyangs Chris<p>Age : 2001-09-04</p><p>Sexe : F</p><p>Type : 2</p></div></li><li class="item-suggestion" data-patient="12"><img src="/img/personnel/zF650.721.jpeg"><div class="item-suggestion-data">Nzola Melissa<p>Age : 2015-06-17</p><p>Sexe : F</p><p>Type : 0</p></div></li><li class="item-suggestion" data-patient="11"><img src="/img/personnel/zF613.481.jpeg"><div class="item-suggestion-data">Brandon Brandon<p>Age : 2019-04-20</p><p>Sexe : F</p><p>Type : 0</p></div></li><li class="item-suggestion" data-patient="5"><img src="/img/personnel/avatar.jpg"><div class="item-suggestion-data">lutumba Henoc<p>Age : 22</p><p>Sexe : M</p><p>Type : 1</p></div></li><li class="item-suggestion" data-patient="4"><img src="/img/personnel/avatar.jpg"><div class="item-suggestion-data">munia deborah<p>Age : 16</p><p>Sexe : F</p><p>Type : 1</p></div></li><li class="item-suggestion" data-patient="3"><img src="/img/personnel/avatar.jpg"><div class="item-suggestion-data">mukwamasela beni<p>Age : 19</p><p>Sexe : M</p><p>Type : 0</p></div></li><li class="item-suggestion" data-patient="2"><img src="/img/personnel/avatar.jpg"><div class="item-suggestion-data">lutumba adan<p>Age : 12</p><p>Sexe : M</p><p>Type : 0</p></div></li><li class="item-suggestion" data-patient="1"><img src="/img/personnel/avatar.jpg"><div class="item-suggestion-data">munia deborah<p>Age : 16</p><p>Sexe : F</p><p>Type : 1</p></div></li></ul> </div><div class="wrapAutocompleListe" style="margin-top: 0px; display: none;"><ul></ul> </div>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="form-group" id="product">
                                                                                            <div class="col-sm-2">

                                                                                            </div>
                                                                                            <div class="col-sm-10 patientInfo" id="productInfo">
                                                                                                <p class="alert alert-warning">Aucun Produit selectionné</p>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label for="inputEmail3" class="col-sm-2 control-label">Quantité </label>
                                                                                            <div class="col-sm-10">
                                                                                                <input class="form-control" type="number" name="quantite" placeholder="La quantité à livrer" value="<?= isset($quantite) ? $quantite : "" ?>">
                                                                                            </div>
                                                                                        </div>                                                   
                                                                                        <div class="form-group">
                                                                                            <button type="submit" class=" btn btn-metis-6 btn-grad"><i class="glyphicon glyphicon-floppy-disk"></i> Ajouter</button>
                                                                                            <a href="/controls/control.php?mod=pharmacy&act=clearlivraison" class=" btn btn-metis-1 btn-grad"><i class="glyphicon glyphicon-refresh"></i> Vider la liste</a>
                                                                                            <a href="/controls/control.php?mod=pharmacy&act=validerlivraison&id=<?= $_GET['id'] ?>" class=" btn btn-metis-2 btn-grad"><i class="glyphicon glyphicon-ok"></i> Valider la livraison</a>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-lg-7">
                                                                                        <!--<h5 style="margin-top: 0" class="text-center">Liste de produits approvisionnés</h5>-->
                                                                                        <table class="table table-primary table-condensed table-striped table-responsive ">
                                                                                            <thead class="bg-black">
                                                                                            <th>#</th>
                                                                                            <th>ref</th>
                                                                                            <th>Designation</th>
                                                                                            <th>Quantité</th>
                                                                                            <th>Prix d'achat</th>
                                                                                            <th>Prix vente</th>
                                                                                            <th>&nbsp;</th>
                                                                                            </thead>                                                        
                                                                                            <tbody>
                                                                                                <?php
                                                                                                if (isset($_SESSION['productLivraison']) && count($_SESSION['productLivraison']['products']) > 0) {
                                                                                                    $count = 0;
                                                                                                    for ($i = 0; $i < count($_SESSION['productLivraison']['products']); $i++) {
                                                                                                        $count++
                                                                                                        ?>
                                                                                                        <tr>
                                                                                                            <td><?= $count ?></td>
                                                                                                            <td><?= $_SESSION['productLivraison']['products'][$i] ?></td>
                                                                                                            <td><?= $_SESSION['productLivraison']['designation'][$i] ?></td>
                                                                                                            <td><?= $_SESSION['productLivraison']['qteCmd'][$i] ?></td>
                                                                                                            <td><?= $_SESSION['productLivraison']['coutachat'][$i] ?></td>
                                                                                                            <td><?= $_SESSION['productLivraison']['prixvente'][$i] ?></td>
                                                                                                            <td><a class="text-danger" href="/controls/control.php?mod=pharmacy&act=removeproductfromlivraison&id=<?= $_SESSION['productLivraison']['products'][$i] ?>"><span class="glyphicon glyphicon-remove-circle"></span></a>
                                                                                                            </td></tr>
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
                                                        <?php } else {//Livraison non trouvé
                                                            ?>
                                                            <div class="col-md-12"><h2 class="text-center alert alert-info alert-secondary alert-dismissible">Aucune livraison portant cette référence existe</h2> </div>
                                                            <?php
                                                        }
                                                    } else {//Aucune référence approvisionnement séléctionnée
                                                        ?>
                                                        <div class="col-md-12"><h2 class="text-center alert alert-info alert-secondary alert-dismissible">Aucune livraison n'a été sélectionné</h2> </div>
                                                        <?php
                                                    }
                                                    break; //Sortie addproduct
                                                case "listproductlivre":
                                                    if (isset($_GET['id']) && !empty($_GET['id'])) {
                                                        //unset($_SESSION['productAprov']);
                                                        $condition['where'] = " WHERE livraison.id_livraison = '" . $_GET['id'] . "'";
                                                        $refAprov = $controller->getlivraison($condition);
                                                        $condition['where'] = " WHERE livraison.id_livraison ='" . $_GET['id'] . "'";
                                                        $listproductlivre = $controller->getlivraisonitem($condition);
                                                       
                                                        
                                                        if (count($refAprov) > 0) {
                                                            $refAprov = $refAprov[0]
                                                            ?>
                                                            <div class="">                                
                                                                <div class="col-lg-12">
                                                                    <!-- <div class="">
                                                                         <div class="alert alert-info alert-error">
                                                                         <h3>Merci d'initialiser le processus d'approvisionnement</h3>
                                     
                                                                         <p>Vous devriez maintenant ajouter les produits contenus sur la facture fournisseur ou le bon de livraison </p>
                                                                         <p>Notez bien que le produit doit exister en amont. Si non, veuillez procéder à l'ajout de produit dans le système puis revenez pour l'ajouter à l'approvisionnement</p>
                                     
                                                                     </div>-->

                                                                    <div class="panel panel-primary">
                                                                        <div class="panel-heading panel-primary">
                                                                            <h5>Référence : <?= $refAprov->id_livraison ?></h5>
                                                                            <h5>Agent/Service livré : <?= $refAprov->nom . " " . $refAprov->prenom . " (" . $refAprov->fonction . ")" ?></h5>
                                                                            <h5>Nombre de produits : <?= count($listproductlivre) ?></h5>
                                                                            <h5>TAUX APPLIQUE : <?= $refAprov->tauxapplique ?></h5>  
                                                                            <h5>Date : <?= Date::dateToFr($refAprov->datelivraison, "Le %d-%m-%Y") ?></h5>                                                
                                                                            <hr>
                                                                            <?php 
                                                                                if(isset($refAprov->destination) && $refAprov->destination  == 1 ){
                                                                                    $actDetail = $controllerActe->get(["id"=>$refAprov->fk_acte]);
                                                                                    if($actDetail != null && count($actDetail) > 0){
                                                                                        $actDetail = $actDetail[0];
                                                                                    
                                                                                    ?>
                                                                                
                                                                            <h5> Acte : <?= $actDetail->acte ?></h5>
                                                                            <h5>Référence Acte : <?= $refAprov->fk_acte ?></h5>
                                                                            <h5>Patient : <?= $actDetail->nompatient . " " . $actDetail->prenompatient . " (" . $refAprov->fonction . ")" ?></h5>
                                                                            <h5>Num fiche interne : <?= $actDetail->numinterne ?></h5>
                                                                            <h5>Nu : <?= ($actDetail->nu) ? $actDetail->nu : "" ?></h5>  
                                                                            <h5>Date : <?= Date::dateToFr($refAprov->datelivp, "Le %d-%m-%Y") ?></h5>  
                                                                            
                                                                            <?php
                                                                                    }?>
                                                                            <hr>
                                                                            <h1> Statut : <?=  $refAprov->statuliv == 1 ? "Payé" : "Non pas payé" ?></h1>
                                                                            <h5> Date paiement :<?=  isset($refAprov->date_payement) && empty($refAprov->date_payement)  ? Date::dateToFr($refAprov->date_payement, "Le %d-%m-%Y")  : "" ?> </h5>
                                                                            <?php
                                                                                    
                                                                                }
                                                                            
                                                                            ?>
                                                                            
                                                                        </div>
                                                                        
                                                                        <div class="panel-body" style="padding: 20">                                                
                                                                            <div class="col-lg-12">
                                                                                <h5 style="margin-top: 0" class="text-center">Liste de produits livrés</h5>
                                                                                <table class="table table-primary table-condensed table-striped table-responsive ">
                                                                                    <thead class="bg-black">
                                                                                    <th>#</th>
                                                                                    <th>ref</th>
                                                                                    <th>Designation</th>
                                                                                    <th>Quantité</th>
                                                                                    <th>Prix vente</th>
                                                                                   
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
                                                                                                <td ><?= number_format($totalprixvente * $refAprov->tauxapplique, 2) ?> CDF</td>
                                                                                                <td ><?= "" ?></td>                                                            
                                                                                            </tr>
                                                                                        </tfoot>
                                                                                    <?php }
                                                                                    ?>
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                            <?php 
                                                                                if(isset($refAprov->destination) && $refAprov->destination  == 1 && isset($refAprov->statuliv)  && $refAprov->statuliv == 0 ){
                                                                            ?>
                                                                        <div class="panel-footer panel-primary">
                                                                            <div class='row'>
                                                                                <div class="col-md-12">
                                                                                    <a href="" class="btn btn-metis-2 btn-grad col-lg-12"><span class="glyphicon glyphicon-ok"></span> Mettre payé</a></div>
                                                                            </div>
                                                                        </div>
                                                                        <?php
                                                                        
                                                                                }?>
                                                                    </div>

                                                                </div>
                                                            </div>

                                                            </div>
                                                        <?php } else {//Aprovisionnement non trouvé
                                                            ?>
                                                            <div class="col-md-12"><h2 class="text-center alert alert-info alert-secondary alert-dismissible">Aucun approvisionnement portant cette référence existe</h2> </div>
                                                            <?php
                                                        }
                                                    } else {//Aucune référence approvisionnement séléctionnée
                                                        ?>
                                                        <div class="col-md-12"><h2 class="text-center alert alert-info alert-secondary alert-dismissible">Aucun approvisionnement n'a été sélectionné</h2> </div>
                                                        <?php
                                                    }
                                                    break;
                                                default:
                                                    break;
                                            }
                                        } else {//Liste des toutes les livraisons effectuées.>
                                            $listLivraison = $controller->getlistlivraison();
                                            ?>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="box">
                                                        <header>
                                                            <h5>TOUTES LES LIVRAISONS </h5>
                                                            <div class="toolbar">
                                                                <ul class="nav">
                                                                    <li>
                                                                        <a href="/public/pharmacy.php?action=livraison&amp;m=init">
                                                                            <i class="glyphicon glyphicon-plus"></i>&nbsp; Initialiser livraison </a>
                                                                    </li>
                                                                    <li>
                                                                        <form action="/controls/control.php?mod=acte&amp;act=searchlivraison" method="get" class="form-inline searchform" autocomplete="off">
                                                                            <div class=" form-group top_search">
                                                                                <div class="input-group">
                                                                                    <input type="text" class="form-control input-search-livraison" name="q" placeholder="Recherche...">
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
                                                                <?= composants\Utilitaire::pagination($listLivraison['nbPages'], 50, "/public/pharmacy.php?");
                                                                ?>
                                                            </div>
                                                            <div id="stripedTable" class="body collapse in">     
                                                                <?php
                                                                if (count($listLivraison['results']) > 0) {
                                                                    $count = 0;
                                                                    ?>
                                                                    <table class="table table-striped responsive-table">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>#</th>
                                                                                <th>Ref</th>
                                                                                <th>Service/Agent</th>
                                                                                <th>Date</th>
                                                                                <th>&nbsp;</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php foreach ($listLivraison['results'] as $item) {
                                                                                $count++
                                                                                ?>
                                                                                <tr class="">
                                                                                    <td><?= $count ?></td>
                                                                                    <td><?= $item->id_livraison ?></td>
                                                                                    <td><?= $item->nom . " " . $item->prenom . "(" . $item->fonction . ")" ?></td>
                                                                                    <td><?= $item->datelivraison ?></td>
                                                                                    <td>                                                                               
                                                                                        <a href="/public/pharmacy.php?action=livraison&amp;&m=listproductlivre&id=<?= $item->id_livraison ?>"><span class="glyphicon glyphicon-eye-open"></span></a>
                                                                                        <a href="/controls/control.php?mod=pharmacy&amp;act=dellivraison&id=<?= $item->id_livraison ?>" class="danger text-danger"><span class="glyphicon glyphicon-remove"></span></a>
                                                                                    </td>
                                                                                </tr> 
                                                                                <?php
                                                                            }
                                                                            ?>


                                                                        </tbody>     
                                                                    </table>
                                                                <?php } else {
                                                                    ?>
                                                                    <div class="col-md-12"><h2 class="text-center alert alert-info alert-secondary alert-dismissible">Aucune livraison n'a été trouvée</h2> </div>
                                                                <?php }
                                                                ?>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        break; // Livraison
                                        ?>

                                    <?php
                                    case "sale":
                                        if (isset($_GET['id']) && !empty($_GET['id'])) {
                                            $condition = " WHERE vente.id = '" . $_GET['id'] . "'";
                                            $s = $controller->getSalesListe($condition);
                                            $r = $controller->getfactureitems();
                                            $total = 0;
                                            ?>
                                            <div>

                                                <div class="col-lg-8 personne-info">
                                                    <div class="line-personne-info"><span class="champ">Réf Facture :</span><span class="val-line-personne-info"><?= $r[0]->idvente ?></span></div> 
                                                    <div class="line-personne-info"><span class="champ">Date :</span><span class="val-line-personne-info"><?= $r[0]->datevente ?></span></div> 
                                                    <div class="line-personne-info"><span class="champ">Agent :</span><span class="val-line-personne-info"><?= $_SESSION['user']['username'] ?></span></div>
                                                    <div class="line-personne-info"><span class="champ">Taux :</span><span class="val-line-personne-info"><?= $s[0]->tauxapplique ?></span></div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <h3 class="text-center">Liste des produits </h3>
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>
                                                                &nbsp;
                                                            </th>
                                                            <th style="text-align: left">Quantité</th>
                                                            <th>Désignation</th>
                                                            <th>Prix total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        foreach ($r as $item) {
                                                            ?>
                                                            <tr>
                                                                <td>&nbsp;</td>
                                                                <th style="text-align: left"><?= $item->qtebuy ?></th>
                                                                <th><?= $item->designation ?></th>
                                                                <th><?= number_format($item->qtebuy * $item->prixvente, 3, ",", " ") ?> $</th>
                                                            </tr>
                                                            <?php
                                                            $total += $item->qtebuy * $item->prixvente;
                                                        }
                                                        ?>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr class="bg-blue">
                                                            <td>&nbsp;</td>
                                                            <td colspan="2" style="text-align: left"> Total USD</td>                    
                                                            <td colspan="1" ><?= number_format($total, 3, ",", " ") ?>$</td>                    
                                                        </tr>
                                                        <tr class="bg-blue">
                                                            <td>&nbsp;</td>
                                                            <td colspan="2" style="text-align: left"> Total CDF</td>                    
                                                            <td colspan="1" ><?= number_format($total * $s[0]->tauxapplique, 3, ",", " ") ?>CDF</td>  
                                                        </tr>                
                                                    </tfoot>
                                                </table>
                                            </div>
                                        <?php } else {
                                            ?>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="box">
                                                        <header>
                                                            <h5>AUJOURD'HUI</h5>

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


                                                        </header>
                                                        <div id="" class="body">
                                                            <div class="col-lg-12">
                                                            </div>
                                                            <div id="stripedTable" class="body collapse in">

                                                                <?php
                                                                $condition = " WHERE DATE(vente.date) = '" . date("Y-m-d") . "'";
                                                                $listSales = $controller->getSalesListe($condition);

                                                                if (count($listSales) > 0) {
                                                                    $count = 0;
                                                                    ?>
                                                                    <table class="table table-striped responsive-table">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>#</th>
                                                                                <th>Ref</th>
                                                                                <th>Total</th>
                                                                                <th>Date</th>
                                                                                <th>&nbsp;</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr class="">
                                                                                <?php
                                                                                foreach ($listSales as $sale) {
                                                                                    $count++;
                                                                                    ?>
                                                                                    <td><?= $count ?></td>
                                                                                    <td><?= $sale->idvente ?></td>

                                                                                    <td><?= $sale->total ?></td>

                                                                                    <td><?= Date::dateToFr($sale->datevente) ?></td>
                                                                                    <td>                                                                               
                                                                                        <a href="/public/pharmacy.php?action=sale&id=<?= $sale->idvente ?>"><span class="glyphicon glyphicon-eye-open"></span></a>
                                                                                        <a href="/controls/control.php?mod=pharmacy&acte=delsale&id=<?= $sale->idvente ?>" class="danger text-danger"><span class="glyphicon glyphicon-remove"></span></a>
                                                                                    </td>
                                                                                </tr>      
                                                                            <?php }
                                                                            ?>
                                                                        </tbody>
                                                                    </table>
                                                                <?php } else { ?>
                                                                    <div class="row"><h2 class="text-center alert alert-info alert-secondary alert-dismissible">Aucune vente n'est réalisée aujourd'hui</h2> </div> 
                                                                    <?php
                                                                }
                                                                ?>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="box">
                                                        <header>
                                                            <h5>TOUTES LES VENTES </h5>
                                                            <div class="toolbar">
                                                                <ul class="nav">
                                                                    <li>
                                                                        <form action="/controls/control.php?mod=acte&amp;act=searchactes" method="get" class="form-inline searchform" autocomplete="off">
                                                                            <div class=" form-group top_search">
                                                                                <div class="input-group">
                                                                                    <input type="text" class="form-control input-search-sale" name="q" placeholder="Recherche...">
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
                                                                $condition = " WHERE MONTH(vente.date)  = '" . date("m") . "' AND YEAR(vente.date) =  '" . date("Y") . "'";
                                                                $listSales = $controller->getAllSalesListe($condition);

                                                                if (count($listSales) > 0) {
                                                                    $count = 0;
                                                                    ?>
                                                                    <table class="table table-striped responsive-table">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>#</th>
                                                                                <th>Ref</th>
                                                                                <th>Total</th>
                                                                                <th>Date</th>
                                                                                <th>&nbsp;</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr class="">
                                                                                <?php
                                                                                foreach ($listSales as $sale) {
                                                                                    $count++;
                                                                                    ?>
                                                                                    <td><?= $count ?></td>
                                                                                    <td><?= $sale->idvente ?></td>

                                                                                    <td><?= $sale->total ?></td>

                                                                                    <td><?= Date::dateToFr($sale->datevente) ?></td>
                                                                                    <td>                                                                               
                                                                                        <a href="/public/pharmacy.php?action=sale&id=<?= $sale->idvente ?>"><span class="glyphicon glyphicon-eye-open"></span></a>
                                                                                        <a href="/controls/control.php?mod=pharmacy&acte=delsale&id=<?= $sale->idvente ?>" class="danger text-danger"><span class="glyphicon glyphicon-remove"></span></a>
                                                                                    </td>
                                                                                </tr>      
                                                                            <?php }
                                                                            ?>
                                                                        </tbody>     
                                                                    </table>
                                                                <?php }
                                                                ?>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        break; //Sortie sale (les ventes)
                                    case "approvisionnement" :
                                        if (isset($_GET['m']) && !empty($_GET['m'])) {
                                            switch ($_GET['m']) {
                                                case "init":
                                                    ?>
                                                    <div class="row">
                                                        <div id="div-1" class="body collapse in col-lg-12" aria-expanded="true" style="">
                                                            <form class="form-horizontal" action="/controls/control.php?mod=pharmacy&act=initapprov" method="POST" enctype="multipart/form-data" autocomplete="off">
                                                                <div class="form-group">
                                                                    <label class="control-label col-lg-4">Fournisseur</label>
                                                                    <div class="col-lg-8">
                                                                        <select class="form-control" name="idfournisseur">                                                    
                                                                            <?php
                                                                            if (count($listfournisseur) > 0) {
                                                                                foreach ($listfournisseur as $fournisseur) {
                                                                                    ?>
                                                                                    <option value="<?= $fournisseur->id ?>"><?= $fournisseur->nomfournisseur ?></option>
                                                                                    <?php
                                                                                }
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="text1" class="control-label col-lg-4">Référence doc</label>
                                                                    <div class="col-lg-8">
                                                                        <input type="text" id="text1" name="refdoc" placeholder="Référence facture, bon de livraison, ... " value="" class="form-control">
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="text1" class="control-label col-lg-4">Date d'approvisionnement</label>

                                                                    <div class="col-lg-8">
                                                                        <input type="date" id="text1" name="date" value="" placeholder="Date d'aprovisionnement" class="form-control">
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
                                                    </div>

                                                    <?php
                                                    break; //Sortie init
                                                case 'addproduct':
                                                    if (isset($_GET['id']) && !empty($_GET['id'])) {
                                                        //unset($_SESSION['productAprov']);
                                                        $condition['where'] = " WHERE approvisionner.id = '" . $_GET['id'] . "'";
                                                        $refAprov = $controller->getapprovionnement($condition);
                                                        if (count($refAprov) > 0) {
                                                            $refAprov = $refAprov[0]
                                                            ?>
                                                            <div class="">

                                                                <div class="col-lg-12">
                                                                    <div class="">
                                                                        <div class="alert alert-info alert-error">
                                                                            <h3>Merci d'initialiser le processus d'approvisionnement</h3>

                                                                            <p>Vous devriez maintenant ajouter les produits contenus sur la facture fournisseur ou le bon de livraison </p>
                                                                            <p>Notez bien que le produit doit exister en amont. Si non, veuillez procéder à l'ajout de produit dans le système puis revenez pour l'ajouter à l'approvisionnement</p>

                                                                        </div>
                                                                        <form class="form-horizontal" role="form" id="formSearchProduct" action="/controls/control.php?mod=pharmacy&act=addproductapprov&id=<?= $_GET['id'] ?>" method="POST" autocomplete="off">
                                                                            <div class="panel">
                                                                                <div class="panel-heading">
                                                                                    <h5>Référence : <?= $refAprov->id ?></h5>
                                                                                    <h5>Fournisseur : <?= $refAprov->nomfournisseur ?></h5>
                                                                                    <h5>Date : <?= Date::dateToFr($refAprov->date, "Le %d-%m-%Y") ?></h5>
                                                                                    <h5>Taux appliqué : <?= $_SESSION['TAUX'] ?></h5>
                                                                                    <hr>
                                                                                </div>
                                                                                <div class="panel-body" style="padding: 0">
                                                                                    <div class="col-lg-7">
                                                                                        <div class="form-group">
                                                                                            <label for="inputEmail3" class="col-sm-2 control-label">Produit</label>
                                                                                            <div class="col-sm-10">
                                                                                                <input class="searchproduct form-control" type="search" name="product" placeholder="Recherche product par Identifiant, désignation"><div class="wrapAutocompleListe" style="margin-top: 0px; display: none;"><ul><li class="item-suggestion" data-patient="13"><img src="/img/personnel/avatar.jpg"><div class="item-suggestion-data">Nyangs Chris<p>Age : 2001-09-04</p><p>Sexe : F</p><p>Type : 2</p></div></li><li class="item-suggestion" data-patient="12"><img src="/img/personnel/zF650.721.jpeg"><div class="item-suggestion-data">Nzola Melissa<p>Age : 2015-06-17</p><p>Sexe : F</p><p>Type : 0</p></div></li><li class="item-suggestion" data-patient="11"><img src="/img/personnel/zF613.481.jpeg"><div class="item-suggestion-data">Brandon Brandon<p>Age : 2019-04-20</p><p>Sexe : F</p><p>Type : 0</p></div></li><li class="item-suggestion" data-patient="5"><img src="/img/personnel/avatar.jpg"><div class="item-suggestion-data">lutumba Henoc<p>Age : 22</p><p>Sexe : M</p><p>Type : 1</p></div></li><li class="item-suggestion" data-patient="4"><img src="/img/personnel/avatar.jpg"><div class="item-suggestion-data">munia deborah<p>Age : 16</p><p>Sexe : F</p><p>Type : 1</p></div></li><li class="item-suggestion" data-patient="3"><img src="/img/personnel/avatar.jpg"><div class="item-suggestion-data">mukwamasela beni<p>Age : 19</p><p>Sexe : M</p><p>Type : 0</p></div></li><li class="item-suggestion" data-patient="2"><img src="/img/personnel/avatar.jpg"><div class="item-suggestion-data">lutumba adan<p>Age : 12</p><p>Sexe : M</p><p>Type : 0</p></div></li><li class="item-suggestion" data-patient="1"><img src="/img/personnel/avatar.jpg"><div class="item-suggestion-data">munia deborah<p>Age : 16</p><p>Sexe : F</p><p>Type : 1</p></div></li></ul> </div><div class="wrapAutocompleListe" style="margin-top: 0px; display: none;"><ul></ul> </div>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="form-group" id="product">
                                                                                            <div class="col-sm-2">

                                                                                            </div>
                                                                                            <div class="col-sm-10 patientInfo" id="productInfo">
                                                                                                <p class="alert alert-warning">Aucun Produit selectionné</p>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label for="inputEmail3" class="col-sm-2 control-label">Quantité </label>
                                                                                            <div class="col-sm-10">
                                                                                                <input class="form-control" type="number" name="quantite" placeholder="La quantité approvisionnée" value="<?= isset($quantite) ? $quantite : "" ?>">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label for="inputEmail3" class="col-sm-2 control-label">Prix d'achat </label>
                                                                                            <div class="col-sm-10">
                                                                                                <input class="form-control" type="text" name="coutachat" placeholder="Le prix d'achat (Prix achat + dépenses pour achat)" value="<?= isset($coutachat) ? $coutachat : "" ?>">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label for="inputEmail3" class="col-sm-2 control-label">Prix de vente </label>
                                                                                            <div class="col-sm-10">
                                                                                                <input class="form-control" type="text" name="prixvente" placeholder="Le prix de vente du produit" value="<?= isset($prixvente) ? $prixvente : "" ?>">
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <button type="submit" class=" btn btn-metis-6 btn-grad"><i class="glyphicon glyphicon-floppy-disk"></i> Ajouter</button>
                                                                                            <a href="/controls/control.php?mod=pharmacy&act=clearapprov" class=" btn btn-metis-1 btn-grad"><i class="glyphicon glyphicon-refresh"></i> Vider la liste</a>
                                                                                            <a href="/controls/control.php?mod=pharmacy&act=validerapprov&id=<?= $_GET['id'] ?>" class=" btn btn-metis-2 btn-grad"><i class="glyphicon glyphicon-ok"></i> Valider approvisionnement</a>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-lg-5">
                                                                                        <!--<h5 style="margin-top: 0" class="text-center">Liste de produits approvisionnés</h5>-->
                                                                                        <table class="table table-primary table-condensed table-striped table-responsive ">
                                                                                            <thead class="bg-black">
                                                                                            <th>#</th>
                                                                                            <th>ref</th>
                                                                                            <th>Designation</th>
                                                                                            <th>Quantité</th>
                                                                                            <th>Prix d'achat</th>
                                                                                            <th>Prix vente</th>
                                                                                            <th>&nbsp;</th>
                                                                                            </thead>

                                                                                            <tbody>
                                                                                                <?php
                                                                                                if (isset($_SESSION['productAprov']) && count($_SESSION['productAprov']['products']) > 0) {
                                                                                                    $count = 0;
                                                                                                    for ($i = 0; $i < count($_SESSION['productAprov']['products']); $i++) {
                                                                                                        $count++
                                                                                                        ?>
                                                                                                        <tr>
                                                                                                            <td><?= $count ?></td>
                                                                                                            <td><?= $_SESSION['productAprov']['products'][$i] ?></td>
                                                                                                            <td><?= $_SESSION['productAprov']['designation'][$i] ?></td>
                                                                                                            <td><?= $_SESSION['productAprov']['qteCmd'][$i] ?></td>
                                                                                                            <td><?= $_SESSION['productAprov']['coutachat'][$i] ?></td>
                                                                                                            <td><?= $_SESSION['productAprov']['prixvente'][$i] ?></td>
                                                                                                            <td><a class="text-danger" href="/controls/control.php?mod=pharmacy&act=removeproductfromapprov&id=<?= $_SESSION['productAprov']['products'][$i] ?>"><span class="glyphicon glyphicon-remove-circle"></span></a>
                                                                                                            </td></tr>
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
                                                        <?php } else {//Aprovisionnement non trouvé
                                                            ?>
                                                            <div class="col-md-12"><h2 class="text-center alert alert-info alert-secondary alert-dismissible">Aucun approvisionnement portant cette référence existe</h2> </div>
                                                            <?php
                                                        }
                                                    } else {//Aucune référence approvisionnement séléctionnée
                                                        ?>
                                                        <div class="col-md-12"><h2 class="text-center alert alert-info alert-secondary alert-dismissible">Aucun approvisionnement n'a été sélectionné</h2> </div>
                                                        <?php
                                                    }
                                                    break; //Sortie addproduct
                                                case "listproductapprov":
                                                    if (isset($_GET['id']) && !empty($_GET['id'])) {
                                                        //unset($_SESSION['productAprov']);
                                                        $condition['where'] = " WHERE approvisionner.id = '" . $_GET['id'] . "'";
                                                        $refAprov = $controller->getapprovionnement($condition);
                                                        $condition['where'] = " WHERE approvisionner.id ='" . $_GET['id'] . "'";
                                                        $listapprovisionnementproduct = $controller->getapprovisionnementitem($condition);

                                                        if (count($refAprov) > 0) {
                                                            $refAprov = $refAprov[0]
                                                            ?>
                                                            <div class="">

                                                                <div class="col-lg-12">
                                                                    <!-- <div class="">
                                                                         <div class="alert alert-info alert-error">
                                                                         <h3>Merci d'initialiser le processus d'approvisionnement</h3>
                                     
                                                                         <p>Vous devriez maintenant ajouter les produits contenus sur la facture fournisseur ou le bon de livraison </p>
                                                                         <p>Notez bien que le produit doit exister en amont. Si non, veuillez procéder à l'ajout de produit dans le système puis revenez pour l'ajouter à l'approvisionnement</p>
                                     
                                                                     </div>-->

                                                                    <div class="panel">
                                                                        <div class="panel-heading">
                                                                            <h5>Référence : <?= $refAprov->id ?></h5>
                                                                            <h5>Fournisseur : <?= $refAprov->nomfournisseur ?></h5>
                                                                            <h5>Nombre de produits : <?= count($listapprovisionnementproduct) ?></h5>
                                                                            <h5>Taux appliqué : <?= $refAprov->tauxapplique ?></h5>
                                                                            <h5>Date : <?= Date::dateToFr($refAprov->date, "Le %d-%m-%Y") ?></h5>                                                
                                                                            <hr>
                                                                        </div>
                                                                        <div class="panel-body" style="padding: 0">                                                
                                                                            <div class="col-lg-12">
                                                                                <!--<h5 style="margin-top: 0" class="text-center">Liste de produits approvisionnés</h5>-->
                                                                                <table class="table table-primary table-condensed table-striped table-responsive ">
                                                                                    <thead class="bg-black">
                                                                                    <th>#</th>
                                                                                    <th>ref</th>
                                                                                    <th>Designation</th>
                                                                                    <th>Quantité</th>
                                                                                    <th>Prix d'achat</th>
                                                                                    <th>Prix vente</th>
                                                                                    <th>&nbsp;</th>
                                                                                    </thead>

                                                                                    <tbody>
                                                                                        <?php
                                                                                        if (count($listapprovisionnementproduct) > 0) {
                                                                                            $count = 0;
                                                                                            $totalPrixachat = 0;
                                                                                            $totalprixvente = 0;
                                                                                            $quantite = 0;
                                                                                            foreach ($listapprovisionnementproduct as $product) {
                                                                                                $count++;
                                                                                                $totalPrixachat += $product->prixachat;
                                                                                                $totalprixvente += $product->prixvente;
                                                                                                $quantite += $product->qte;
                                                                                                ?>
                                                                                                <tr>
                                                                                                    <td><?= $count ?></td>

                                                                                                    <td><?= $product->id_produit ?></td>
                                                                                                    <td><?= $product->designation ?></td>
                                                                                                    <td><?= $product->qte ?></td>
                                                                                                    <td><?= $product->prixachat ?></td>
                                                                                                    <td><?= $product->prixvente ?></td>
                                                                                                    <td><!--<a class="text-danger" href="/controls/control.php?mod=pharmacy&act=removeproductfromapprov&id=<?= $_SESSION['productAprov']['products'][$i] ?>"><span class="glyphicon glyphicon-remove-circle"></span></a>-->
                                                                                                    </td></tr>
                                                                                                <?php
                                                                                            }
                                                                                        }
                                                                                        ?>

                                                                                    </tbody>
                                                                                    <tfoot>
                                                                                        <tr class="bg-blue" style="font-weight: bolder">
                                                                                            <td colspan="3" style="text-align: left">Total</td>
                                                                                            <td ><?= $quantite ?></td>
                                                                                            <td ><?= $totalPrixachat ?> USD</td>
                                                                                            <td ><?= $totalprixvente ?> USD</td>
                                                                                            <td>&nbsp;</td>
                                                                                        </tr>
                                                                                        <tr class="bg-blue" style="font-weight: bolder">
                                                                                            <td colspan="3" style="text-align: left">Total en FRANC</td>
                                                                                            <td ><?= $quantite ?></td>
                                                                                            <td ><?= $totalPrixachat * $refAprov->tauxapplique ?> CDF</td>
                                                                                            <td ><?= $totalprixvente * $refAprov->tauxapplique ?> CDF</td>
                                                                                            <td>&nbsp;</td>
                                                                                        </tr>
                                                                                    </tfoot>
                                                                                </table>
                                                                            </div>
                                                                        </div>
                                                                    </div>                            
                                                                </div>
                                                            </div>                                
                                                            </div>
                                                        <?php } else {//Aprovisionnement non trouvé
                                                            ?>
                                                            <div class="col-md-12"><h2 class="text-center alert alert-info alert-secondary alert-dismissible">Aucun approvisionnement portant cette référence existe</h2> </div>
                                                            <?php
                                                        }
                                                    } else {//Aucune référence approvisionnement séléctionnée
                                                        ?>
                                                        <div class="col-md-12"><h2 class="text-center alert alert-info alert-secondary alert-dismissible">Aucun approvisionnement n'a été sélectionné</h2> </div>
                                                        <?php
                                                    }
                                                    break;
                                                default:
                                                    break;
                                            }
                                        } else {//Liste des approvisionnement
                                            ?>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="box">
                                                        <header>
                                                            <h5>TOUS LES APPROVISIONNEMENTS</h5>
                                                            <div class="toolbar">
                                                                <ul class="nav">
                                                                    <li><a style="padding: 5px 10px" title="Initialiser l'approvisionnement" href="/public/pharmacy.php?action=approvisionnement&m=init" class="btn btn-grad btn-success"><span class="glyphicon glyphicon-plus"></span></a></li>
                                                                    <li>
                                                                        <form action="/controls/control.php?" method="get" class="form-inline searchform" autocomplete="off">
                                                                            <div class=" form-group top_search">
                                                                                <div class="input-group">
                                                                                    <input type="text" class="form-control input-search-approvisionnement" name="q" placeholder="Recherche...">
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
                                                                <div class="col-lg-12"><ul class="pagination"><li><a href="/public/actes_medicaux.php?action=listdiagnistic&amp;page=1" style="background-color : rgba(240,240,240,.7)">1</a></li><li><a href="/public/actes_medicaux.php?action=listdiagnistic&amp;page=2">2</a></li><li><a href="/public/actes_medicaux.php?action=listdiagnistic&amp;page=3">3</a></li><li><a href="/public/actes_medicaux.php?action=listdiagnistic&amp;page=4">4</a></li><li><a href="/public/actes_medicaux.php?action=listdiagnistic&amp;page=2">&nbsp;<span class="glyphicon glyphicon-forward"></span>&nbsp;</a></li></ul><hr></div>                   

                                                                <?php
                                                                $condition['groupBy'] = " approvisionner.id";
                                                                $listapprovisionnement = $controller->getlistapprovisionnement($condition);
                                                                ?>

                                                                <table class="table table-striped responsive-table">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>#</th>
                                                                            <th>Réf</th>                                                            
                                                                            <th>Fournisseur</th>
                                                                            <th>Ref. Doc.</th>
                                                                            <th>Produit</th>                                                                           
                                                                            <th>&nbsp;</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php
                                                                        if (count($listapprovisionnement) > 0) {
                                                                            $count = 0;
                                                                            foreach ($listapprovisionnement as $approv) {
                                                                                $count++;
                                                                                ?>
                                                                                <tr class="">
                                                                                    <td><?= $count ?></td>
                                                                                    <td><?= $approv->idapprovisionner ?></td>                                                                            
                                                                                    <td><?= $approv->nomfournisseur ?></td>
                                                                                    <td><?= $approv->refdoc ?></td> 
                                                                                    <td><?= $approv->nProduit ?></td> 
                                                                                    <td>
                                                                                        <a href="/public/pharmacy.php?action=approvisionnement&m=listproductapprov&id=<?= $approv->idapprovisionner ?>" class="danger text-success"><span class="glyphicon glyphicon-list"></span></a>
                                                                                        <a href="/controls/control.php?mod=pharmacy&act=delapprov&id=<?= $approv->idapprovisionner ?>" class="danger text-danger"><span class="glyphicon glyphicon-remove"></span></a>
                                                                                    </td>
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
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        break; //Sortie approvisionnement
                                    case "category":
                                        if (isset($_GET['m']) && !empty($_GET['m'])) {
                                            switch ($_GET['m']) {
                                                case "add":
                                                    ?>
                                                    <div class="row">
                                                        <div id="div-1" class="body collapse in col-lg-12" aria-expanded="true" style="">
                                                            <form class="form-horizontal" action="/controls/control.php?mod=pharmacy&act=addcategory" method="POST" enctype="multipart/form-data" autocomplete="off">
                                                                <div class="form-group">
                                                                    <label for="text1" class="control-label col-lg-4">Libellé categorie</label>
                                                                    <div class="col-lg-8">
                                                                        <input type="text" id="" name="lib" placeholder="Nom du fournisseur"value="<?= (isset($lib)) ? $lib : "" ?>" class="form-control">
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
                                                    </div>
                                                    <?php
                                                    break; //sortie addfournisseur
                                                case "edit":
                                                    if (isset($_GET['id']) && !empty($_GET['id'])) {
                                                        $condition['where'] = " WHERE id='" . $_GET['id'] . "'";
                                                        $fournisseur = $controller->getfournisseurs($condition);
                                                        if (count($fournisseur) > 0) {
                                                            ?>
                                                            <div class="row">
                                                                <div id="div-1" class="body collapse in col-lg-12" aria-expanded="true" style="">
                                                                    <form class="form-horizontal" action="/controls/control.php?mod=pharmacy&act=addfournisseur" method="POST" enctype="multipart/form-data" autocomplete="off">

                                                                        <div class="form-group">
                                                                            <label for="text1" class="control-label col-lg-4">Nom fournisseur</label>
                                                                            <div class="col-lg-8">
                                                                                <input type="text" id="" name="nomfournisseur" placeholder="Nom du fournisseur"value="<?= (isset($nomfournisseur)) ? $nomfournisseur : "" ?>" class="form-control">
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="text1"  class="control-label col-lg-4">Téléphone</label>

                                                                            <div class="col-lg-8">
                                                                                <input type="text" id="" name="tel" value="<?= (isset($tel)) ? $tel : "" ?>" placeholder="Téléphone du fournisseur" class="form-control">
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="text1"  class="control-label col-lg-4">Email</label>

                                                                            <div class="col-lg-8">
                                                                                <input type="email" id="" name="email" value="<?= (isset($email)) ? $email : "" ?>" placeholder="Email du fournisseur" class="form-control">
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="text1"  class="control-label col-lg-4">Adresse</label>

                                                                            <div class="col-lg-8">
                                                                                <textarea type="adresse" id="" name="adresse" placeholder="Adresse du fournisseur" class="form-control"><?= (isset($adresse)) ? $adresse : "" ?>s</textarea>
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
                                                            </div>

                                                        <?php } else {
                                                            ?>
                                                            <div class="col-md-12"><h2 class="text-center alert alert-info alert-secondary alert-dismissible">Aucun fournisseur n'a été enregistré avec cette référence</h2> </div>
                                                            <?php
                                                        }
                                                    } else {
                                                        ?>

                                                        <div class="col-md-12"><h2 class="text-center alert alert-info alert-secondary alert-dismissible">Aucun fournisseur n'a été sélectionné pour l'éditer</h2> </div>

                                                        <?php
                                                    }
                                                    ?>

                                                    <?php
                                                    break; //edit
                                                default:
                                                    break;
                                            }
                                        } else {
                                            ?>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="box">
                                                        <header>
                                                            <h5>TOUTES LES CATEGORIES</h5>
                                                            <div class="toolbar">
                                                                <ul class="nav">
                                                                    <li>
                                                                        <a href="/public/pharmacy.php?action=category&m=add">
                                                                            <i class="glyphicon glyphicon-plus"></i>&nbsp; Ajouter Catégorie </a>
                                                                    </li>
                                                                    <li>
                                                                        <form action="/controls/control.php?mod=acte&amp;act=searchactes" method="get" class="form-inline searchform" autocomplete="off">
                                                                            <div class=" form-group top_search">
                                                                                <div class="input-group">
                                                                                    <input type="text" class="form-control input-search-fournirsseur" name="q" placeholder="Recherche...">
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
                                                                <div class="col-lg-12"><ul class="pagination"><li><a href="/public/actes_medicaux.php?action=listdiagnistic&amp;page=1" style="background-color : rgba(240,240,240,.7)">1</a></li><li><a href="/public/actes_medicaux.php?action=listdiagnistic&amp;page=2">2</a></li><li><a href="/public/actes_medicaux.php?action=listdiagnistic&amp;page=3">3</a></li><li><a href="/public/actes_medicaux.php?action=listdiagnistic&amp;page=4">4</a></li><li><a href="/public/actes_medicaux.php?action=listdiagnistic&amp;page=2">&nbsp;<span class="glyphicon glyphicon-forward"></span>&nbsp;</a></li></ul><hr></div>                   
                                                                <?php if (count($listCategory) > 0) {
                                                                    $count = 0;
                                                                    ?>
                                                                    <table class="table table-striped responsive-table">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>#</th>
                                                                                <th>Code Categorie</th>                                                            
                                                                                <th>Libellé</th>
                                                                                <th>Nombre produits</th>
                                                                                <th>&nbsp;</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php
                                                                            foreach ($listCategory as $cat) {
                                                                                $count++;
                                                                                ?>
                                                                                <tr class="">
                                                                                    <td><?= $count ?></td>
                                                                                    <td><?= $cat->idcategory ?></td>
                                                                                    <td>
                        <?= $cat->catprod ?>
                                                                                    </td>
                                                                                    <td><?= $cat->nProd ?></td>                                                                         
                                                                                    <td>                                                                                
                                                                                        <!--<a href="/public/pharmacy.php?action=category&m=edit&id=<?= $cat->idcategory ?>"><span class="glyphicon glyphicon-edit"></span></a>
                                                                                        <a href="/public/pharmacy.php?action=category&m=delete&id=<?= $cat->idcategory ?>" class="danger text-danger"><span class="glyphicon glyphicon-remove"></span></a>-->&nbsp;
                                                                                    </td>

                                                                                </tr>     
                    <?php }
                    ?>

                                                                        </tbody>     

                                                                    </table>
                <?php }
                ?>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                        }
                                        break; //Sortie category
                                    case 'reporting':
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
                                                        if (count($ventes) > 0) {
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
                                        }
                                        break;

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
                                                        <form action="/controls/control.php?mod=structure&act=bind" method="POST" autocomplete="off">
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
                                }//Fin switch GET['action']
                            } else {
                                $listProduit = $controller->getproduct();
                                if (count($listProduit['results']) > 0) {

                                    $count = (isset($_GET['page']) && !empty($_GET['page'])) ? (50 * ($_GET['page'] - 1)) : 0;
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
                                                <div id="optionalTable" class="body collapse in">
                                                    <table class="table responsive-table" id="list-agents">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Produit</th>
                                                                <th>Catégorie</th>
                                                                <th>Qte stock</th>
                                                                <th>Prix Achat</th>
                                                                <th>Prix Vente</th>
                                                                <th>Quantité Alert</th>
                                                                <th>Date Fab</th>
                                                                <th>Date Exp</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
        <?php foreach ($listProduit['results'] as $key => $produit) {
            $count++
            ?>
                                                                <tr>
                                                                    <td><?= $count ?></td>
                                                                    <td>
                                                                        <a href="/public/pharmacy.php?action=view&id=<?= $produit->id ?>" >
                                                                            <h5 style="margin: 0; padding: 0"><?= $produit->lib ?></h5>
                                                                            <span class="mode_conservation">Cond. : <?= $produit->libconservation ?></span>
                                                                            <span class="mode_conservation">Forme : <?= $produit->forme ?></span>
                                                                        </a>
                                                                    </td>
                                                                    <td><?= $produit->libcategory ?></td>
                                                                    <td><?= $produit->quantite ?></td>
                                                                    <td><?= $produit->prixachat ?>$</td>
                                                                    <td><?= $produit->prixvente ?>$</td>
                                                                    <td><?= $produit->qtealert ?></td>
                                                                    <td><?= Date::dateToFr($produit->dateFab, '%d/%m/%Y') ?></td>
                                                                    <td><?= Date::dateToFr($produit->dateExp, '%d/%m/%Y') ?></td>
                                                                    <td>
                                                                        <a class="text-info" href="/public/pharmacy.php?action=edit&id=<?= $produit->id ?>"><span class="glyphicon glyphicon-edit"></span></a>
                                                                        <a class="text-danger" href="/controls/control.php?mod=pharmacy&act=del&id=<?= $produit->id ?>"><span class="glyphicon glyphicon-remove"></span></a>
                                                                    </td>
                                                                </tr>
            <?php
        }
        ?>



                                                        </tbody>               
                                                    </table>
                                                </div>
                                                <div style="padding: 10px;">
        <?= composants\Utilitaire::pagination($listProduit['nbPages'], 50, "/public/pharmacy.php?") ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.inner -->
                                    </div>
                                <?php } else {
                                    ?>
                                    <div class="row"><div class="col-md-12"><h5 class="text-center alert alert-info alert-secondary alert-dismissible">Aucun produit n'a été enregistré dans le système<p><a href="/public/pharmacy.php?action=add" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Cliquer ici</a> <br>pour commencer l'enregistrement du produit</h5> </div></div>

                                    <?php
                                }
                            }
                            ?>
                            </div>
                            <!-- /.outer -->
                            </div>
                            <div id="">                    
                                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                    <form action="/controls/control.php&mod=pharmacy&act=vendre" id="formProductSale" autocomplete="off">
                                        <div class="formVendremodal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title" id="myModalLabel">FACTURATION</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="row">
                                                                <div class="col-lg-12 personne-info">
                                                                    <div class="line-personne-info"><span class="champ">Date :</span><span class="val-line-personne-info"><?= Date::dateToFr(date("Y-m-d")) ?></span></div> 
                                                                    <div class="line-personne-info">
                                                                        <span class="champ">Total :</span>
                                                                        <span class="val-line-personne-info" ><span id="total">0</span>
                                                                            <span class="" id="selectMonnaie">
                                                                                <select name="monnaie" class="input-prepend" id="monnaie">
                                                                                    <option value="usd">USD</option>
                                                                                    <option value="cdf">CDF</option>
                                                                                </select>
                                                                            </span>
                                                                        </span>
                                                                    </div> 
                                                                    <div class="line-personne-info"><span class="champ">Total à payer:</span><span class="val-line-personne-info" id="netpay">0</span></div> 
                                                                    <div class="line-personne-info"><span class="champ">Total en CDF:</span><span class="val-line-personne-info" id="netpayCDF">0</span></div> 
                                                                        <!--<div class="line-personne-info"><span class="champ">TVA:</span><span class="val-line-personne-info">18</span></div> -->

                                                                </div></div>
                                                            <div class="box">                                                
                                                                <header>
                                                                    <h5>Liste des produits commandés</h5>
                                                                    <div class="toolbar">
                                                                        <ul class="nav">
                                                                            <div class="toolbar">
                                                                                <ul class="nav">
                                                                                    <li>
                                                                                        <form action="/controls/control.php?mod=acte&amp;act=searchactes" method="get" autocomplete="off" class="form-inline searchform">
                                                                                            <div class=" form-group top_search" style="margin-bottom: 0px">
                                                                                                <div class="input-group">
                                                                                                    <input type="text" class="form-control input-search-product-sale" name="q" placeholder="Recherche..." autocomplete="off">
                                                                                                    <span class="input-group-btn">
                                                                                                        <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-search"></span></button>
                                                                                                    </span>
                                                                                                </div>
                                                                                            </div>
                                                                                        </form>
                                                                                    </li>

                                                                                </ul>
                                                                            </div>
                                                                        </ul>
                                                                    </div>
                                                                </header>
                                                                <div id="optionalTable" class="body collapse in">
                                                                    <table class="table responsive-table" id="list-product-sold">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>#</th>
                                                                                <th><span class="glyphicon glyphicon-user"></span>Produit</th>
                                                                                <th><span class="glyphicon glyphicon-th"></span>Quantité </th>
                                                                                <th>Prix Vente</th>                                                                
                                                                                <th>total</th>
                                                                                <th>&nbsp;</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr>

                                                                            </tr>
                                                                        </tbody>               
                                                                    </table>
                                                                </div>
                                                                <div style="padding: 10px;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <a type="button" href="/controls/control.php?mod=pharmacy&act=clearbasket" class="btn btn-grad btn-metis-1" id="clearbasket"> <i class="glyphicon glyphicon-trash"></i>&nbsp; Vider</a>
                                                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="glyphicon glyphicon-refresh"></i>&nbsp; Annuler</button>
                                                    <button type="submit" class="btn btn-primary" id="btnFacturer"><i class="glyphicon glyphicon-ok"></i>&nbsp; Confirmer la vente</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <?php
                            include_once ROOT . DS . "squelette" . DS . "footer.php";
                            include_once ROOT . DS . "squelette" . DS . "endPage.php";
                            if (isset($_SESSION['data'])) {
                                unset($_SESSION['data']);
                            }
                            ?>


                            <script>
                                //$('.searchpatientforlivraison').hide();
                                //$('.showselectedpatientforlivraison').hide();
                                $('.selectdestination').trigger("change")
                            </script>