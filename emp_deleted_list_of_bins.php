<?php

	// Access: Employee
	// Purpose: View the list of the deleted bins

require 'includes/functions.php';
require 'includes/emp_functions.php';

is_emp();
emp_page();

$bins=select_deleted_bins_sql();

$sql1="SELECT max(timestamp) FROM logfiles WHERE action='118' OR action='112'" ;
$lastUpdate=get_last_update($sql1);

SessionData::get();
echo"
<ol class='breadcrumb'>
            <li class='breadcrumb-item'>
              <a href='#'>" .  __(' Απενεργοποιημένοι Κάδοι')  . "</a>
            </li>
            <li class='breadcrumb-item active'>" .  __('Διαχειριστής')  . "</li>
</ol>
 <div class=\"card mb-3\">
            <div class=\"card-header\">
              <i class=\"fas fa-table\"></i>
              ".  __('Λίστα Απενεργοποιημένων Κάδων')  ."</div>
            <div class=\"card-body\">
              <div class=\"table-responsive\">
                <table class=\"table table-bordered\" id=\"dataTable\" width=\"100%\" cellspacing=\"0\">
                  <thead>
                    <tr>
                      <th>".  __('Αριθμός')  ."</th>
                      <th>".  __('Τοποθεσία')  ."</th>
                      <th>".  __('Οδος')  ."</th>
                      <th>".  __('Πεδίο συναγερμού')  ."</th>
                      <th>".  __('Ημερομηνία Πλυσίματος')  ."</th>                      
                    </tr>
                  </thead>
                   <tbody>";
foreach($bins as $bin ) {
    echo"<tr>" .
			"<td>" . $bin->id_bin. "</td>" .
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
            <div class=\"card-footer small text-muted\">Τελευταία ενημέρωση " .$lastUpdate[0]. "</div>
 </div>

";



empFooter();
?>

