<?php

// Access: The api  
	// Purpose: The class SmartBins has the functions for the api

class SmartBins{
	
	public function show_the_open_bins(){
		return json_encode(check_the_button_sql());
	}

	public function show_bin_contend($id){
		
		return json_encode(select_bin_by_id($id)[0]);
		
	}

	public function show_bin_humitidy($id){
		
		return json_encode(select_bin_by_id($id)[1]);
		
	}

	public function show_bin_temperature($id){
		
		return json_encode(select_bin_by_id($id)[2]);
		
	}
	
	public function show_bin_last_contact($id){
		
		return json_encode(select_bin_by_id($id)[3]);
		
	}
	
	public function show_bin_over_limit(){
		
		echo json_encode(admin_change_sql_mode()[1]);
		
	}
	
	public function show_bin_information($id){
		
		return json_encode(show_bins_information($id));
		
	}

	public function stats_by_bin($bin_id,$fr,$to,$year){
		$months = getMonths();
		$data = create_data_for_bin_contend_stats_by_bin($year,$fr,$to,$bin_id)[0];
		$label = create_data_for_bin_contend_stats_by_bin($year,$fr,$to,$bin_id)[1];
		
		$data_ch = create_data_for_humidity_stats_by_bin($year,$fr,$to,$bin_id)[0];
		$label_ch = create_data_for_humidity_stats_by_bin($year,$fr,$to,$bin_id)[1];
		
		$data_temp = create_data_for_temperature_stats_by_bin($year,$fr,$to,$bin_id)[0];
		$label_temp = create_data_for_temperature_stats_by_bin($year,$fr,$to,$bin_id)[1];
		
		array_push($data,$label,$data_ch,$label_ch,$data_temp,$label_temp);
		
		return json_encode($data);		
		
	}

	public function stats($fr,$to,$year){
		
		$data = create_data_for_bin_contend_stats($year,$fr,$to,$bin_id)[0];
		$label = create_data_for_bin_contend_stats($year,$fr,$to,$bin_id)[1];
		
		$data_ch = create_data_for_humidity_stats($year,$fr,$to,$bin_id)[0];
		$label_ch = create_data_for_humidity_stats($year,$fr,$to,$bin_id)[1];
		
		$data_temp = create_data_for_temperature_stats($year,$fr,$to,$bin_id)[0];
		$label_temp = create_data_for_temperature_stats($year,$fr,$to,$bin_id)[1];
		
		array_push($data,$label,$data_ch,$label_ch,$data_temp,$label_temp);
		
		return json_encode($data);		

				
	}

	public function upd_emp($id,$name,$age,$address,$username,$email,$old_username,$old_email){
		
		emp_show_errors($name,$age,$address,$username,$email,$password,$confirm_password,$role,0);
		if ($old_username!=$username) {

			$countUniqueUser=select_unique_username($username);
			if( $countUniqueUser>0){
				logfiles('109');
				return print_r('3.Τo username υπάρχει ήδη');
			}
		}

		if ($old_email!=$email) {
			$countUniqueEmail=select_unique_email($email);
			if( $countUniqueEmail>0){
				logfiles('109');
				return print_r('4.Τo email υπάρχει ήδη');
			}
		}

		$count=update_users_sql($id,$name,$age,$address,$username,$email,$old_username,$old_email);
		if ($count){
			logfiles('108');
			return print_r('5.Επιτυχής ανανέωση υπαλλήλου ');
		}
		else {
			logfiles('109');
			return print_r('6.Δεν αλλάξατε κάποιο πεδίο');
		}
		
	}

	public function upd_bin($id_bin,$lat,$lng,$description,$alert,$washDate){
			

		bin_show_errors($lat,$lng,$description,$alert,$washDate);
		$count=update_bin_sql($id_bin,$lat,$lng,$description,$alert,$washDate);
		if ($count){
			logfiles('110');
			return print_r('4.Επιτυχής ανανέωση κάδου');
		}else {
			logfiles('111');
			return print_r('5.Δεν αλλάξατε κάποιο πεδίο');
		}
	}
			
	public function reset_emp($id){
		
		$count=reset_emp_sql($id);
		if ($count){
			logfiles('114');
			return print_r('1.Επιτυχής επαναφορά υπαλλήλου');
		}
		else {
			logfiles('115');
			return print_r('2.Αποτυχής επαναφορά υπαλλήλου');
		}

	}

	public function reset_bin($id_bin){
		
		$count1=reset_bin_sql($id_bin);
		if ($count1){
			logfiles('112');
			return print_r('1.Επιτυχής επαναφορά κάδου');
		}
		else {
			logfiles('113');
			return print_r('2.Αποτυχής επαναφορά κάδου');
		}

	}

