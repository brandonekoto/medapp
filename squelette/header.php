<body class="menu-affix">
    <div class="bg-dark dk" id="wrap">        
        <div id="top">
            <!-- .navbar -->
            <nav class="navbar navbar-inverse navbar-fixed-top">
                <div class="container-fluid">


                    <!-- Brand and toggle get grouped for better mobile display -->
                    <header class="navbar-header">

                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                            <a href="/public/" class="navbar-brand"><img src="assets/img/logococo.png" alt="" style="width:90px; height: 45px; padding: 5px"></a>
                    </header>
                    <div class="topnav">
                        
                        <div class="btn-group tauxjour">
                            TAUX : <?= $_SESSION['TAUX']?> CDF &nbsp;
                        </div>
                        <!--
                        <div class="btn-group">
                            <a data-placement="bottom" data-original-title="E-mail" data-toggle="tooltip" class="btn btn-default btn-sm">
                                <i class="fa fa-envelope"></i>
                                <span class="label label-warning">5</span>
                            </a>
                            <a data-placement="bottom" data-original-title="Messages" href="#" data-toggle="tooltip" class="btn btn-default btn-sm">
                                <i class="fa fa-comments"></i>
                                <span class="label label-danger">4</span>
                            </a>
                            <a data-toggle="modal" data-original-title="Help" data-placement="bottom" class="btn btn-default btn-sm" href="#helpModal">
                                <i class="fa fa-question"></i>
                            </a>
                        </div>
                        -->
                        <div class="btn-group">
                            <a href="/logout.php" data-toggle="tooltip" data-original-title="Logout" data-placement="bottom" class="btn btn-metis-1 btn-sm btn-grad">
                                <i class="glyphicon glyphicon-off"></i>
                            </a>
                        </div>
                        
                        <div class="btn-group">
                            <a data-placement="bottom" data-original-title="Show / Hide Left" data-toggle="tooltip" class="btn btn-primary btn-sm toggle-left" id="menu-toggle">
                                <i class="glyphicon glyphicon-th-list"></i>
                            </a>
                            <a href="#right" data-toggle="onoffcanvas" class="btn btn-default btn-sm" aria-expanded="false">
                                <span class="glyphicon glyphicon-th"></span>
                            </a>
                        </div>
                    </div><div class="collapse navbar-collapse navbar-ex1-collapse">
                        <!-- .nav -->
                        <ul class="nav navbar-nav">
                            <li class="active"><a href="www.grouperubis.com"><i class="glyphicon glyphicon-globe"></i> SITE WEB </a></li>
                            <li class="dropdown ">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="glyphicon glyphicon-list"></i> MENU <b class="caret"></b>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a href="/public/actes_medicaux.php">ACTES MEDICAUX</a></li>
                                    <li><a href="/public/patients.php">PATIENTS</a></li>
                                    <li><a href="/public/pharmacy.php">PHARMACIE</a></li>
                                    <li><a href="/public/personnel.php">PERSONNEL</a></li>
                                </ul>
                            </li>
                        </ul>
                        <!-- /.nav -->
                    </div>
                </div>
                <!-- /.container-fluid -->
            </nav>
            <!-- /.navbar -->
            <header class="head">
                <div class="search-bar">
                    <form class="main-search" action="">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Live Search ...">
                            <span class="input-group-btn">
                                <button class="btn btn-primary btn-sm text-muted" type="button">
                                    <i class="glyphicon glyphicon-search"></i>
                                </button>
                            </span>
                        </div>
                    </form>
                    <!-- /.main-search -->                                </div>
                
                <div class="main-bar">
                    <h5>                        
                        <?= \composants\Utilitaire::breadCrumb($filariane)?>                      
                    </h5>
                    
                </div>
               
            </header>
            <!-- /.head -->
        </div>