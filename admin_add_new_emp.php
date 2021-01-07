<?php

	// Access: Admin
	// Purpose: Add new employee

require 'includes/functions.php';
require 'includes/sanitize.class.php';

is_admin();
if ($_SERVER['REQUEST_METHOD'] == "POST") {
	
	$s = new Sanitize();
	$arr=array();
	$arr = $s->sanitize_value($_POST['name'],$_POST['age'],$_POST['address'],$_POST['username'],$_POST['email'],$_POST['password'],$_POST['confirm_password'],$_POST['role']);
    $name = $arr[0];
    $age=$arr[1];
    $address=$arr[2];
    $username=$arr[3];
    $email=$arr[4];
    $password=$arr[5];
    $confirm_password=$arr[6];
    $role=$arr[7];

    $error=emp_show_errors($name,$age,$address,$username,$email,$password,$confirm_password,$role);
    $countUniqueUser=select_unique_username($username);

    if( $countUniqueUser>0){
        logfiles('107');
        SessionData::set(__('Τo username υπάρχει ήδη'),'danger');
        $error=1;
    }

    $countUniqueEmail=select_unique_email($email);
    if( $countUniqueEmail>0){
        logfiles('107');
        SessionData::set(__('Τo email υπάρχει ήδη'),'danger');
        $error=1;

    }

   if ($error==0 && $role!='Yes') {

        $count1=emp_add_sql($name,$age,$address,$username,$email,$password,$confirm_password,$role);

        if ($count1){

            logfiles('106');
            SessionData::set(__('Επιτυχής προσθήκη υπαλλήλου'),'success');
            header("Location: admin_list_of_emps.php");
            exit();

        }else {

            logfiles('107');
            SessionData::set(__('Αποτυχία προσθήκης υπαλλήλου'),'danger');
        }
    }
    if ($error==0 && $role=='Yes') {

        $count2=emp_add_sql($name,$age,$address,$username,$email,$password,$confirm_password,$role);

        if ($count2){
            logfiles('106');
            SessionData::set(__('Επιτυχής προσθήκη υπαλλήλου ως διαχειριστή'),'success');

            header("Location: admin_list_of_emps.php");
            exit();
        }
        else {
            logfiles('107');
            SessionData::set(__('Αποτυχία προσθήκης υπαλλήλου ως διαχειριστή '),'danger');
        }
    }

}
admin_page();
SessionData::get();
echo"
<div class='myForm'>
    <div class='container'>
        <div class='card'>
            <div class='card-header text-center'>" .  __("Προσθήκη Νέου Χρήστη")  . "</div>
            <div class='card - body'>
            
                <form method='POST' action='admin_add_new_emp.php' >
                
                    <div class='form-group'>
                        <div class='col-md-12'>
		                    <label for='name'>" .  __("Ονοματεπώνυμο")  . "</label>
                            <input class='form-control' id='name' type='text' placeholder='" .  __("Ονοματεπώνυμο")  . "' name='name' required>
                        </div>
                    </div>
        
                    <div class='form-group'>
                        <div class='col-md-12'>
                            <label for='age'>". __("Ηλικία")."</label>
                            <input class='form-control' id='age' type='text' placeholder='" .__("Ηλικία")."' name='age'  required>
                        </div>
                    </div>   
                    
                    <div class='form-group'>
                        <div class='col-md-12'>
                            <label for='address'>". __("Διεύθυνση")."</label>
                            <input class='form-control' id='address' type='text' placeholder='" .__("Διεύθυνση")."' name='address'  required>
                        </div>
                    </div>   
                    
                    <div class='form-group'>
                        <div class='col-md-12'>
                            <label for='username'>". __("Όνομα Χρήστη")."</label>
                            <input class='form-control' id='username' type='text' placeholder='" .__("Όνομα Χρήστη")."' name='username' required>
                        </div>
                    </div>
                    
                    <div class='form-group'>
                        <div class='col-md-12'>
                            <label for='email'>". __("Email")."</label>
                            <input class='form-control' id='email' type='text' placeholder='" .__("Email")."' name='email' required> 
                        </div>
                    </div>
                    
                    <div class='form-group'>
                        <div class='col-md-12'>
                            <label for='password'>". __("Κωδικός")."</label>
                            <input class='form-control' id='password' type='text' placeholder='" .__("Κωδικός")."' name='password'  required>
                        </div>
                    </div>
                    
                    <div class='form-group'>
                        <div class='col-md-12'>
                            <label for='confirm_password'>". __("Επιβεβαίωση Κωδικού")."</label>
                            <input class='form-control' id='confirm_password' type='text' placeholder='" .__("Κωδικός")."' name='confirm_password' required>
                        </div>
                    </div>
                   
                    <div class='form-group'>
                        <div class='col-md-6'>
                            <div class='form-check'>
                                <input type='checkbox' class='form-check-input' name='role' value='Yes'>
                                <label class='form-check-label' >" .__("Προσθήκη ως διαχειριστή")."</label>
                            </div>
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

<script>
$(document).ready(function(){ 
    $('input').attr('autocomplete', 'off'); 
});
</script>

