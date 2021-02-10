    <script src="assets/lib/jquery/jquery.js"></script>


    <!--Bootstrap -->
    <script src="assets/lib/bootstrap/js/bootstrap.js"></script>
    <!-- MetisMenu -->
    <script src="assets/lib/metismenu/metisMenu.js"></script>
    <!-- onoffcanvas -->
    <script src="assets/lib/onoffcanvas/onoffcanvas.js"></script>
    <!-- Screenfull -->
    <script src="assets/lib/screenfull/screenfull.js"></script>
    <script src="assets/lib/node_modules/@fancyapps/fancybox/dist/jquery.fancybox.min.js"></script>
    <script src="assets/js/mdeautocomplete.js"></script>
    <!-- Metis core scripts -->
    <script src="assets/js/core.js"></script>
    <!-- Metis demo scripts -->
    <script src="assets/js/app.js"></script>


    <script src="assets/js/style-switcher.js"></script>
    <script src="assets/js/jqueryui.js"></script>
    
    <script src="assets/js/rubis.js"></script>
    <script src="assets/lib/messagebox.js"></script>
    <script src="assets/lib/loadingoverlay.js"></script>
    </body>

</html>
<?php
    if(isset($_SESSION['data'])){
        unset($_SESSION['data']);
    }