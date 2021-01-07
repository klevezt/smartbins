<?php 

	// Access: Admin file
	// Purpose: Show the search year tab and the search between dates tab 


require 'includes/functions.php';
check_login();

echo "<div class='form-group d-flex justify-content-center'>
		 <div class='col-md-12'>
			<div class='row'>
	<div class='col-md-1'>		
	</div>
     <div class='col-md-3'>				 
		<b> <label for='search_stat_table'>". __("Αναζήτηση Χρονιάς:")."</label>		 </b>
				<div class='input-group-prepend'>
					<button class='input-group-text' onclick='myFunctBinSearch()'><span class='fas fa-search'></span></button>
					<input class='form-control' id='search_stat_table' type='text' placeholder='" .__("Χρονιά")."' name='search_stat_table' onkeyup='showResultSearch(this.value)' >
					<select class='form-control' id='livesearch' onchange='myFunctBinSearch()'> </select>
				</div>    
	  </div>
	  <div class='col-md-1'>
	  </div>
	  <div class='col-md-4'>
			<b> <label for='date_from_to'>". __("Αναζήτηση Ανάμεσα Ημερομηνιών:")."</label> </b>
			<div class='input-group-prepend'>
				<input class='form-control' id='from' type='date' name='from' >
			   <span class='input-group-text'> - </span>
				<input class='form-control' id='to' type='date' name='to' >
				<button class='input-group-text' onclick='showResultsFromToBin()'> <span class='far fa-arrow-alt-circle-right' style='font-size:24px'>  </span> </button>
			</div>
	  </div>
	 </div>
	 <br>
		 <div>
	<div>";



?>