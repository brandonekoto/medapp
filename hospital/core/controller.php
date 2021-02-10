<?php
namespace hospital\core\controller;
header("Access-Control-Allow-Origin: *");
include_once("dao/DaoUserAccount.php");
include_once("dao/DaoAgent.php");
include_once("dao/DaoNationalite.php");
include_once("dao/DaoFonction.php");
include_once './dao/DaoEchProduit.php';
include_once './dao/DaoProduit.php';
include_once './dao/DaoFournisseur.php';
include_once("beans/agent.php");
include_once './beans/produit.php';
include_once './beans/EchProduit.php';
include_once './beans/lot.php';
include_once './dao/DaoLot.php';
include_once './beans/fournisseur.php';
include_once './dao/DaoFournisseur.php';
include_once './dao/DaoStructureAffilier.php';
include_once './beans/patient.php';
include_once './dao/DaoPatient.php';
include_once './beans/Facture.php';
include_once './dao/DaoFacture.php';
include_once './beans/Acte.php';
include_once './dao/DaoActe.php';
include_once './beans/consultation.php';
include_once './dao/DaoConsult.php';
include_once './beans/StructureAffilier.php';
include_once './beans/Personneaffilierexterne.php';
include_once './dao/DaoPersonneAffilierExterne.php';
include_once './beans/PersonnelStructureAffilier.php';
include_once './dao/DaoPersonnelStructureAffil.php';

