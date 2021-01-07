<?php

	// Access: Admin
	// Purpose: View the statistical information about a specific bin
	
require 'includes/functions.php';
is_admin();
admin_page();

$bins= select_list_of_bins_sql();

echo"
<div class='settings'>
    <div class='container'>
        <div class='card'>
            <div class='card-header text-center'> <b>" .  __("Στατιστικά Ανά Κάδο")  . " </b></div>
            <div class='card - body'>
                <form method='post' action='admin_stats_by_bin.php'>
                    <div class='form-group d-flex justify-content-center'>
                        <div class='col-md-6'>
		                   <b> <label for='bin'>". __("Οδός Κάδου")."</label> </b>
                            <select class='form-control' id='bin' name='bin_id' onchange='myFunction()'>
							<option value=0> </option>
";
                        foreach($bins as $bin ) {
                            echo "
                              <option value=".$bin->id_bin.">". $bin->description . " (" . $bin->id_bin. ")</option>
";
                        }
echo"
                            </select>
                        </div>
                    </div>
              
                </form>  
				<div id='searchh' > 					
				</div>
				<div id='load_charts'> </div>         
            </div>
        </div>
    </div>          
</div>    
";
echo "<script> 
	function myFunction(){
		$(document).ready(function(){
				$('#searchh').load('show_search.php',{
				});
		});
	}
	
	function showResultsFromToBin(){
		var x = document.getElementById('bin').value;
		var fr = document.getElementById('from').value;
		var to = document.getElementById('to').value;
		var year='';
		$(document).ready(function(){
				$('#load_charts').load('check_stats_tables_bin.php',{
					postbinid: x,
					postyear: year,
					postfr: fr,
					postto: to
				});
		});
	}
	
	function myFunctBinSearch(){
		var year = document.getElementById('livesearch').value;
		var y = document.getElementById('bin').value;
		var fr='';
		var to='';
		$(document).ready(function(){
				$('#load_charts').load('check_stats_tables_bin.php',{
					postyear: year,
					postbinid: y,
					postfr: fr,
					postto: to	
				});
		});
	}
	
	function showResultSearch(str) {
	  var xmlhttp=new XMLHttpRequest();
	  xmlhttp.onreadystatechange=function() {
		if (this.readyState==4 && this.status==200) {
		  document.getElementById('livesearch').innerHTML=this.responseText;
		}
	  }
	  var y = document.getElementById('bin').value;
	  xmlhttp.open('GET','livesearch_stats_tables.php?q='+str+'&bin_id='+y,true);
	  xmlhttp.send();
	}

</script>";

adminFooter();
?>


