<?php

require "includes/db.class.php";
require "includes/smartbins.php";
require "includes/functions.php";
require "includes/bin.class.php";
require "includes/emp.class.php";
require "includes/sanitize.class.php";
require "includes/login_checking.class.php";

$s = new Sanitize();
$arr=array();
$login = new Login_Checking($_REQUEST['username'],$_REQUEST['password']);

if($login->verify_login_emp()||$login->verify_login_admin()){

	if(!isset($_REQUEST['function'])) die('You have to define the function!!!');

	if($_REQUEST['function']=='add_new_bin'){
		if($login->verify_login_admin()){
			$bin = new Bin($_REQUEST['lat'],$_REQUEST['lng'],$_REQUEST['description'],$_REQUEST['alert'],$_REQUEST['washDate']);
			$add_bin = new SmartBins();
			$add_bin->add_new_bin($bin->getLat(),$bin->getLng(),$bin->getDescription(),$bin->getAlert(),$bin->getWashDate());
		}		
	}
	elseif($_REQUEST['function']=='add_new_emp'){
		if($login->verify_login_admin()){
			$emp = new Emp($_REQUEST['name'],$_REQUEST['age'],$_REQUEST['address'],$_REQUEST['uname'],$_REQUEST['email'],$_REQUEST['passwd'],$_REQUEST['passwd'],$_REQUEST['role']);
			$add_emp = new SmartBins();
			$add_emp->add_new_emp($emp->getName(),$emp->getAge(),$emp->getAddress(),$emp->getUsername(),$emp->getEmail(),$emp->getPassword(),$emp->getRole());
		}
	}
	elseif($_REQUEST['function']=='delete_bin'){

		if($login->verify_login_admin()){
			$arr = $s->sanitize_value($_REQUEST['id_bin']);
			$delete_bin = new SmartBins();
			$delete_bin->del_bin($arr[0]);
		}
	}
	elseif($_REQUEST['function']=='delete_emp'){
			
		if($login->verify_login_admin()){
			$arr = $s->sanitize_value($_REQUEST['user_id']);
			$delete_emp = new SmartBins();
			$delete_emp->del_emp($arr[0]);
		}

	}
	elseif($_REQUEST['function']=='deleted_list_of_bins'){
		
		if($login->verify_login_emp()||$login->verify_login_admin()){
			$deleted_bins = new SmartBins();
			echo $deleted_bins->deleted_list_of_bins();	
		}
		
	}
	elseif($_REQUEST['function']=='deleted_list_of_emps'){
		
		if($login->verify_login_emp()||$login->verify_login_admin()){
			$deleted_emps = new SmartBins();
			echo $deleted_emps->deleted_list_of_emps();	
		}
	}
	
	elseif($_REQUEST['function']=='list_of_bins'){
		
		if($login->verify_login_emp()||$login->verify_login_admin()){
			$list_of_bins = new SmartBins();
			echo $list_of_bins->list_of_bins();	
		}
	}
	elseif($_REQUEST['function']=='list_of_emps'){
		
		if($login->verify_login_admin()){
			$list_of_emps = new SmartBins();
			echo $list_of_emps->list_of_emps();	
		}
	}
	elseif($_REQUEST['function']=='reset_bin'){
		
		if($login->verify_login_admin()){
			$arr = $s->sanitize_value($_REQUEST['bin_id']);
			$r_bin = new SmartBins();
			$r_bin->reset_bin($arr[0]);	
		}
	}
	elseif($_REQUEST['function']=='reset_emp'){
		
		if($login->verify_login_admin()){
			$arr = $s->sanitize_value($_REQUEST['user_id']);	
			$r_emp = new SmartBins();
			$r_emp->reset_emp($arr[0]);	
		}
	}
	elseif($_REQUEST['function']=='upd_bin'){
		
		if($login->verify_login_admin()){
			$arr = $s->sanitize_value($_REQUEST['bin_id'],$_REQUEST['lat'],$_REQUEST['lng'],$_REQUEST['description'],$_REQUEST['alert'],$_REQUEST['washDate']);	
			$update_bin = new SmartBins();
			$update_bin->upd_bin($arr[0],$arr[1],$arr[2],$arr[3],$arr[4],$arr[5]);
		}
		
	}
	elseif($_REQUEST['function']=='upd_emp'){
			
		if($login->verify_login_admin()){
			$arr = $s->sanitize_value($_REQUEST['id'],$_REQUEST['name'],$_REQUEST['age'],$_REQUEST['address'],$_REQUEST['uname'],$_REQUEST['email'],$_REQUEST['old_username'],$_REQUEST['old_email']);	
			$update_emp = new SmartBins();
			$update_emp->upd_emp($arr[0],$arr[1],$arr[2],$arr[3],$arr[4],$arr[5],$arr[6],$arr[7]);
		}
	}
	elseif($_REQUEST['function']=='stats'){

		if($login->verify_login_emp()||$login->verify_login_admin()){
			$fr="";
			$to="";
			$year="";
			if(isset($_REQUEST['from'])) {
				$arr = $s->sanitize_value($_REQUEST['from'],$_REQUEST['to']);
				$fr=$arr[0];
				$to=$arr[1];
			}
			elseif(isset($_REQUEST['year'])) {
				$arr = $s->sanitize_value($_REQUEST['year']);
				$year=$arr[0];
			}
			else {
				print_r("1.Παρακαλώ εισάγετε χρονολογία");
			}
			$stats = new Smartbins();
			echo $stats->stats($fr,$to,$year);
		}
	}
	elseif($_REQUEST['function']=='stats_by_bin'){

		if($login->verify_login_emp()||$login->verify_login_admin()){
			$fr="";
			$to="";
			$year="";
			$bid="";
			if(isset($_REQUEST['from'])) {
				$arr = $s->sanitize_value($_REQUEST['from'],$_REQUEST['to']);
				$fr=$arr[0];
				$to=$arr[1];		
			}
			elseif(isset($_REQUEST['year'])) {
				$arr = $s->sanitize_value($_REQUEST['year']);
				$year=$arr[0];
			}
			else print_r("1.Παρακαλώ εισάγετε χρονολογία/id του κάδου");
			$arr = $s->sanitize_value($_REQUEST['bin_id']);
			$bid = $arr[0];
			
			
			$stats_by_bin = new Smartbins();
			echo $stats_by_bin->stats_by_bin($bid,$fr,$to,$year);
		}
		
	}
	elseif($_REQUEST['function']=='logfiles_list'){
		
		if($login->verify_login_admin()){
			$logfiles_list = new SmartBins();
			echo $logfiles_list->logfiles_list();	
		}

	}
	elseif($_REQUEST['function']=='show_bin_contend'){
		
		if($login->verify_login_emp()||$login->verify_login_admin()){
			$arr = $s->sanitize_value($_REQUEST['bin_id']);
			$bin_contend = new SmartBins();
			echo $bin_contend->show_bin_contend($arr[0]);	
		}

	}
	elseif($_REQUEST['function']=='show_bin_humitidy'){
		
		if($login->verify_login_emp()||$login->verify_login_admin()){
			$arr = $s->sanitize_value($_REQUEST['bin_id']);
			$bin_humid = new SmartBins();
			echo $bin_humid->show_bin_humitidy($arr[0]);	
		}

	}
	elseif($_REQUEST['function']=='show_bin_temperature'){
		
		if($login->verify_login_emp()||$login->verify_login_admin()){
			$arr = $s->sanitize_value($_REQUEST['bin_id']);
			$bin_temp = new SmartBins();
			echo $bin_temp->show_bin_temperature($arr[0]);	
		}

	}
	elseif($_REQUEST['function']=='show_bin_last_contact'){
		
		if($login->verify_login_emp()||$login->verify_login_admin()){
			$arr = $s->sanitize_value($_REQUEST['bin_id']);
			$bin = new SmartBins();
			echo $bin->show_bin_last_contact($arr[0]);	
		}

	}
	elseif($_REQUEST['function']=='show_bin_over_limit'){
		
		if($login->verify_login_emp()||$login->verify_login_admin()){
			$bin = new SmartBins();
			echo $bin->show_bin_over_limit();	
		}

	}
	elseif($_REQUEST['function']=='show_bin_information'){
		
		if($login->verify_login_emp()||$login->verify_login_admin()){
			$arr = $s->sanitize_value($_REQUEST['bin_id']);
			$bin = new SmartBins();
			echo $bin->show_bin_information();
		
		}			

	}
	elseif($_REQUEST['function']=='show_open_bins'){
		
		if($login->verify_login_emp()||$login->verify_login_admin()){
			$bin = new SmartBins();
			echo $bin->show_the_open_bins();	
		}

	}
}else print_r("99.Λανθασμένο όνομα χρήστη ή κωδικός");



 

?>
