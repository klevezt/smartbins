<?php

	// Access: The php files 
	// Purpose: Create header and footer for employee page


require_once "headers.php";

function emp_page(){
    echo "
   <!DOCTYPE html>
<html lang=\"en\">

  <head>

    <meta charset=\"utf-8\">
    <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">
    <meta name=\"description\" content=\"\">
    <meta name=\"author\" content=\"\">

    <title>SmartBins</title>

	<!-- Leaflet -->
	<link rel='stylesheet' href='https://unpkg.com/leaflet@1.6.0/dist/leaflet.css' integrity='sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==' crossorigin=''/>
    <script src='https://unpkg.com/leaflet@1.6.0/dist/leaflet.js' integrity='sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==' crossorigin=''></script>
	
		
    <!-- Bootstrap core CSS-->
    <link href=\"assets/css/bootstrap.min.css\" rel=\"stylesheet\">

    <!-- Custom fonts for this template-->
    <link href=\"assets/fontawesome-free/css/all.min.css\" rel=\"stylesheet\" type=\"text/css\">

    <!-- Page level plugin CSS-->
    <link href=\"assets/css/dataTables.bootstrap4.min.css\" rel=\"stylesheet\">

    <!-- Custom styles for this template-->
    <link href=\"assets/css/sb-admin.min.css\" rel=\"stylesheet\">
    
    <!-- Chart.js cdn-->
    <script src='https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.bundle.js'></script>
    
  </head>

  <body id=\"page-top\">

    <nav class=\"navbar navbar-expand navbar-dark bg-dark static-top\">

      <a class=\"navbar-brand mr-1\" href=\"emp_index.php\">SmartBins</a>

      <button class=\"btn btn-link btn-sm text-white order-1 order-sm-0\" id=\"sidebarToggle\" href=\"#\">
        <i class=\"fas fa-bars\"></i>
      </button>



      <!-- Navbar -->
      <ul class=\"navbar-nav ml-auto \">

        <li class=\"nav-item dropdown no-arrow\">
          <a class=\"nav-link dropdown-toggle\" href=\"#\" id=\"userDropdown\" role=\"button\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
            <i class=\"fas fa-user-circle fa-fw\"></i>
          </a>
		  
          <div class=\"dropdown-menu dropdown-menu-right\" aria-labelledby=\"userDropdown\">
            <a class='dropdown-item' href='logout.php' ><span class='fas fa-sign-out-alt'></span>" . __('Εξοδος') . "</a>
          </div>
          
        </li>
      </ul>

    </nav>

    <div id=\"wrapper\">
      <!-- Sidebar -->
      <ul class=\"sidebar navbar-nav\">
        <li class=\"nav-item\">
          <a class=\"nav-link\" href=\"emp_index.php\">
            <i class=\"fab fa-adn\"></i>
            <span>" .  __('Αρχική')  . "</span>
          </a>
        </li>
		
        <li class=\"nav-item dropdown\">
          <a class=\"nav-link dropdown-toggle\" href=\"#\" id=\"pagesDropdown\" role=\"button\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
            <i class=\"fas fa-clipboard	\"></i>
            <span>" .  __('Κάδοι')  . "</span>
          </a>
          <div class=\"dropdown-menu\" aria-labelledby=\"pagesDropdown\">
            <h6 class=\"dropdown-header\">" .  __('Λειτουργίες:')  . "</h6>
            <a class=\"dropdown-item\" href='emp_list_of_bins.php'>" .  __('Λίστα Κάδων')  . "</a>
            <a class=\"dropdown-item\" href='emp_deleted_list_of_bins.php'>" .  __('Απενεργοποιημένοι')  . "</a>

          </div>
        </li>
        
        <li class=\"nav-item dropdown\">
          <a class=\"nav-link dropdown-toggle\" href=\"#\" id=\"pagesDropdown\" role=\"button\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
            <i class=\"fas fa-archive\"></i>
            <span>" .  __('Πίνακες Στατιστικών')  . "</span>
          </a>
          <div class=\"dropdown-menu\" aria-labelledby=\"pagesDropdown\">
            <h6 class=\"dropdown-header\">" .  __('Στατιστικά:')  . "</h6>
            <a class=\"dropdown-item\" href='emp_stats_tables.php'>" .  __('Γενικοί Πίνακες')  . "</a>
			
          </div>
        </li>
        
        <li class=\"nav-item dropdown\">
          <a class=\"nav-link dropdown-toggle\" href=\"#\" id=\"pagesDropdown\" role=\"button\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
            <i class=\"fas fa-archive\"></i>
            <span>" .  __('Περισσότερα')  . "</span>
          </a>
          <div class=\"dropdown-menu\" aria-labelledby=\"pagesDropdown\">
            <h6 class=\"dropdown-header\">" .  __('Δυνατότητες:')  . "</h6>

			<a class=\"dropdown-item\" href='map.php'>" .  __('Χάρτης Κάδων')  . "</a>
          </div>
        </li>
        
      </ul>
        <div id=\"content-wrapper\">
            <div class=\"container-fluid\">
      
          ";
}

function empFooter(){
    echo"
    </div>
        <!-- /.container-fluid -->
        
        <!-- Sticky Footer -->
        <footer class=\"sticky-footer\">
          <div class=\"container my-auto\">
            <div class=\"copyright text-center my-auto\">
              <span>Copyright © Laboratory of Digital Systems and Computer Architecture ". date('Y') ."</span>
            </div>
          </div>
        </footer>
        

      </div>
      <!-- /.content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- scroll to top -->
    <a class=\"scroll-to-top rounded\" href=\"#page-top\">
      <i class=\"fas fa-angle-up\"></i>
    </a>

    

    <!-- Bootstrap js-->
    <script src=\"assets/js/jquery.min.js\"></script>
    <script src=\"assets/js/bootstrap.bundle.min.js\"></script>

    <!-- Core plugin JavaScript-->
    <script src=\"assets/js/jquery.easing.min.js\"></script>
    
    
    <!-- Custom scripts-->
    <script src=\"assets/js/sb-admin.min.js\"></script>
    
    <!-- table plugin JavaScript-->
    <script src=\"assets/js/jquery.dataTables.min.js\"></script>
    <script src=\"assets/js/dataTables.bootstrap4.min.js\"></script>
    
    <!-- user plugin -->
    <script src=\"assets/js/datatables-demo.js\"></script>
    
    
    



  </body>
 
</html>
    ";
}

?>