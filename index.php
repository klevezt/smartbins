<?php

	// Access: Anyone 
	// Purpose: Login Page

	require 'includes/functions.php';
	require 'includes/sanitize.class.php';
	if(is_logged()){
		if($_SESSION['role']==0) header("location: admin_index.php");
		else  header("location: emp_index.php");
		
	} 

if ($_SERVER['REQUEST_METHOD'] == "POST") {
	
	$s = new Sanitize();
	$arr=array();
	$arr = $s->sanitize_value($_POST['uname'],$_POST['psw']);
    $uname = $arr[0];
    $psw=$arr[1];
	
	
    $sql="SELECT * FROM users WHERE username= :username and password= :password and status!=0";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array(':username'=>$uname,':password'=>hash('sha256',$psw)));
    $usersCount=$stmt->rowCount();

    if ($usersCount==1) {

        $user = $stmt->fetch();
        $_SESSION['userid']=$user->id;
        $_SESSION['name']=$user->name;
        $_SESSION['role']=$user->role;
        $_SESSION['status']=$user->status;
        $_SESSION['time']=time();


        if ($_SESSION['role']==1){
            logfiles('101');
            header("Location: emp_index.php");
            exit;

        }elseif($_SESSION['role']==0){
            logfiles('101');
            header("Location: admin_index.php");
            exit;
        }

    }else{

        $sql="SELECT * FROM users WHERE username= :username";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array(':username'=>$uname));
        $user = $stmt->fetch();
        $usersCount=select_unique_username($uname);
        $sql="INSERT INTO logfiles (ip ,userid, timestamp, action) VALUES (:ip, :userid, :timestamp, :action)";
		$stmt = $conn->prepare($sql);
        if($usersCount==1){            
            $stmt->execute(array(':ip'=>$_SERVER['REMOTE_ADDR'],':userid'=>$user->id, ':timestamp'=>date('Y-m-d H:i:s'), ':action'=>'102'));
        }else{
            $stmt->execute(array(':ip'=>$_SERVER['REMOTE_ADDR'],':userid'=>0, ':timestamp'=>date('Y-m-d H:i:s'), ':action'=>'102'));
        }

        SessionData::set(__('Το όνομα ή ο κωδικός είναι λάθος'),'danger');
        header("Location: index.php");
        exit;
    }

}

getHead();
SessionData::get();

echo "

<div class='login'>
<div class=\"container\">
      <div class=\"card\">
        <div class=\"card-header text-center\">".__('Είσοδος')."</div>
        <div class=\"card-body\">
          
";

echo "
    <form method='post' action='index.php'>
        <div class='form-group'>
            <div class='col-md-12'>
		      <label for='name'>" .  __("Όνομα χρήστη")  . "</label>
                <input class='form-control' id='name' type='text' placeholder='" .  __("Όνομα χρήστη")  . "' name='uname' required>
            </div>
        </div>
        
        <div class='form-group'>
            <div class='col-md-12'>
		      <label for='psw'>" .  __("Κωδικός")  . "</label>
                <input class='form-control' id='psw' type='password' placeholder='" .  __("Κωδικός")  . "' name='psw' autocomplete='on'required>
            </div>
        </div>    
        
        <div class='form-group'>
            <div class='col-md-6'>
                <label>
                    <a class='link' href='resetpsw.php'> " .  __('Ξεχάσατε τον κωδικό σας?')  . "</a>
                </label>
            </div>    
        </div>
        
        <div class='form-group'>
            <div class='col-md-12'>
		      <input class='btn btn-block btn-dark' type='submit' value='" .  __("Είσοδος")  . "' >
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