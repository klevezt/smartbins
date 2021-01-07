<?php

	// Access: Admin and Employee
	// Purpose: View map about the bins

require 'includes/functions.php';
require 'includes/emp_functions.php';
check_login();
if (getSession()==0){
	admin_page();
}
else {
	emp_page();
}
SessionData::get();
$sql="SELECT * FROM stats INNER JOIN bin ON bin.id_bin=stats.bin_id WHERE bin.alert<=stats.bin_contend AND timestamp in ( SELECT max(timestamp) FROM stats GROUP by bin_id )  ";
$sss="SET sql_mode='STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION'";
$stmt = $conn->prepare($sss);
$stmt->execute();
$stmt = $conn->prepare($sql);
$stmt->execute();
$bins=$stmt->fetchAll();


echo"
<ol class='breadcrumb'>
            <li class='breadcrumb-item'>
              <a href='#'>" .  __('Χάρτης Κάδων')  . "</a>
            </li>";

if (getSession()==0){
	echo "<li class='breadcrumb-item active'>" .  __('Διαχειριστής')  . "</li>";
}
else {
	echo "<li class='breadcrumb-item active'>" .  __('Υπάλληλος')  . "</li>";
}
		

echo "
	</ol>
     <div class=\"card mb-3\">
                <div class=\"card-header\">
                  <i class=\"fas fa-map\"></i>
                  ".  __('Χάρτης')  ."</div>
                  
                <div class=\"card-body\">
                
                   <div id='mapid' style='height: 400px;'></div>


                 </div>
     </div>
	 
     
           
                   
";

adminFooter();


echo "<script>

	var mymap = L.map('mapid').setView([40.30261704,21.78822701], 14);
";
	foreach($bins as $bin){
		echo " var marker".$bin->bin_id." = L.marker([".$bin->lat.",".$bin->lng."]).addTo(mymap)
			.bindPopup(\"<b> Πληρότητα κάδου : </b>  <u>".$bin->bin_contend."%</u>\");";
	}
echo"
	L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
		maxZoom: 18,
		attribution: 'Map data &copy; <a href=\"https://www.openstreetmap.org/\">OpenStreetMap</a> contributors, ' +
			'<a href=\"https://creativecommons.org/licenses/by-sa/2.0/\">CC-BY-SA</a>, ' +
			'Imagery © <a href=\"https://www.mapbox.com/\">Mapbox</a>',
		id: 'mapbox/streets-v11',
		tileSize: 512,
		zoomOffset: -1
	}).addTo(mymap);

</script>";

?>