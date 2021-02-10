<div id="left">
    <div class="media user-media bg-dark dker">
        <div class="user-media-toggleHover">
            <span class="fa fa-user"></span>
        </div>
        <div class="user-wrapper bg-dark">
            <a class="user-link" href="">
                <img class="media-object img-thumbnail user-img" alt="User Picture" data-fancybox  src="/img/personnel/<?= $_SESSION['user']['url'] ?>">
                <!--<span class="label label-danger user-label">16</span>-->
            </a>

            <div class="media-body">
                <h5 class="media-heading"><?= $_SESSION['user']['username'] ?></h5>
                <ul class="list-unstyled user-info">
                    <li><a href="/public/personnel.php?action=view&id=<?= $_SESSION['user']['agent'] ?>"><?= $_SESSION['user']['fonction'] ?></a></li>
                    <li>Last Access : <br>
                        <small><i class="glyphicon glyphicon-time"></i>&nbsp;<?= date("d-m-Y à : h:i", $_SESSION['user']['time']) ?></small>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- #menu -->
    <ul id="menu" class="bg-blue dker">
        <li class="nav-header">Menu</li>
        <li class="nav-divider"></li>
        <li class="">
            <a href="/">
                <i class="glyphicon glyphicon-home"></i><span class="link-title">&nbsp; ACCUEIL</span>
            </a>
        </li>
         <?php 
        //if($_SESSION['user']['idFonction'] == 6  || $_SESSION['user']['idFonction'] == 1 || $_SESSION['user']['idFonction'] == 0){
     ?>
        <li class="">
            <a href="javascript:;">
                <i class="glyphicon glyphicon-user"></i>
                <span class="link-title">
                    PATIENTS
                </span>
                <span class="fa arrow"></span>
            </a>
            <ul class="collapse" aria-expanded="false">
                <li>
                    <a href="patients.php">
                        <i class="fa fa-angle-right"></i>&nbsp;Listes </a>
                </li>
                <li>
                    <a href="structures_affilies.php">
                        <i class="fa fa-angle-right"></i>&nbsp; Structures affiliées </a>
                </li>
            </ul>
        </li>
        <?php 
        // }
        ?>
        <li class="">
            <a href="javascript:;">
                <i class="glyphicon glyphicon-folder-open "></i>
                <span class="link-title">ACTES MEDICAUX</span>
                <span class="fa arrow"></span>
            </a>
            <ul class="collapse" aria-expanded="false">
                <!--
                <li>
                    <a href="/public/consultation.php?act=add">
                        <i class="fa fa-angle-right"></i>&nbsp; Consulter now </a>
                </li>
                <li>
                    <a href="/public/consultation.php">
                        <i class="fa fa-angle-right"></i>&nbsp; Consultations </a>
                </li>-->
                <li>
                    <a href="/public/accouchement.php">
                        <i class="fa fa-angle-right"></i>&nbsp; Accouchements </a>
                </li>
                <li>
                    <a href="/public/actes_medicaux.php?action=hospitalisation">
                        <i class="fa fa-angle-right"></i>&nbsp; Hospitalisation </a>
                </li>
                 <?php 
        if($_SESSION['user']['idFonction'] == 4  || $_SESSION['user']['idFonction'] == 1 || $_SESSION['user']['idFonction'] == 0  || $_SESSION['user']['idFonction'] == 2){
     ?>
                <li>
                    <a href="/public/actes_medicaux.php?action=examen">
                        <i class="fa fa-angle-right"></i>&nbsp; Labo</a>
                </li>
                <?php 
                
        
        }?>
                
                  <?php 
        if( $_SESSION['user']['idFonction'] == 1 || $_SESSION['user']['idFonction'] == 0  || $_SESSION['user']['idFonction'] == 2){
     ?>
                <li>
                    <a href="/public/actes_medicaux.php?action=listdiagnistic">
                        <i class="fa fa-angle-right"></i>&nbsp; Diagnostics</a>
                </li>
                
        <?php }
        
        ?>
                <!--
                <li>
                    <a href="/public/actes_medicaux.php?action=examen">
                        <i class="fa fa-angle-right"></i>&nbsp; Examens</a>
                </li>-->
                <li>
                    <a href="/public/grilletarifaire.php?">
                        <i class="fa fa-angle-right"></i>&nbsp; Grille tarifaire</a>
                </li>
                <li>
                    <a href="/public/actes_medicaux.php">
                        <i class="fa fa-angle-right"></i>&nbsp; Tous les actes </a>
                </li>
                <li>
                    <a href="/public/actes_medicaux.php?action=edition">
                        <i class="fa fa-angle-right"></i>&nbsp; Rapport </a>
                </li>
            </ul>
        </li>
         <?php 
        if($_SESSION['user']['idFonction'] == 6  || $_SESSION['user']['idFonction'] == 1 || $_SESSION['user']['idFonction'] == 0){
     ?>
        <li class="">
            <a href="javascript:;">
                <i class="glyphicon glyphicon-user "></i>
                <span class="link-title">PERSONNEL</span>
                <span class="fa arrow"></span>
            </a>
            <ul class="collapse" aria-expanded="false">
                <li>
                    <a href="users.php">
                        <i class="fa fa-angle-right"></i> Comptes utilisateurs </a>
                </li>
                <li>
                    <a href="personnel.php">
                        <i class="fa fa-angle-right"></i> Personnel </a>
                </li>
                <!--
                <li>
                    <a href="fonction.php">
                        <i class="fa fa-angle-right"></i> Fonction </a>
                </li>
                <li>
                    <a href="/public/presences.php">
                        <i class="fa fa-angle-right"></i> Présence </a>
                </li>-->
            </ul>
        </li>
        
        <?php
        }
        if ($_SESSION['user']['idFonction'] == 7 || $_SESSION['user']['idFonction'] == 0) {
            ?>
            <li class="">
                <a href="javascript:;">
                    <i class="glyphicon glyphicon-header"></i>
                    <span class="link-title">PHARMACIE</span>
                    <span class="fa arrow"></span>
                </a>
                <ul class="collapse" aria-expanded="false">
                    <li>
                        <a href="/public/pharmacy.php">
                            <i class="fa fa-angle-right"></i>&nbsp; Produits </a>
                    </li>                
                    <li>
                        <a href="/public/pharmacy.php?action=category">
                            <i class="fa fa-angle-right"></i>&nbsp;Catégories </a>
                    </li>                
                    <li>
                        <a href="/public/pharmacy.php?action=approvisionnement">
                            <i class="fa fa-angle-right"></i>&nbsp; Approvisionnement</a>
                    </li>              
                    <li>
                        <a href="/public/pharmacy.php?action=fournisseur">
                            <i class="fa fa-angle-right"></i>&nbsp; Fournisseurs</a>
                    </li>
                    <li>
                        <a href="/public/pharmacy.php?action=livraison">
                            <i class="fa fa-angle-right"></i>&nbsp;Livraison</a>
                    </li>                
                    <li>
                        <a href="/public/pharmacy.php?action=sale">
                            <i class="fa fa-angle-right"></i>&nbsp; Ventes</a>
                    </li>
                    <li>
                        <a href="/public/pharmacy.php?action=reporting">
                            <i class="fa fa-angle-right"></i>&nbsp; Rapport </a>
                    </li>
                </ul>
            </li>
            <?php
        }
        if ($_SESSION['user']['idFonction'] == 6 || $_SESSION['user']['idFonction'] == 1 || $_SESSION['user']['idFonction'] == 0) {
            ?>
            <li class="">
                <a href="javascript:;">
                    <i class="glyphicon glyphicon-usd"></i>
                    <span class="link-title">
                        COMPTABILITE
                    </span>
                    <span class="fa arrow"></span>
                </a>
                <ul class="collapse" aria-expanded="false">
                    <li>
                        <a href="accounting.php">
                            <i class="fa fa-angle-right"></i>&nbsp;Listes </a>
                    </li>
                    <li>
                        <a href="accounting.php?action=reporting">
                            <i class="fa fa-angle-right"></i>&nbsp; Rapport </a>
                    </li>

                </ul>
            </li>
            <?php
        }
        ?>  
        <li class="nav-divider"></li>

    </ul>
    <!-- /#menu -->
</div>