<?php
	
	// Access: Employee
	// Purpose: View the statistical information from the bins

require 'includes/functions.php';
require 'includes/emp_functions.php';

is_emp();
emp_page();

echo"
<ol class='breadcrumb'>
            <li class='breadcrumb-item'>
              <a href='#'>" .  __('Γενικά Στατιστικά Περιεκτικοτήτων')  . "</a>
            </li>
            <li class='breadcrumb-item active'>" .  __('Υπάλληλος')  . "</li>
</ol>
";
// First charts
echo"
<div class='form-group'>
	<div class='row'>
	<div class='col-md-1'>		
	</div>
     <div class='col-md-3'>				 
		<b> <label for='search_stat_table'>". __("Αναζήτηση Χρονιάς:")."</label>		 </b>
				<div class='input-group-prepend'>
					<button class='input-group-text' onclick='myFunct()'><span class='fas fa-search'></span></button>
					<input class='form-control' id='search_stat_table' type='text' placeholder='" .__("Χρονιά")."' name='search_stat_table' onkeyup='showResult(this.value)' >
					<select class='form-control' id='livesearch' onchange='myFunct()'> </select>
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
				<button class='input-group-text' onclick='showResultsFromTo()'> <span class='far fa-arrow-alt-circle-right' style='font-size:24px'>  </span> </button>
			</div>
	  </div>
	 </div>
</div>
<div id='l_charts'> </div>
";

echo "<script>

	function showResult(str) {
	  var xmlhttp=new XMLHttpRequest();
	  xmlhttp.onreadystatechange=function() {
		if (this.readyState==4 && this.status==200) {
		  document.getElementById('livesearch').innerHTML=this.responseText;
		}
	  }
	  xmlhttp.open('GET','livesearch_stats_tables.php?q='+str,true);
	  xmlhttp.send();
	}

	function myFunct(){
		var year = document.getElementById('livesearch').value;
		var fr= '';
		var to= '';
		$(document).ready(function(){
				$('#l_charts').load('check_stats_tables.php',{
					postyear: year,
				  postfr: fr,
					postto: to
				});
		});
	}
	
	function showResultsFromTo(){
		var fr = document.getElementById('from').value;
		var to = document.getElementById('to').value;
    var year = '';
		$(document).ready(function(){
				$('#l_charts').load('check_stats_tables.php',{
					postfr: fr,
					postto: to,
          postyear: year					
				});
		});
	}

</script>";


adminFooter();
?>