	public function logfiles_list(){
			$logfile=array(
				'101' => "Επιτυχία εισόδου",
				'102' => "Αποτυχία εισόδου",
				'103' => "Επιτυχία προσθήκης κάδου",
				'104' => "Αποτυχία προσθήκης κάδου",
				'105' => "Επιτυχία εξόδου",
				'106' => "Επιτυχία προσθήκης υπαλλήλου",
				'107' => "Αποτυχία προσθήκης υπαλλήλου",
				'108' => "Επιτυχία επεξεργασίας υπαλλήλου",
				'109' => "Αποτυχία επεξεργασίας υπαλλήλου",
				'110' => "Επιτυχία επεξεργασίας κάδου",
				'111' => "Αποτυχία επεξεργασίας κάδου",
				'112' => "Επιτυχία επαναφοράς κάδου",
				'113' => "Αποτυχία επαναφοράς κάδου",
				'114' => "Επιτυχία επαναφοράς υπαλλήλου",
				'115' => "Αποτυχία επαναφοράς υπαλλήλου",
				'116' => "Επιτυχία διαγραφής υπαλλήλου",
				'117' => "Αποτυχία διαγραφής υπαλλήλου",
				'118' => "Επιτυχία διαγραφής κάδου",
				'119' => "Αποτυχία διαγραφής κάδου",
				'120' => "Επιτυχία ανανέωσης διαχειριστή",
				'121' => "Αποτυχία ανανέωσης διαχειριστή"
			);

		
		$logs=select_logfiles_sql();
		$list=array();
		foreach($logs as $log ){

			$action= $logfile[$log->action];
			if($log->username==""){
				$username='Μη καταχωρημένο όνομα χρήστη';
			}else
				$username=$log->username;

				$arr=array(
				"username" => $username,
				"ip"    => $log->ip,
				"timestamp"    => $log->timestamp,
				"action" => $action
				);
				array_push($list,$arr);

			}
			return json_encode($list);
				
		
	}

	public function list_of_emps(){
		$users=select_list_of_emps_sql();
		$list=array();
		foreach($users as $user){
			$arr=array(
			"id" => $user->id,
            "name"    => $user->name,
			"age"    => $user->age,
            "address" => $user->address,
			"username" => $user->username,
			"email" => $user->email
			);
			array_push($list,$arr);

		}
		return json_encode($list);
				
	}
	
	public function list_of_bins(){
		$bins=select_list_of_bins_sql();
		$list=array();
		foreach($bins as $bin){
			$arr=array(
			"id_bin" => $bin->id_bin,
            "lat"    => $bin->lat,
			"lng"    => $bin->lng,
            "description" => $bin->description,
			"alert" => $bin->alert,
			"washDate" => $bin->washDate
			);
			array_push($list,$arr);

		}
		return json_encode($list);
		
		
	}

	public function deleted_list_of_emps(){
		$users=select_deleted_emps_sql();
		$deleted_emps=array();
		foreach($users as $user){
			$arr=array(
			"id" => $user->id,
            "name"    => $user->name,
			"age"    => $user->age,
            "address" => $user->address,
			"username" => $user->username,
			"email" => $user->email
			);
			array_push($deleted_emps,$arr);

		}
		return json_encode($deleted_emps);

	}

	public function deleted_list_of_bins(){
		
		$bins = select_deleted_bins_sql();
		$deleted_bins=array();
		foreach($bins as $bin){
			$arr=array(
			"id_bin" => $bin->id_bin,
            "lat"    => $bin->lat,
			"lng"    => $bin->lng,
            "description" => $bin->description,
			"alert" => $bin->alert,
			"washDate" => $bin->washDate
			);
			array_push($deleted_bins,$arr);

		}
		return json_encode($deleted_bins);
		
	}

	public function del_emp($id){
		
		$role = select_user_by_id($id);
		if($role == 1){
			$count1 = delete_user_sql($id);
			if ($count1){
				logfiles('116');
				return print_r('1.Επιτυχής διαγραφή υπαλλήλου');

			}else {
				logfiles('117');
				return print_r('2.Αποτυχής διαγραφή υπαλλήλου');
			}


		} elseif($role == 0) {
			logfiles('117');
			return print_r('3.Δεν μπορείτε να διαγράψετε διαχειριστή');
		}
		
	}

	public function del_bin($id_bin){
		
		$count1 = delete_bin_sql($id_bin);
		if ($count1){
			logfiles('118');
			return print_r('1.Επιτυχής διαγραφή κάδου');

		}else {
			logfiles('119');
			return print_r('2.Αποτυχής διαγραφή κάδου');
		}
				
	}
	
	public function add_new_emp($name,$age,$address,$username,$email,$password,$role){
		
		emp_show_errors($name,$age,$address,$username,$email,$password,$password,$role,1);
		$countUniqueUser = select_unique_username($username);
		if( $countUniqueUser>0){
			logfiles('107');
			return print_r('4.Τo username υπάρχει ήδη');
		}
		
		$countUniqueEmail = select_unique_email($email);
		if( $countUniqueEmail>0){
			logfiles('107');
			return print_r('5.Τo email υπάρχει ήδη');
		}
		if ($role!='Yes') {
			$count1 = emp_add_sql($name,$age,$address,$username,$email,$password,$password,$role);
			if ($count1){
				logfiles('106');
				return print_r('6.Επιτυχής προσθήκη υπαλλήλου');
			}
			else {
				logfiles('107');
				return print_r('7.Αποτυχία προσθήκης υπαλλήλου');
			}
		}
		else{
			$count2 = emp_add_sql($name,$age,$address,$username,$email,$password,$password,$role);
			if ($count2){
				logfiles('106');
				return print_r('8.Επιτυχής προσθήκη υπαλλήλου ως διαχειριστή');
			}
			else {
				logfiles('107');
				return print_r('9.Αποτυχία προσθήκης υπαλλήλου ως διαχειριστή ');
			}
		}
		
	}

	public function add_new_bin($lat,$lng,$description,$alert,$washDate){ 

				bin_show_errors($lat,$lng,$description,$alert,$washDate);
				$count = bin_add_sql($lat,$lng,$description,$alert,$washDate);
				if ($count) {
					logfiles('103');
					return print_r('4.Επιτυχής Προσθήκη');
				} else {
					logfiles('104');
					return print_r('5.Αποτυχία Προσθήκης Κάδου');
				}
				

		}
		
}

?>