if (isset($_GET["type"])) {
    $request = $_GET["type"];
    switch ($request) {
        case 'login':
            $username = $_GET["username"];
            $password = $_GET["password"];
            $daoUser = new DaoUserAccount();
            if ($daoUser->findAccount($username, $password) != null) {
                $data = json_decode($daoUser->findAccount($username, $password));
                $response = array('type' => 'login', 'username' => $data->username, 'password' => $data->password, 'confirm' => $data->confirm, "modules" => $data->modules, "privileges" => $data->privileges);
                echo json_encode($response);
            } else {
                $response = array("type" => "login", "confirm" => "false");
                echo json_encode($response);
            }
            break;

        case 'initData':
            $response = array("type" => "initData");

            $daoNation = new DaoNationalite();
            $data = $daoNation->getNationalites();
            $response0 = json_encode(array("data" => $data));
            $response["nationalites"] = $response0;


            $daoFonct = new DaoFonction();
            $data = $daoFonct->getFonctions();
            $response1 = json_encode(array("data" => $data));
            $response["fonctions"] = $response1;

            $daoEchProduit = new DaoEchProduit();
            $data = $daoEchProduit->getEchProduits();
            $response2 = json_encode(array("data" => $data));
            $response["echProduit"] = $response2;

            $data = $daoEchProduit->getCategorieEchProduit();
            $response3 = json_encode(array("data" => $data));
            $response["categorieEchProduit"] = $response3;

            $daoFourn = new DaoFournisseur();
            $data = $daoFourn->getFournisseurs();
            $response4 = json_encode(array("data" => $data));
            $response["fournisseurs"] = $response4;

            $daoStruc = new DaoStructureAffilier();
            $data = $daoStruc->getStructures();
            $response4 = json_encode(array("data" => $data));
            $response["structureAffilie"] = $response4;


            echo json_encode($response);
            break;

        case 'synchroAgent':
            $daoAgent = new DaoAgent();
            $response = array("type" => "synchroAgent");

            $data = $daoAgent->getAgents();
            $response["data"] = $data;

            echo json_encode($response);
            break;
        case 'synchroStructure':
            $daoStruc = new DaoStructureAffilier();
            $response = array("type" => "synchroStructure");

            $data = $daoStruc->getStructures();
            $response["data"] = $data;

            echo json_encode($response);
            break;

        case "synchroEchProd":
            $daoEchProd = new DaoEchProduit();

            $response = array("type" => "synchroEchProd");

            $data = $daoEchProd->getEchProduits();
            $response["data"] = $data;

            echo json_encode($response);
            break;
        case "findEchProd":
            $daoEchProd = new DaoEchProduit();

            $response = array("type" => "synchroEchProd");

            $data = $daoEchProd->findEchProduit($_GET["str"]);
            $response["data"] = $data;

            echo json_encode($response);
            break;
        case "synchroProduit":
            $daoProd = new DaoProduit();

            $response = array("type" => "synchroProduit");

            $data = $daoProd->getProduits();
            $response["data"] = $data;

            echo json_encode($response);
            break;
        case "synchroStock":
            $daoProd = new DaoProduit();
            $data = $daoProd->getProduits();
            echo $data;
            break;
        case "synchroFournisseur":
            $daoFourn = new DaoFournisseur();

            $response = array("type" => "synchroFournisseur");

            $data = $daoFourn->getFournisseurs();
            $response["data"] = $data;

            echo json_encode($response);
            break;

        case "synchroLots":
            $daoLot = new DaoLot();
            $data = $daoLot->getLots();
            $response = array("type" => "synchroLots");
            $response ["data"] = $data;
            echo json_encode($response);
            break;
        case "synchroPersonnelStructureAffilier":
            $idStructure = $_GET["idStructure"];

            $daoStruc = new DaoStructureAffilier();
            $data = $daoStruc->getPersonnels($idStructure);
            $response = array("type" => "synchroPersonnelStructureAffilier");
            $response ["data"] = $data;
            echo json_encode($response);
            break;
        case "synchroPersonnelStructureAffilierRech":
            $person = $_GET["person"];
            $idStructure = $_GET["idStructure"];

            $daoStruc = new DaoStructureAffilier();
            $data = $daoStruc->getPersonnelByName($idStructure, $person);
            $response = array("type" => "synchroPersonnelStructureAffilierRech");
            $response ["data"] = $data;
            echo json_encode($response);
            break;
        case "synchroPersonneAffilierExt":
            $idPersonnelStructureAffil = $_GET["idPersonnelStructureAffil"];
            $daoStruc = new DaoStructureAffilier();
            $data = $daoStruc->getPersonnelStructureAffil($idPersonnelStructureAffil);
            $response = array("type" => "synchroPersonneAffilierExt");
            $response ["data"] = $data;
            echo json_encode($response);
            break;
        case "synchroPersonneAffilier":
            $idPersonnelStructureAffil = $_GET["idPersonnelStructureAffil"];
            $daoStruc = new DaoStructureAffilier();
            $data = $daoStruc->getPersonnelStructureAffil($idPersonnelStructureAffil);
            $response = array("type" => "synchroPersonneAffilier");
            $response ["data"] = $data;
            echo json_encode($response);
            break;
        case "listPatientStructure":
            $daoPat = new DaoPatient();
            $data = $daoPat->findPatientByStructure($_GET["str"]);
            $response = array("type" => "synchroPatient");
            $response ["data"] = $data;
            echo json_encode($response);
            break;
        case "synchroPersonneAffilierIn":
            $idPersonnelStructureAffil = $_GET["idPersonnelStructureAffil"];
            $daoAgent = new DaoAgent();
            $data = $daoAgent->getPersonAffiliers($idPersonnelStructureAffil);
            $response = array("type" => "synchroPersonneAffilierIn");
            $response ["data"] = $data;
            echo json_encode($response);
            break;

        case "synchroPatient":
            $daoPatient = new DaoPatient();
            $data = $daoPatient->getPatients();
            $response = array("type" => "synchroPatient");
            $response ["data"] = $data;
            echo json_encode($response);
            break;
        case "synchroPatientRech":
            $daoPatient = new DaoPatient();
            $data = $daoPatient->findPatient($_GET["str"]);
            $response = array("type" => "synchroPatientRech");
            $response ["data"] = $data;
            echo json_encode($response);
            break;
        case "synchroPatientRechBar":
            $daoPatient = new DaoPatient();
            $data = $daoPatient->findPatient($_GET["str"]);
            $response = array("type" => "synchroPatient");
            $response ["data"] = $data;
            echo json_encode($response);
            break;
        case "synchroStructureRechBar":
            $daoStruc = new DaoStructureAffilier();
            $data = $daoStruc->findStructure($_GET["str"]);
            $response = array("type" => "synchroStructure");
            $response ["data"] = $data;
            echo json_encode($response);
            break;
        case "modifyPatient":
            $daoPatient = new DaoPatient();
            $data = $daoPatient->delete($_GET["idPatient"]);
            $response = array("type" => "deletePatient");
            $response ["data"] = $data;
            echo json_encode($response);
            break;
        case "synchroActes":
            $daoActe = new DaoActe();
            $data = $daoActe->getActes();
            $response = array("type" => "synchroActes");
            $response ["data"] = $data;
            echo json_encode($response);
            break;
        case "findActes":
            $daoActe = new DaoActe();
            $data = $daoActe->findActes($_GET["str"]);
            $response = array("type" => "synchroActes");
            $response ["data"] = $data;
            echo json_encode($response);
            break;
        case "synchroVente":
            $daoFacture = new DaoFacture();
            $data = $daoFacture->getFactures();
            $response = array("type" => "synchroVente");
            $response ["data"] = $data;
            echo json_encode($response);
            break;
        case "reportVente":
            $daoFacture = new DaoFacture();
            $data = $daoFacture->reportVente($_GET["typeSelected"]);
            echo json_encode($data);
            break;
        case "synchroDetailVente":
            $idFacture = $_GET["idFacture"];
            $daoFacture = new DaoFacture();
            $data = $daoFacture->getFactureId($idFacture);
            $response = array("type" => "synchroDetailVente");
            $response ["data"] = $data;
            echo json_encode($response);
            break;
        case "reportFacture":
            $idFacture = $_GET["idFacture"];
            $daoFacture = new DaoFacture();
            $data = $daoFacture->getFactureId($idFacture);
            echo $data;
            break;
        case "synchroConsult":
            $daoConsult = new DaoConsult();
            $data = $daoConsult->getConsults();
            $response = array("type" => "synchroConsult");
            $response ["data"] = $data;
            echo json_encode($response);
            break;
        case "findConsult":
            $daoConsult = new DaoConsult();
            $data = $daoConsult->findConsult($_GET["str"]);
            $response = array("type" => "synchroConsult");
            $response ["data"] = $data;
            echo json_encode($response);
            break;
        case "synchroFiche":
            $id = $_GET["id"];

            $daoConsult = new DaoConsult();
            $data = $daoConsult->getConsultByPatient($id);
            $response = array("type" => "synchroFiche");
            $response ["data"] = $data;
            echo json_encode($response);
            break;
        case "selectProduitBarcode":
            $daoProd = new DaoProduit();
            $response = array("type" => "selectProduitBarcode");

            $data = $daoProd->getByBarcode($_GET["barcode"]);
            $response["data"] = $data;

            echo json_encode($response);
            break;
            break;

        case 'detailAgent':
            $daoAgent = new DaoAgent();
            $data = $daoAgent->getAgent($_GET["id"]);

            echo $data;
            break;

        case 'uploadImage':
            if (isset($_FILES['image'])) {
                $errors = array();
                $file_name = $_FILES['image']['name'];
                $file_size = $_FILES['image']['size'];
                $file_tmp = $_FILES['image']['tmp_name'];
                $file_type = $_FILES['image']['type'];

                if ($file_size > 209715) {
                    move_uploaded_file($file_tmp, "data/imgs/" . $file_name);
                    echo json_encode(array("confirm" => "true", "url" => $file_name));
                } else {
                    echo json_encode(array("confirm" => "taille>"));
                }
            }
            break;

        case "search":
            $daoAgent = new DaoAgent();

            $response = array("type" => "search");

            $data = $daoAgent->findAgent($_GET["contenu"]);
            $response["data"] = $data;
            echo json_encode($response);
            break;

        case "autoCompleteVenteProd":
            $daoProd = new DaoProduit();

            $response = array("type" => "autoCompleteVenteProd");

            $data = $daoProd->getListAutoComplete($_GET["str"]);
            $response["data"] = $data;

            echo json_encode($response);
            break;
        case "findProd":
            $daoProd = new DaoProduit();

            $response = array("type" => "synchroProduit");

            $data = $daoProd->getListAutoComplete($_GET["str"]);
            $response["data"] = $data;
            echo json_encode($response);
            break;

        case "uploadDocLot":
            if (isset($_FILES['docLot'])) {
                $errors = array();
                $file_name = $_FILES['docLot']['name'];
                $file_size = $_FILES['docLot']['size'];
                $file_tmp = $_FILES['docLot']['tmp_name'];
                $file_type = $_FILES['docLot']['type'];

                if ($file_size > 209715) {
                    move_uploaded_file($file_tmp, "data/docs/" . $file_name);
                    echo json_encode(array("confirm" => "true", "url" => $file_name));
                } else {
                    echo json_encode(array("confirm" => "taille>"));
                }
            }
            break;

        case 'delProduit':

            $idProduit = $_GET["idProduit"];

            $daoProd = new DaoProduit();
            $response = $daoProd->deleteProduit($idProduit);
            $resp = array("type" => "delProduit", "confirm" => $response);
            echo json_encode($resp);

            break;
        case "delEchProduit":
            $idEchProduit = $_GET["idEchProduit"];

            $daoEchProd = new DaoEchProduit();
            $response = $daoEchProd->deleteEchProduit($idEchProduit);
            $resp = array("type" => "delEchProduit", "confirm" => $response);
            echo json_encode($resp);

            break;
        case "printVente":
            $daoFacture = new DaoFacture();
            $data = $daoFacture->getFactures();
            echo json_encode($data);
            break;

        case "printReceipt":
            $daoFacture = new DaoFacture();
            $data = $daoFacture->getFactureId($_GET["id"]);
            echo json_encode($data);
            break;
    }
}

