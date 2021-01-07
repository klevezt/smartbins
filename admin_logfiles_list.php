<?php

	// Access: Admin
	// Purpose: View the logfiles of the website
	
require 'includes/functions.php';
is_admin();
admin_page();
SessionData::get();

$logs=select_logfiles_sql();

$sql="SELECT max(timestamp) FROM logfiles " ;
$lastUpdate=get_last_update($sql);

echo"
<ol class='breadcrumb'>
            <li class='breadcrumb-item'>
              <a href='#'>" .  __('Κάδοι')  . "</a>
            </li>
            <li class='breadcrumb-item active'>" .  __('Διαχειριστής')  . "</li>
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
                      <th>".  __('Όνομα χρήστη')  ."</th>
                      <th>".  __('ΙΡ')  ."</th>
                      <th>".  __('Ημερομηνία')  ."</th>
                      <th>".  __('Ενέργεια')  ."</th>
                    </tr>
                  </thead>
                   <tbody>";
foreach($logs as $log ){

    $action= $logfile[$log->action];
    if($log->username==""){
        $username='Μη καταχωρημένο όνομα χρήστη';
    }else
        $username=$log->username;

    echo"
    <tr>
        <td>" .$username. "</td>
        <td>" .$log->ip. "</td>
        <td>" .$log->timestamp. "</td>
        <td>" .$action. "</td> 
	                  
    </tr>";


}

    echo "                  
                  </tbody>
                </table>
              </div>
            </div>
            <div class=\"card-footer small text-muted\">Τελευταία ενημέρωση " .$lastUpdate[0]. "</div>
 </div>

";
adminFooter();
?>