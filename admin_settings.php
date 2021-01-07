<?php

	// Access: Admin
	// Purpose: View and update the administrator's profile
	
require 'includes/functions.php';
is_admin();
if ($_SERVER['REQUEST_METHOD'] == "POST") {
	$s = new Sanitize();
	$arr=array();
	$arr = $s->sanitize_value($_POST['id'],$_POST['username'],$_POST['name'],$_POST['email'],$_POST['address'],$_POST['age'],$_POST['old_email'],$_POST['old_username']);
    $id=$arr[0];
    $username=$arr[1];
    $name=$arr[2];
    $email=$arr[3];
    $address=$arr[4];
    $age=$arr[5];
    $old_email=$arr[6];
    $old_username=$arr[7];
	$error=0;
	$error=emp_show_errors_website($name,$age,$address,$username,$email,$password,$confirm_password,$role);


    if ($old_username!=$username) {
        $countUniqueUser=select_unique_username($username);

        if( $countUniqueUser>0){
            logfiles('121');
            SessionData::set(__('Τo username υπαρχει ηδη'),'danger');
            $error=1;
        }
    }

    if ($old_email!=$email) {
        $countUniqueEmail=select_unique_email($email);

        if( $countUniqueEmail>0){
            logfiles('109');
            SessionData::set(__('Τo Email υπαρχει ηδη'),'danger');
            $error=1;
        }
    }

    if ($error==0){

        $count=update_users_sql($id,$name,$age,$address,$username,$email,$old_username,$old_email);

        if ($count){
            logfiles('120');
            SessionData::set('Επιτυχης ανανέωση','success');
        }else {
            logfiles('121');
            SessionData::set('Δεν αλλάξατε κάποιο πεδίο','warning');
        }

    }
}

$idGetUser=$_SESSION['userid'];
$sqlGetUser="SELECT * FROM users WHERE id=:id ";
$stmt = $conn->prepare($sqlGetUser);
$stmt->execute(array(':id' => $idGetUser));
$user=$stmt->fetch();

admin_page();
SessionData::get();
echo"
<div class='myForm'>
    <div class='container'>
        <div class='card'>
            <div class='card-header text-center'>" .  __("Επεξεργασία προφίλ διαχειριστή")  . "</div>
            <div class='card-body'>

                <form method='POST' action='admin_settings.php'>

                    <div class='form-group'>
                        <div class='col-md-12'>
                            <label for='name'>" .  __("Όνοματεπωνυμο")  . "</label>
                            <input class='form-control' id='name' type='text' placeholder='" .  __("Όνοματεπωνυμο")  . "' name='name' value='".$user->name."' required>
                        </div>
                    </div>

                    <div class='form-group'>
                        <div class='col-md-12'>
                            <label for='age'>". __("Ηλικια")."</label>
                            <input class='form-control' id='age' type='text' placeholder='" .__("Ηλικια")."' name='age' value='".$user->age."'  required>
                        </div>
                    </div>

                    <div class='form-group'>
                        <div class='col-md-12'>
                            <label for='address'>". __("Διευθυνση")."</label>
                            <input class='form-control' id='address' type='text' placeholder='" .__("Διευθυνη")."' name='address' value='".$user->address."'  required>
                        </div>
                    </div>

                    <div class='form-group'>
                        <div class='col-md-12'>
                            <label for='username'>". __("Ονομα Χρηστη")."</label>
                            <input class='form-control' id='username' type='text' placeholder='" .__("Ονομα Χρηστη")."' name='username' value='".$user->username."' required>
                        </div>
                    </div>

                    <div class='form-group'>
                        <div class='col-md-12'>
                            <label for='email'>". __("Email")."</label>
                            <input class='form-control' id='email' type='text' placeholder='" .__("Email")."' name='email' value='".$user->email."'  required>
                        </div>
                    </div>

                    <div class='form-group'>
                        <div class='col-md-12'>
                            <input type='hidden' name='id' value='".$_SESSION['userid']."'>
                            <input type='hidden' name='old_email' value='".$user->email."'>
                            <input type='hidden' name='old_username' value='".$user->username."'>
                            <input class='btn btn-block btn-dark' type='submit' value='" .  __("Υποβολή")  . "' > 
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