<?php

	// Access: Admin
	// Purpose: View the list of the deleted employees
	
require 'includes/functions.php';
is_admin();
admin_page();

$users=select_deleted_emps_sql();

$sql1="SELECT max(timestamp) FROM logfiles WHERE action='114' OR action='116'" ;
$lastUpdate=get_last_update($sql1);

SessionData::get();
echo"
<ol class='breadcrumb'>
            <li class='breadcrumb-item'>
              <a href='#'>" .  __(' Απενεργοποιημένοι Υπάλληλοι')  . "</a>
            </li>
            <li class='breadcrumb-item active'>" .  __('Διαχειριστής')  . "</li>
</ol>";

echo "
 <div class=\"card mb-3\">
            <div class=\"card-header\">
              <i class=\"fas fa-table\"></i>
              ".  __('Λίστα Απενεργοποιημένων Υπαλλήλων')  ."</div>
            <div class=\"card-body\">
              <div class=\"table-responsive\">
                <table class=\"table table-bordered\" id=\"dataTable\" width=\"100%\" cellspacing=\"0\">
                  <thead>
                    <tr>
                        <th>".  __('Ονοματεπώνυμο')  ."</th>
                        <th>".  __('Ηλικία')  ."</th>
                        <th>".  __('Διεύθυνση')  ."</th>
                        <th>".  __('Όνομα χρήστη')  ."</th>
                        <th>".  __('Email')  ."</th>
                        <th>".  __('')  ."</th>
                        
                    </tr>
                </thead>
                <tbody>";
foreach ($users as $row){
    echo "
              <tr>" .
        //"<td>" . $row->id. "</td>" .
        "<td>" . $row->name . "</td>" .
        "<td>" . $row->age . "</td>" .
        "<td>" . $row->address . "</td>" .
        "<td>" . $row->username . "</td>" .
        "<td>" . $row->email . "</td>" .
        "<td>   
                        <form method='post' action='admin_reset_emp.php' onsubmit='return confirm(\"".__('Σίγουρα θέλετε να επαναφέρετε τον χρήστη '.$row->name)."\");'>
                            <div class= 'form-group'>
                                <input type='submit' class='btn btn-outline-warning btn-sm' value='".__('Επαναφορά')."'>
                                <input type='hidden' name='user_id' value='".$row->id."'>
                            </div>
                        </form>
                    </td>" .
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





adminFooter();
?>


