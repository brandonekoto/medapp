<?php  
    $config = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "config.php";
    $config = str_replace("/", DIRECTORY_SEPARATOR, $config);
    include_once $config;
    $controller = new \controls\User();
    include_once ROOT . DS . "squelette" . DS . "head.php";
    ?>
<body class="login">

      <div class="form-signin">
    <div class="text-center">
        <img src="assets/img/logococo.png" alt="" style="width:120px; height: 65px; padding: 5px">
        <br><span>MedApp | HM</span>
    </div>
    <hr>
    <div class="tab-content">
        <div id="login" class="tab-pane active">
            <form action="/controls/control.php?mod=user&act=login" method="POST">
                <div class="col-lg-12 text-center">
                        <?php
                        ($session->flash());
                        ?> 
                    </div>
                <p class="text-muted text-center">
                    Entrez votre username et votre mot de passe
                </p>
                <input type="text" placeholder="Username" name="username" class="form-control top">
                <input type="password" placeholder="Mot de passe" name="pwd" class="form-control bottom">
                <div class="checkbox">
		  <label>
		    <input type="checkbox"> Remember Me
		  </label>
		</div>
                <button class="btn btn-lg btn-primary btn-block" type="submit">Connecter</button>
            </form>
        </div>
        <div id="forgot" class="tab-pane" >
            <form action="/controls/control.php?mod=user&act=" method="POST" >
                <p class="text-muted text-center">Entrez votre email valide</p>
                <input type="email" placeholder="mail@domain.com" class="form-control">
                <br>
                <button class="btn btn-lg btn-danger btn-block" type="submit">Recover Password</button>
            </form>
        </div>
        <div id="signup" class="tab-pane">
            <form action="index.html">
                <input type="text" placeholder="username" class="form-control top">
                <input type="email" placeholder="mail@domain.com" class="form-control middle">
                <input type="password" placeholder="password" class="form-control middle">
                <input type="password" placeholder="re-password" class="form-control bottom">
                <button class="btn btn-lg btn-success btn-block" type="submit">Register</button>
            </form>
        </div>
    </div>
    <hr>
    <div class="text-center">
        <ul class="list-inline">
            <!--
            <li><a class="text-muted" href="#forgot" data-toggle="tab">Probleme de connexion</a></li>
            <li><a class="text-muted" href="#signup" data-toggle="tab">Créer un compte</a></li>-->
        </ul>
    </div>
  </div>


    <!--jQuery -->
    <script src="assets/lib/jquery/jquery.js"></script>

    <!--Bootstrap -->
    <script src="assets/lib/bootstrap/js/bootstrap.js"></script>


    <script type="text/javascript">
        (function($) {
            $(document).ready(function() {
                $('.list-inline li > a').click(function() {
                    var activeForm = $(this).attr('href') + ' > form';
                    //console.log(activeForm);
                    $(activeForm).addClass('animated fadeIn');
                    //set timer to 1 seconds, after that, unload the animate animation
                    setTimeout(function() {
                        $(activeForm).removeClass('animated fadeIn');
                    }, 1000);
                });
            });
        })(jQuery);
    </script>
</body>

</html>
