<?php  
    $config = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "config.php";
    $config = str_replace("/", DIRECTORY_SEPARATOR, $config);
    include_once $config;
    if(isset($_SESSION['data'])){
        extract($_SESSION['data']);
    }
    include_once ROOT . DS . "squelette" . DS . "head.php";
    include_once ROOT . DS . "squelette" . DS . "header.php";
    include_once ROOT . DS . "squelette" . DS . "leftNav.php";
?>
                <div id="content">
                    <div class="main-bar">
                        <h3>
                            <i class="fa fa-dashboard"></i>&nbsp;
                            FONCTION
                        </h3>
                        <div class="box-options">
                            <a href="/public/fonction.php?action=add" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> </a>
                            <a href="/public/fonction.php?action=del" class="btn btn-primary"><span class="glyphicon glyphicon-print"></span> </a>
                        </div>
                    </div>
                    
                    <?php
                    
                        if(isset($_GET['action'])){
                            switch ($_GET['action']){
                                case 'add':?>
                    <div id="div-1" class="body collapse in col-lg-8" aria-expanded="true" style="">
                        <form class="form-horizontal" action="/controls/control.php?mod=fonction&act=add" method="POST" enctype="multipart/form-data">
                                        
                                        <div class="form-group">
                                            <label for="text1" class="control-label col-lg-4">Libelé</label>

                                            <div class="col-lg-8">
                                                <input type="text" id="text1" name="libele" placeholder="Libelé fonction" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-lg-12">
                                                <button class="btn btn-success">
                                                    <span class="glyphicon glyphicon-save">
                                                         
                                                    </span>
                                                    Ajouter
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
                                case 'view':?>
                    <div class="col-lg-12 col-md-12">
                        <div class="col-lg-3">
                            <div class="wrapImgProfile">
                                <img src="/img/personnel/10981441_932904300076295_8167041328504341445_n.jpg" />
                            </div>
                        </div>
                        <div class="col-lg-9">
                            <table class="table">
                            </table>
                            
                        </div>
                        
                    </div>
                    <div class="clearfix"><br>
                        <br></div>
                    
                    <?php
                                break;
                                    
                                    
                            }
                        }else{
                            $controller;
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
                                                <th>Id</th>
                                                <th>Libelé</th>
                                                <th>&nbsp;</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php                                            
                                            $count =  0;
                                            foreach ($fonctions as $key => $fonction) {?>
                                            <tr>
                                                <td><?= $count ?></td>
                                                <td><a href="/controls/control.php?mod=fonction&act=view&id=<?= $fonction->idFonction?>" > </a></td>
                                                <td><?= $fonction->libele ?></td>
                                                <td><a href="/controls/control.php?mod=fonction&act=del&id=<?= $fonction->idFonction?>" >    </a></td>
                                                
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
                    <!-- /.outer -->
                </div>


<?php
$config = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "config.php";
$config = str_replace("/", DIRECTORY_SEPARATOR, $config);
include_once $config;

include_once ROOT . DS . "squelette" . DS . "footer.php";
include_once ROOT . DS . "squelette" . DS . "endPage.php";
?>