<?php
include_once './core/dao/DaoUserAccount.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Admin</title>
        <style>
            body {
                padding: 0px;
                margin: 0px;
                overflow: hidden;
            }

            .contenu {
                background-color: rgba(194, 195, 199, 0.3);
                width: 100%;
                height: 800px;
            }
            /* nav {
              height: 50px;
              width: 100%;
              border: 1px solid rgba(146, 145, 145, 0);
              background: linear-gradient(
                to top,
                rgba(44, 44, 44, 0.7),
                rgba(27, 27, 27, 0.7)
              );
              color: white;
            } */
            .block {
                width: 70%;
                height: 530px;
                background-color: white;
                margin: auto;
                box-shadow: 0 0 1px rgba(0, 0, 0, 0.2);
                margin-top: 30px;
            }
        </style>
        <link
            rel="stylesheet"
            href="libs/bootstrap/bootstrap-3.3.7-dist/css/bootstrap.css"
            />
    </head>
    <body>
        <a href="index.php" id="actualise" hidden>actualise</a>
        <div class="contenu">
            <nav class="navbar navbar-inverse" role="navigation">
                <div class="navbar-header">
                    <a href="#" class="navbar-brand">Admin</a>
                </div>
            </nav>
            <section class="block">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#compte" data-toggle="tab">Comptes</a>
                    </li>
                </ul>
                <button
                    type="buttom"
                    class="btn btn-info pull-right"
                    style="margin-right: 10px; margin-top: 10px;"
                    id="ajouter"
                    >
                    <span class="glyphicon glyphicon-pencil"></span> Ajouter
                </button>
                <button
                    type="buttom"
                    class="btn btn-info pull-right"
                    style="margin-right: 10px; margin-top: 10px;"
                    id="close"
                    >
                    <span class="glyphicon glyphicon-remove"></span>
                </button>
                <div class="compte" style="padding-top: 10px; margin-top: 45px">
                    <div id="panAddAccount">
                        <form class="" style="margin-top: 40px; width: 50%; margin: auto" action="index.php?type=Add" method="POST">
                            <div class="form-group">
                                <label for="">ID Personnel</label>
                                <input type="text" class="form-control" name="id" required autocomplete="off" />
                            </div>
                            <div class="form-group">
                                <label for="">Nom d'utilisateur</label>
                                <input type="text" class="form-control" name="username" required autocomplete="off"/>
                            </div>
                            <div class="form-group">
                                <label for="">Mot de passe</label>
                                <input type="text" class="form-control" name="password" required autocomplete="off"/>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <label>Modules</label>
                                    <div class="checkbox">
                                        <input type="checkbox" name="module7" value="acte" id="acte"/> Actes médicaux
                                    </div>
                                    <div class="checkbox">
                                        <input type="checkbox" name="module2" id="" value="pharmacie"/> Pharmacie
                                    </div>
                                    <div class="checkbox">
                                        <input type="checkbox" name="module3" id="" value="patient"/> Patient
                                    </div>
                                    <div class="checkbox">
                                        <input type="checkbox" name="module4" id="" value="personnel"/> Personnel
                                    </div></div>
                                <div class="col-lg-6">

                                    <div class="privActes">
                                        <label>Privilèges</label>
                                        <div class="checkbox">
                                            <input type="checkbox" name="priv1" id="" value="doc" /> Docteur
                                        </div>
                                        <div class="checkbox">
                                            <input type="checkbox" name="priv2" id="" value="fiche" /> Création de la fiche  
                                        </div>
                                        <div class="checkbox">
                                            <input type="checkbox" name="priv3" id="" value="labo" /> Laboratoire  
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <span id="rep" style="color:red; text-align: center"><?php
                                if (isset($_GET["type"])) {

                                    switch ($_GET["type"]) {
                                        case "Add":
                                            $daoUser = new DaoUserAccount();
                                            $person = $_POST["id"];

                                            $username = $_POST["username"];
                                            $password = $_POST["password"];
                                            $module1 = "";
                                            $module2 = "";
                                            $module3 = "";
                                            $module4 = "";

                                            $result = "";
                                            $privActes = "";

                                            if (isset($_POST["module7"])) {
                                                $module1 = $_POST["module7"];

                                                if ($result == "") {
                                                    $result .= $module1;
                                                } else {
                                                    $result .= "|" . $module1;
                                                }

                                                if (isset($_POST["priv1"])) {
                                                    if ($privActes == "") {
                                                        $privActes .= $_POST["priv1"];
                                                    } else {
                                                        $privActes .= "|" . $_POST["priv1"];
                                                    }
                                                }
                                                if (isset($_POST["priv2"])) {
                                                    if ($privActes == "") {
                                                        $privActes .= $_POST["priv2"];
                                                    } else {
                                                        $privActes .= "|" . $_POST["priv2"];
                                                    }
                                                }
                                                if (isset($_POST["priv3"])) {
                                                    if ($privActes == "") {
                                                        $privActes .= $_POST["priv3"];
                                                    } else {
                                                        $privActes .= "|" . $_POST["priv3"];
                                                    }
                                                }
                                            }
                                            if (isset($_POST["module2"])) {
                                                $module2 = $_POST["module2"];
                                                if ($result == "") {
                                                    $result .= $module2;
                                                } else {
                                                    $result .= "|" . $module2;
                                                }
                                            }
                                            if (isset($_POST["module3"])) {
                                                $module3 = $_POST["module3"];
                                                if ($result == "") {
                                                    $result .= $module3;
                                                } else {
                                                    $result .= "|" . $module3;
                                                }
                                            }
                                            if (isset($_POST["module4"])) {
                                                $module4 = $_POST["module4"];
                                                if ($result == "") {
                                                    $result .= $module4;
                                                } else {
                                                    $result .= "|" . $module4;
                                                }
                                            }


                                            if (isset($_POST["module7"])) {

                                                if ($privActes !== "") {

                                                    $priv = "acte$" . $privActes;
                                                    if ($daoUser->setAccount($person, $username, $password, $result, $priv) === "nonePerso") {
                                                        echo "Mauvais ID Personnel";
                                                    }
                                                } else {
                                                    echo 'Veuillez renseigner le privilège du module "Actes médicaux"';
                                                }
                                            } else {
                                                if ($daoUser->setAccount($person, $username, $password, $result, "") === "nonePerso") {
                                                    echo "Mauvais ID Personnel";
                                                }
                                            }


                                            break;

                                        case "remove":
                                            $daoUser = new DaoUserAccount();
                                            $i = $daoUser->remove($_GET["id"]);
                                            if ($i == 1) {
                                                
                                            }
                                            break;
                                    }
                                }
                                ?></span><br>
                            <button type="submit" class="btn btn-info pull-right" id="valide">Valider</button>
                        </form>

                    </div>
                    <div class="panlistAccount" style="margin:auto; width: 90%;">
                        <table
                            class="table table-condensed table-striped col-lg-10"
                            style="width: 100%;"
                            >
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>ID Personnel</th>
                                    <th>Nom d'utilisateur</th>
                                    <th>Module</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $daoUser = new DaoUserAccount();
                                echo $daoUser->getAllAccounts();
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>

        <script src="libs/jquery/jquery-1.9.1.min.js"></script>
        <script src="libs/bootstrap/js/bootstrap.js"></script>
        <script>
            $("#close").hide();
            $("#panAddAccount").hide();
            $(".privActes").hide();



            $("#ajouter").click(function () {
                $("#close").show();
                $("#panAddAccount").show();

                $("#ajouter").hide();
                $(".panlistAccount").hide();
            });
            $("#close").click(function () {
                $("#close").hide();
                $("#panAddAccount").hide();

                $("#ajouter").show();
                $(".panlistAccount").show();
            });

            $("#acte").click(function () {
                console.log("cliquer");
                if ($("#acte").is(":checked")) {
                    $(".privActes").show();
                } else {
                    $(".privActes").hide();
                }
            });

            if ($("#rep").text() !== "") {
                $("#close").show();
                $("#panAddAccount").show();

                $("#ajouter").hide();
                $(".panlistAccount").hide();
            } else {
                $("#actualise").trigger("click");
            }
        </script>
    </body>
</html>
