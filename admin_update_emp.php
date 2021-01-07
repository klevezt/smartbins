<?php

	// Access: Admin
	// Purpose: Update the personal information of the specified employee

require 'includes/functions.php';
require 'includes/sanitize.class.php';
is_admin();
if ($_SERVER['REQUEST_METHOD'] == "POST") {
	$s = new Sanitize();
	$arr=array();
	$arr = $s->sanitize_value($_POST['id'],$_POST['name'],$_POST['age'],$_POST['address'],$_POST['username'],$_POST['email'],$_POST['old_username'],$_POST['old_email'],$_POST['role']);
    $id=$arr[0];
	$name = $arr[1];
    $age=$arr[2];
    $address=$arr[3];
    $username=$arr[4];
    $email=$arr[5];
    $old_username=$arr[6];
    $old_email=$arr[7];
    $role=$arr[8];
	$error=0;
    $error=update_emp_show_errors($name,$age,$address,$username,$email,$password,$confirm_password,$role);

    if ($old_username!=$username) {

        $countUniqueUser=select_unique_username($username);;

        if( $countUniqueUser>0){
            logfiles('109');
            SessionData::set(__('Τo username υπάρχει ήδη'),'danger');
            $error=1;
        }
    }

    if ($old_email!=$email) {

        $countUniqueEmail=select_unique_email($email);

        if( $countUniqueEmail>0){
            logfiles('109');
            SessionData::set(__('Τo Email υπάρχει ήδη'),'danger');
            $error=1;
        }
    }

    if ($error == 0) {
		
		$sql="UPDATE users Set name=:name, age=:age, address=:address, username=:username , email=:email WHERE id=:id";
        if($role=='Yes') $sql="UPDATE users Set name=:name, age=:age, address=:address, username=:username , email=:email, role='Yes' WHERE id=:id";
				
		$stmt = $conn->prepare($sql);
		$stmt->execute(array(':name'=>$name,':age'=>$age, ':address'=>$address, ':username'=>$username, ':email'=>$email, ':id'=>$id));
		
        $count=$stmt->rowCount();

        if ($count){

            logfiles('108');
            SessionData::set(__('Επιτυχής ανανέωση'),'success');
            header("Location: admin_list_of_emps.php");
            exit();

        }else {

            logfiles('109');
            SessionData::set(__('Δεν αλλάξατε κάποιο πεδίο'),'warning');
        }
    }
}

admin_page();

$get=filter_var($_GET['id'], FILTER_SANITIZE_STRING);
$id=my_simple_crypt( $get, 'd' );
$sqlGetUser="SELECT * FROM users WHERE id=:id AND status=1";
$stmt = $conn->prepare($sqlGetUser);
$stmt->execute(array(':id'=>$id));
$user=$stmt->fetch();

SessionData::get();
echo"
<div class='myForm'>
    <div class='container'>
        <div class='card'>
            <div class='card-header text-center'>" .  __("Επεξεργασία Χρήστη")  . "</div>
            <div class='card - body'>

                <form method='POST' action='admin_update_emp.php?id=".my_simple_crypt($user->id,'e')."'>

                    <div class='form-group'>
                        <div class='col-md-12'>
                            <label for='name'>" . __("Όνομα")."</label>
                            <input id='name' class='form-control' type='text' placeholder='" .__("Όνομα")."' name='name' value='".$user->name."' required>
                        </div>
                    </div>

                    <div class='form-group'>
                        <div class='col-md-12'>
                            <label for='age'>". __("Ηλικία")."</label>
                            <input class='form-control' id='age' type='text' placeholder='" .__("Ηλικία")."' name='age' value='".$user->age."'  required>
                        </div>
                    </div>

                    <div class='form-group'>
                        <div class='col-md-12'>
                            <label for='address'>". __("Διεύθυνση")."</label>
                            <input class='form-control' id='address' type='text' placeholder='" .__("Διεύθυνση")."' name='address' value='".$user->address."'  required>
                        </div>
                    </div>

                    <div class='form-group'>
                        <div class='col-md-12'>
                            <label for='username'>". __("Όνομα Χρήστη")."</label>
                            <input class='form-control' id='username' type='text' placeholder='" .__("Όνομα Χρήστη")."' name='username' value='".$user->username."' required>
                        </div>
                    </div>

                    <div class='form-group'>
                        <div class='col-md-12'>
                            <label for='email'>". __("Email")."</label>
                            <input class='form-control' id='email' type='text' placeholder='" .__("Email")."' name='email' value='".$user->email."' required>
                        </div>
                    </div>

                    <div class='form-group'>
                        <div class='col-md-6'> 
                            <div class='form-check'>
                                <input type='hidden' name='id' value='".$user->id."'>
                                <input type='hidden' name='old_username' value='".$user->username."'>
                                <input type='hidden' name='old_email' value='".$user->email."'>";
								if($user->role=='1'){
									echo "
									<input type='checkbox' class='form-check-input' name='role' value='Yes'>
									<label class='form-check-label' >" .__("Προσθήκη ως διαχειριστή")."</label> ";
								}
								echo"								
                            </div>
                        </div>
                    </div>

                    <div class='form-group'>
                        <div class='col-md-12'>
                            <input class='btn btn-block btn-dark' type='submit' value='" .  __("Ανανέωση") . "' >
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