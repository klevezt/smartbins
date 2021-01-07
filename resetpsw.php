<?php


	// Access: Admin and Employee 
	// Purpose: Reset password

   require 'includes/functions.php';

if(is_logged()) {
    die("Restricted");
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    
    $email=filter_var($_POST['email'], FILTER_SANITIZE_STRING);
    $username=filter_var($_POST['username'], FILTER_SANITIZE_STRING);

    $sql="SELECT email FROM users WHERE email= :email AND status='1' AND username= :username";
    $stmt = $conn->prepare($sql);
	$stmt->execute(array(':email'=>$email, ':username'=>$username));
	$usersCount=$stmt->rowCount();
    if ($usersCount==1) {
        $randPass=randomPassword(12);
        $sql="UPDATE users Set reset=:reset WHERE email=:email and username=:username";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array(':email'=>$email, ':reset'=>$randPass, ':username'=>$username));
        $receive= 'st0889@ece.uowm.gr';
        $subject= __('Επαναφορά κωδικού');
        $body= '<a href="'.APP_URL.'"/Garbage_Management/reset.php?code='.$randPass.'">'.__('Επαναφορά κωδικού').'</a>';
            $headers = "From: " . $receive . "\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=utf-8\r\n";
            $sendMail=mail( $receive, $subject, $body, $headers);
            if ($sendMail) {
                SessionData::set(__('Επιτυχής Αποστολή'),'success');
            }else {
                SessionData::set(__('Αποτυχία Αποστολής'),'danger');
            }
           
           
    }
    else 
    {
        SessionData::set(__('Λάθος email'),'danger');
    }
}
getHead();
SessionData::get();

echo"
<h1 class='text-center'>".__('Επαναφορά Κωδικού')."</h1>
<div class='login'>
<div class=\"container\">
      <div class=\"card\">
        <div class=\"card-header text-center\">".__('Προσθήκη Email επαναφοράς')."</div>
        <div class=\"card-body\">
            
<form method='post' action ='resetpsw.php'>

    <div class= 'form-group '>
        <div class= 'col-md-12'>
            <label for='user'>". __("Όνομα Χρήστη")."</label>
            <input class='form-control' type='text' id='user' placeholder='" .__("Όνομα Χρήστη")."'  name='username'>
        </div> 
    </div>

    <div class= 'form-group '>
        <div class= 'col-md-12'>
            <label for='email'>". __("Email")."</label>
            <input class='form-control' type='text' id='email' placeholder='" .__("Email")."'  name='email'>
        </div> 
    </div>
    
    <div class= 'form-group'>
        <div class='col-md-12'>
            <input type='submit' class='btn btn-block btn-dark' value='".__('Αποστολή Κωδικού')."'>
        </div><br>
		<div class='row'>
			<div class='col-md-2'></div>
			<div class='col-md-8'>
				<a href='index.php' class='btn btn-block btn-dark'>".__('Επιστροφή στην αρχική')."</a>
			</div>
		</div>
    </div>      
</form> 
            </div>
        </div>
    </div>
</div>

";


getFooter();
?>