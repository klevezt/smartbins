<?php

	// Access: Admin
	// Purpose: View the list of the deleted employees
	
require 'includes/functions.php';
is_admin();
admin_page();

$users=select_list_of_emps_sql();

$sql1="SELECT max(timestamp) FROM logfiles WHERE action='106' OR action='108' OR action='114' OR action='116'" ;
$lastUpdate=get_last_update($sql1);

SessionData::get();
echo"
<ol class='breadcrumb'>
            <li class='breadcrumb-item'>
              <a href='#'>" .  __('Υπάλληλοι')  . "</a>
            </li>
            <li class='breadcrumb-item active'>" .  __('Διαχειριστής')  . "</li>
</ol>";

echo "
 <div class=\"card mb-3\">
            <div class=\"card-header\">
              <i class=\"fas fa-table\"></i>
              ".  __('Λίστα Υπαλλήλων')  ."</div>
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
                        <th>".  __('')  ."</th>
                    </tr>
                </thead>
                <tbody>";
		$list = array();

foreach($users as $row ) {
		$arr=array(
			"id" => $row->id,
            "name"    => $row->name,
			"age"    => $row->age,
            "address" => $row->address,
			"username" => $row->username,
			"email" => $row->email
			);
			array_push($list,$arr);
    echo "
              <tr>" .
        "<td>" . $row->name . "</td>" .
        "<td>" . $row->age . "</td>" .
        "<td>" . $row->address . "</td>" .
        "<td>" . $row->username . "</td>" .
        "<td>" . $row->email . "</td>" .
        "<td> 
	                  <a href='admin_update_emp.php?id=".my_simple_crypt( $row->id, 'e' )."' class='btn btn-outline-warning btn-sm'>".  __('Επεξεργασία')  ."</a>
                    </td>" .
        "<td>   
                        <form method='post' action='admin_delete_emp.php' onsubmit='return confirm(\"".__('Σίγουρα θέλετε να διαγράψετε τον χρήστη '.$row->name)."\");'>
                            <div class= 'form-group'>
                                <input type='submit' class='btn btn-outline-danger btn-sm' value='".__('Διαγραφή')."'>
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
            <div class=\"card-footer small text-muted\">Τελευταία ενημέρωση " .$lastUpdate[0]. "
                <div class='float-sm-right'>
                   <a href='csv_export_emps.php' class='btn btn-success btn-xl'> ".__('CSV export')."</a>
                </div>  
            </div>
 </div>

";





adminFooter();
?>