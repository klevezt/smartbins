<?php

	// Access: Admin
	// Purpose: Add new bin

require 'includes/functions.php';
require 'includes/sanitize.class.php';
is_admin();
if ($_SERVER['REQUEST_METHOD'] == "POST") {
	
	$s = new Sanitize();
	$arr=array();
	$arr = $s->sanitize_value($_POST['lat'],$_POST['lng'],$_POST['description'],$_POST['alert'],$_POST['washDate']);
    $lat = $arr[0];
    $lng=$arr[1];
    $description=$arr[2];
    $alert=$arr[3];
	$washDate=$arr[4];
	$error=0;
    $error=bin_show_errors($lat,$lng,$description,$alert,$washDate);

    if ($error == 0) {
        $count = bin_add_sql($lat,$lng,$description,$alert,$washDate);

        if ($count) {
            logfiles('103');
            SessionData::set(__('Επιτυχής Προσθήκη'), 'success');
            header("Location: admin_list_of_bins.php");
            exit();
        } else {
            logfiles('104');
            SessionData::set(__('Αποτυχία Προσθήκης Κάδου'), 'danger');
        }

    }
}



admin_page();
SessionData::get();
echo"
<div class='myForm'>
    <div class='container'>
        <div class='card'>
            <div class='card-header text-center'>" .  __("Προσθήκη Νέου Κάδου")  . "</div>
            <div class='card - body'>
            
                <form method='POST' action='admin_add_new_bin.php'>
                
                    <div class='form-group'>
                        <div class='col-md-12'>
		                    <label for='lat'>". __("Γεωγραφικό πλάτος")."</label>
                            <input class='form-control' id='lat' type='text' placeholder='" .__("Γεωγραφικό πλάτος")."'  name='lat'  required>
                        </div>
                    </div>
        
                    <div class='form-group'>
                        <div class='col-md-12'>
                            <label for='long'>". __("Γεωγραφικό μήκος")."</label>
                            <input class='form-control' id='long' type='text' placeholder='" .__("Γεωγραφικό μήκος")."'  name='lng'  required>
                        </div>
                    </div>   
                    
                    <div class='form-group'>
                        <div class='col-md-12'>
                            <label for='description'>". __("Περιγραφή")."</label>
                            <input class='form-control' id='description' type='text' placeholder='" .__("Περιγραφή")."'  name='description'  required>
                        </div>
                    </div>   
                    
                    <div class='form-group'>
                        <div class='col-md-12'>
                            <label for='alert'>". __("Πεδίο συναγερμού")."</label>
                            <input class='form-control' id='alert' type='text' placeholder='" .__("Πεδίο συναγερμού")."'  name='alert'  required>    
                        </div>
                    </div>
                    
                   
                    <div class='form-group'>
                        <div class='col-md-12'>
                          <input class='btn btn-block btn-dark' type='submit' value='" .  __("Προσθήκη Νέου")  . "' >
                        </div>
                    </div> 
                       
                </form>
            </div>
        </div>
    </div>
</div>
          
";

adminFooter();
?>