if (isset($_POST["type"])) {
    $request = $_POST["type"];

    switch ($request) {

        case 'addAgent':
            $nom = $_POST["nom"];
            $postnom = $_POST["postnom"];
            $prenom = $_POST["prenom"];
            $genre = $_POST["genre"];
            $dateNaiss = $_POST["dateNaiss"];
            $lieuNaiss = $_POST["lieuNaiss"];
            $idNationalite = $_POST["idNationalite"];
            $etatCivil = $_POST["etatCivil"];
            $nbreEnfant = $_POST["nbreEnfant"];
            $idFonction = $_POST["idFonction"];
            $adresse = $_POST["adresse"];
            $telDomicile = $_POST["telDomicile"];
            $telBureau = $_POST["telBureau"];
            $email = $_POST["nivEtudes"];
            $nivEtudes = $_POST["nivEtudes"];
            $statut = $_POST["statut"];
            $dateEng = $_POST["dateEngagement"];
            $dateSorti = $_POST["dateSortir"];
            $urlPhoto = $_POST["urlPhoto"];

            $agent = new Agent();
            $agent->setNom($nom);
            $agent->setPostnom($postnom);
            $agent->setPrenom($prenom);
            $agent->setGenre($genre);
            $agent->setDateNaiss($dateNaiss);
            $agent->setIdNationalite($idNationalite);
            $agent->setLieuNaiss($lieuNaiss);
            $agent->setEtatCivil($etatCivil);
            $agent->setNbreEnfant($nbreEnfant);
            $agent->setIdFonction($idFonction);
            $agent->setAdresse($adresse);
            $agent->setTelDomicile($telDomicile);
            $agent->setTelBureau($telBureau);
            $agent->setEmail($email);
            $agent->setNivEtudes($nivEtudes);
            $agent->setStatut($statut);
            $agent->setDateEngagement($dateEng);
            $agent->setDateSortir($dateSorti);
            $agent->setUrlPhoto($urlPhoto);

            $daoAgent = new DaoAgent();
            $response = $daoAgent->setAgent($agent);

            $resp = array("type" => "addAgent", "confirm" => $response);
            echo json_encode($resp);
            break;

        case 'addProduit':
            $idEchProduit = $_POST["idEchProduit"];
            $codeBar = $_POST["codeBar"];
            $prixUnitaire = $_POST["prixUnitaire"];
            $quantite = $_POST["quantite"];
            $dateFab = $_POST["dateFab"];
            $dateExp = $_POST["dateExp"];
            $idFournisseur = $_POST["idFournisseur"];
            $idLot = $_POST["idLot"];

            $prod = new Produit();
            $prod->setIdEchProduit($idEchProduit);
            $prod->setPrixUnitaire($prixUnitaire);
            $prod->setCodeBar($codeBar);
            $prod->setQuantite($quantite);
            $prod->setDateExp($dateExp);
            $prod->setDateFab($dateFab);
            $prod->setIdFournisseur($idFournisseur);

            $daoProd = new DaoProduit();
            $response = $daoProd->setProduit($prod, $idLot);

            $resp = array("type" => "addProduit", "confirm" => $response);
            echo json_encode($resp);
            break;

        case 'modProduit':

            $prixUnitaire = $_POST["prixUnitaire"];
            $quantite = $_POST["quantite"];
            $dateFab = $_POST["dateFab"];
            $dateExp = $_POST["dateExp"];
            $idFournisseur = $_POST["idFournisseur"];
            $idProduit = $_POST["idProduit"];

            $prod = new Produit();
            $prod->setIdProduit($idProduit);
            $prod->setPrixUnitaire($prixUnitaire);
            $prod->setQuantite($quantite);
            $prod->setDateExp($dateExp);
            $prod->setDateFab($dateFab);
            $prod->setIdFournisseur($idFournisseur);

            $daoProd = new DaoProduit();
            $response = $daoProd->modProduit($prod);

            $resp = array("type" => "modProduit", "confirm" => $response);
            echo json_encode($resp);
            break;

        case "modEchProduit":
            $idEchProduit = $_POST["idEchProduit"];
            $designation = $_POST["designation"];
            $idCategorie = $_POST["categorie"];
            $modeConservation = $_POST["modeConservation"];
            $uniteConsommation = $_POST["uniteConsommation"];
            $quantiteAlerte = $_POST["quantiteAlerte"];

            $EchProduit = new EchProduit();
            $EchProduit->setIdEchProduit($idEchProduit);
            $EchProduit->setDesignation($designation);
            $EchProduit->setIdCategorie($idCategorie);
            $EchProduit->setModeConservation($modeConservation);
            $EchProduit->setUniteConsommation($uniteConsommation);
            $EchProduit->setQuantiteAlerte($quantiteAlerte);

            $daoEchProd = new DaoEchProduit();
            $response = $daoEchProd->modEchProduit($EchProduit);

            $resp = array("type" => "modEchProduit", "confirm" => $response);
            echo json_encode($resp);
            break;

        case "addEchProduit":
            $designation = $_POST["designation"];
            $categorie = $_POST["categorie"];
            $modeConservation = $_POST["modeConservation"];
            $uniteConsommation = $_POST["uniteConsommation"];
            $quantiteAlerte = $_POST["quantiteAlerte"];

            $echProd = new EchProduit();
            $echProd->setDesignation($designation);
            $echProd->setIdCategorie($categorie);
            $echProd->setModeConservation($modeConservation);
            $echProd->setUniteConsommation($uniteConsommation);
            $echProd->setQuantiteAlerte($quantiteAlerte);

            $daoEchProd = new DaoEchProduit();
            $response = $daoEchProd->setEchProduit($echProd);
            $resp = array("type" => "addEchProduit", "confirm" => $response);
            echo json_encode($resp);
            break;

        case "addLot":
            $designationLot = $_POST["designationLot"];
            $dateLot = $_POST["dateLot"];
            $doc = $_POST["document"];

            $lot = new Lot($designationLot, $dateLot, $doc);

            $daoLot = new DaoLot();
            $response = $daoLot->setLot($lot);
            $resp = array("type" => "addLot", "confirm" => $response);
            echo json_encode($resp);

            break;

        case "addFournisseur":
            $fournisseur = $_POST["fournisseurProd"];

            $fourn = new Fournisseur();
            $fourn->setFournisseur($fournisseur);

            $daoFourn = new DaoFournisseur();
            $response = $daoFourn->setFournisseur($fourn);
            $resp = array("type" => "addFournisseur", "confirm" => $response);
            echo json_encode($resp);
            break;
        case "addPatient":
            $nom = $_POST["nom"];
            $postnom = $_POST["postnom"];
            $prenom = $_POST["prenom"];
            $genre = $_POST["genre"];
            $age = $_POST["age"];
            $contact = $_POST["contact"];
            $adresse = $_POST["adresse"];
            $typePatient = $_POST["typePatient"];
            $numAffiliation = 0;
            if (isset($_POST["numAffiliation"])) {
                $numAffiliation = $_POST["numAffiliation"];
            }


            $patient = new Patient();
            $patient->setNom($nom);
            $patient->setPostnom($postnom);
            $patient->setPrenom($prenom);
            $patient->setGenre($genre);
            $patient->setdateNaiss($age);
            $patient->setContact($contact);
            $patient->setAdresse($adresse);
            $patient->setTypePatient($typePatient);
            $patient->setNumAffiation($numAffiliation);

            $daoPatient = new DaoPatient();
            $response = $daoPatient->setPatient($patient);
            $resp = array("type" => "addPatient", "confirm" => $response);
            echo json_encode($resp);
            break;

        case "addActe":
            $designation = $_POST["designation"];
            $categorie = $_POST["categorie"];
            $prix = $_POST["prix"];

            $acte = new Acte();
            $acte->setDesignation($designation);
            $acte->setCategorie($categorie);
            $acte->setPrix($prix);

            $daoActe = new DaoActe();
            $response = $daoActe->setActe($acte);
            $resp = array("type" => "addActe", "confirm" => $response);
            echo json_encode($resp);

            break;
        case "sellProduit":
            $data = $_POST["data"];

            $facture = new Facture();
            $facture->setMontant($_POST["montTot"]);

            $daoFonct = new DaoFacture();
            $response = $daoFonct->setFacture($facture, $data, $_POST["comp"]);

            $resp = array("type" => "sellProduit", "confirm" => $response["response"], "id" => $response["id"]);
            echo json_encode($resp);
            break;
        case "addFiche":
            switch ($_POST["consult"]) {
                case "reception":
                    $acte = $_POST["acte"];
                    $anamnese = $_POST["anamnese"];
                    $poids = $_POST["poids"];
                    $taille = $_POST["taille"];
                    $temp = $_POST["temp"];
                    $idPatient = $_POST["idPatient"];


                    $consult = new Consultation();
                    $consult->setActe($acte);
                    $consult->setAnamnese($anamnese);
                    $consult->setPoids($poids);
                    $consult->setTaille($taille);
                    $consult->setTemp($temp);
                    $consult->setIdPatient($idPatient);

                    $daoConsult = new DaoConsult();
                    $response = $daoConsult->setConsult1($consult);
                    $resp = array("type" => "addFiche", "confirm" => $response);
                    echo json_encode($resp);
                    break;
                case "doc":
                    $obs = $_POST["obs"];
                    $diagno = $_POST["diagno"];
                    $examens = $_POST["examens"];
                    $idConsult = $_POST["idConsult"];

                    $consult = new Consultation();
                    $consult->setObs($obs);
                    $consult->setDiagnostique($diagno);
                    $consult->setIdConsult($idConsult);
                    $consult->setExamens($examens);
                    $consult->setValideDoc("ok");

                    $daoConsult = new DaoConsult();
                    $response = $daoConsult->setConsultDoc($consult);
                    $resp = array("type" => "addFiche", "confirm" => $response);
                    echo json_encode($resp);
                    break;
                case "labo":
                    $result = $_POST["result"];
                    $idConsult = $_POST["idConsult"];

                    $consult = new Consultation();
                    $consult->setResultat($result);
                    $consult->setIdConsult($idConsult);
                    $consult->setValideLabo("ok");

                    $daoConsult = new DaoConsult();
                    $response = $daoConsult->setConsultLabo($consult);
                    $resp = array("type" => "addFiche", "confirm" => $response);
                    echo json_encode($resp);
                    break;

                default:
                    break;
            }

            break;

        case "addStructure":
            $lib = $_POST["libelle"];
            $contact = $_POST["contact"];
            $adresse = $_POST["adresse"];

            $str = new StructureAffilier();
            $str->setLibelle($lib);
            $str->setContacts($contact);
            $str->setAdresse($adresse);

            $daoStruc = new DaoStructureAffilier();
            $response = $daoStruc->setStructure($str);

            $resp = array("type" => "addStructure", "confirm" => $response);
            echo json_encode($resp);
            break;
        case "addAffilierEx":
            $nom = $_POST["nom"];
            $postnom = $_POST["postnom"];
            $prenom = $_POST["prenom"];
            $genre = $_POST["genre"];
            $date = $_POST["date"];
            $id = $_POST["id"];

            $person = new Personneaffilierexterne();
            $person->setNom($nom);
            $person->setPostnom($postnom);
            $person->setPrenom($prenom);
            $person->setGenre($genre);
            $person->setDateNaiss($date);
            $person->setIdPersonnelStructureAffilier($id);

            $daoPersoAff = new DaoPersonneAffilierExterne();
            $response = $daoPersoAff->setPersonneAffilierExt($person);

            $resp = array("type" => "addAffilierEx", "confirm" => $response, "id" => $id);
            echo json_encode($resp);
            break;
        case "addPersonnelStructure":
            $strucID = $_POST["strucID"];
            $matricule = $_POST["matricule"];
            $nom = $_POST["nom"];
            $postnom = $_POST["postnom"];
            $prenom = $_POST["prenom"];
            $genre = $_POST["genre"];

            $person = new PersonnelStructureAffilier();
            $person->setIdStructure($strucID);
            $person->setMatricule($matricule);
            $person->setNom($nom);
            $person->setPostnom($postnom);
            $person->setPrenom($prenom);
            $person->setGenre($genre);

            $daoPersoStruc = new DaoPersonnelStructureAffil();
            $response = $daoPersoStruc->setPersonStruc($person);

            $resp = array("type" => "addPersonnelStructure", "confirm" => $response);
            echo json_encode($resp);
            break;
    }
}
?>