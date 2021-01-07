<?php

	// Access: Admin
	// Purpose: Update the information about the specified bin

require 'includes/functions.php';
require 'includes/sanitize.class.php';

is_admin();
if ($_SERVER['REQUEST_METHOD'] == "POST") {
	$s = new Sanitize();
	$arr=array();
	$arr = $s->sanitize_value($_POST['id'],$_POST['lat'],$_POST['lng'],$_POST['description'],$_POST['alert'],$_POST['washDate']);
    $id_bin=$arr[0];
	$lat = $arr[1];
    $lng=$arr[2];
    $description=$arr[3];
    $alert=$arr[4];
	$washDate=$arr[5];

    $error=0;
    $error=update_bin_show_errors($lat,$lng,$description,$alert,$washDate);

    if (!$error) {

        $count=update_bin_sql($id_bin,$lat,$lng,$description,$alert,$washDate);

        if ($count){
            logfiles('110');
            SessionData::set(__('Επιτυχής ανανέωση'),'success');
            header("Location: admin_list_of_bins.php");
            exit();
        }else {
            logfiles('111');
            SessionData::set(__('Δεν αλλάξατε κάποιο πεδίο'),'warning');
        }
    }
}


admin_page();
$s = new Sanitize();
$arr=array();
$arr = $s->sanitize_value($_GET['id_bin']);
$id=my_simple_crypt($arr[0],'d');
$sqlGetBin="SELECT * FROM bin WHERE id_bin=:id AND status=1";
$stmt = $conn->prepare($sqlGetBin);
$stmt->execute(array(':id'=>$id));
$bin=$stmt->fetch();

SessionData::get();
echo"
<div class='myForm'>
    <div class='container'>
        <div class='card'>
            <div class='card-header text-center'>" .  __("Επεξεργασία Κάδου")  . "</div>
            <div class='card - body'>
            
                <form method='POST' action='admin_update_bin.php?id_bin=".my_simple_crypt($bin->id_bin,'e')."'>
                
                    <div class='form-group'>
                        <div class='col-md-12'>
		                    <label for='lat'>". __("Γεωγραφικό πλάτος")."</label>
                            <input class='form-control' id='lat' type='text' placeholder='" .__("Γεωγραφικό πλάτος")."' value='".$bin->lat."'  name='lat'  required>
                        </div>
                    </div>
        
                    <div class='form-group'>
                        <div class='col-md-12'>
                            <label for='long'>". __("Γεωγραφικό μήκος")."</label>
                            <input class='form-control' id='long' type='text' placeholder='" .__("Γεωγραφικό μήκος")."' value='".$bin->lng."'  name='lng'  required>
                        </div>
                    </div>   
                    
                    <div class='form-group'>
                        <div class='col-md-12'>
                            <label for='description'>". __("Περιγραφή")."</label>
                            <input class='form-control' id='description' type='text' placeholder='" .__("Περιγραφή")."' value='".$bin->description."'  name='description'  required>
                        </div>
                    </div>   
                    
                    <div class='form-group'>
                        <div class='col-md-12'>
                            <label for='alert'>". __("Πεδίο συναγερμού")."</label>
                            <input class='form-control' id='alert' type='text' placeholder='" .__("Πεδίο συναγερμού")."' value='".$bin->alert."'  name='alert'  required>    
                        </div>
                    </div>
					
					<div class='form-group'>
                        <div class='col-md-12'>
                            <label for='alert'>". __("Ημερομηνία πλυσίματος")."</label>
                            <input class='form-control' id='washDate' type='text' placeholder='" .__("Τελευταίος καθαρισμός")."' value='".$bin->washDate."'  name='washDate'  required>    
                        </div>
                    </div>
                    
                   
                    <div class='form-group'>
                        <div class='col-md-12'>
                            <input type='hidden' name='id' value='".$bin->id_bin."'>    
                            <input class='btn btn-block btn-dark' type='submit' value='" .  __("Ανανέωση")  . "' >
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