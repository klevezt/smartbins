<?php

	// Access: Employee
	// Purpose: View information about the bins
	
require 'includes/functions.php';
require 'includes/emp_functions.php';

is_emp();
emp_page();
SessionData::get();

$bins=select_list_of_bins_sql();

$sql1="SELECT max(timestamp) FROM logfiles WHERE action='103' OR action='110' OR action='112' OR action='118'" ;
$lastUpdate=get_last_update($sql1);


echo"
<ol class='breadcrumb'>
            <li class='breadcrumb-item'>
              <a href='#'>" .  __('Κάδοι')  . "</a>
            </li>
            <li class='breadcrumb-item active'>" .  __('Υπάλληλος')  . "</li>
</ol>";

echo "
 <div class=\"card mb-3\">
            <div class=\"card-header\">
              <i class=\"fas fa-table\"></i>
              ".  __('Λίστα Κάδων')  ."</div>
            <div class=\"card-body\">
              <div class=\"table-responsive\">
                <table class=\"table table-bordered\" id=\"dataTable\" width=\"100%\" cellspacing=\"0\">
                  <thead>
                    <tr>
                      <th>".  __('Αριθμός')  ."</th>
                      <th>".  __('Τοποθεσία')  ."</th>
                      <th>".  __('Οδός')  ."</th>
                      <th>".  __('Πεδίο συναγερμού')  ."</th>
                      <th>".  __('Ημερομηνία Πλυσίματος')  ."</th>
                    </tr>
                  </thead>
                   <tbody>";
	 $list = array();
foreach($bins as $bin ) {
$fact = check_the_button_sql(1);
	$arr=array(
			"id_bin" => $bin->id_bin,
            "lat"    => $bin->lat,
			"lng"    => $bin->lng,
            "description" => $bin->description,
			"alert" => $bin->alert,
			"washDate" => $bin->washDate
			);
	array_push($list,$arr);
	$sql = " SELECT * from stats where timestamp = (SELECT MAX(timestamp) FROM stats WHERE bin_id = :b_id)";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array(':b_id' => $bin->id_bin));
    $stats=$stmt->fetch();

if($stats > $bin->alert) {

        echo '<tr style="background-color:rgb(255, 99, 71);">';
}
else{
    echo '<tr>';
}
if (in_array($bin->id_bin,$fact)) echo  "<td>" . $bin->id_bin. "<span class='badge badge-dark'><i  class='fas fa-exclamation-triangle' style='font-size:20px;color:yellow;'></i></span>  </td>" ;			
		else echo "<td>" . $bin->id_bin. "</td>" ;
    echo            
                    "<td> <a href='https://www.google.gr/maps/place/". $bin->lat.",".$bin->lng."' style='text-decoration: none;color: #343a40;'/>" . $bin->lat.",".$bin->lng.  "</td>" .
                    "<td>" . $bin->description. "</td>" .
                    "<td>" . $bin->alert. "%</td>" .
                    "<td>" . $bin->washDate. "</td>" .
                "</tr>";


}


echo"                  
                  </tbody>
                </table>
              </div>
            </div>
            <div class=\"card-footer small text-muted\">Τελευταία ενημέρωση " .$lastUpdate[0]. "
            
            <div class='float-sm-right'>
                <a href='csv_export_bins.php' class='btn btn-success btn-xl'> ".__('CSV export')."</a>
            </div>
            
            </div>
 </div>

";

adminFooter();
?>

