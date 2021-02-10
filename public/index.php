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
    $listUser = $controller->getList();
    $agent = new controls\Agent();
    $listAgent = $agent->list();
    $filariane = array(
            'Home' => "/public/",
            'Bienvenue' => ""
        );
    include_once ROOT . DS . "squelette" . DS . "head.php";
    include_once ROOT . DS . "squelette" . DS . "header.php";
    include_once ROOT . DS . "squelette" . DS . "leftNav.php";
    ?>
<div id="content">
    <div class="outer">
        <div class="inner  bg-light lter">
    <div class="showmessages">
        <div class="col-lg-12">
            <?php
                ($session->flash());
            ?> 
        </div>
    </div>
   </div>
    </div>
</div>
<?php
    
        

$config = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "config.php";
$config = str_replace("/", DIRECTORY_SEPARATOR, $config);
include_once $config;
include_once ROOT . DS . "squelette" . DS . "footer.php";
include_once ROOT . DS . "squelette" . DS . "endPage.php";
?>