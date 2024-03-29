<?php

	
	// Access: Admin
	// Purpose: Search the requested data for the stats of a specified bin

	require 'includes/db.class.php';
	require 'includes/functions.php';
	require 'includes/sanitize.class.php';
	is_admin();
	$s = new Sanitize();
	$arr=array();
	$fr='';
	$to='';
	$year='';

  if(isset($_POST['postyear'])&&$_POST['postyear']!=''){
    $arr = $s->sanitize_value($_POST['postbinid'],$_POST['postyear']);
    $bin_id = $arr[0];
    $year = $arr[1];
  }
  else{
    $arr = $s->sanitize_value($_POST['postbinid'],$_POST['postfr'],$_POST['postto']);
    $bin_id = $arr[0];
  	$fr = $arr[1];
  	$to = $arr[2];
  }

	$data = create_data_for_bin_contend_stats_by_bin($year,$fr,$to,$bin_id)[0];
	$label = create_data_for_bin_contend_stats_by_bin($year,$fr,$to,$bin_id)[1];
	
	$data_ch = create_data_for_humidity_stats_by_bin($year,$fr,$to,$bin_id)[0];
	$label_ch = create_data_for_humidity_stats_by_bin($year,$fr,$to,$bin_id)[1];
	
	$data_temp = create_data_for_temperature_stats_by_bin($year,$fr,$to,$bin_id)[0];
	$label_temp = create_data_for_temperature_stats_by_bin($year,$fr,$to,$bin_id)[1];
			

	$sql3="SELECT max(timestamp) FROM stats ";
	$lastUpdate=get_last_update($sql3);

	
// First charts
echo "
<div class=\"card mb-3\">
            <div class=\"card-header\">
              <i class=\"fas fa-chart-area\"></i>
              " .  __('Μέση πληρότητα κάδων').  "</div>
            <div class=\"card-body\">
         
<canvas id=\"myChart1\" width=\"20\" height=\"5\"></canvas>
";
?>
<script>
    var ctx = document.getElementById("myChart1").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels:["<?php echo implode('","',$label)?>"],
            datasets: [{
                label: '<?php echo  __('Περιεκτικότητα') ?>',
                data: [<?php echo implode(',',$data) ?> ],
                backgroundColor: [
                    'rgba(155,34,230,0.2)'

                ],
                borderColor: [
                    'rgba(155,34,230,1)'

                ],
                borderWidth: 3
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true
                    }
                }]
            }
        }
    });


</script>

<?php
echo"
            </div>
            <div class=\"card-footer small text-muted\">Τελευταία ενημέρωση " .$lastUpdate[0]. "</div>
          </div>

";
//

//second charts
echo"
<div class=\"card mb-3\">
            <div class=\"card-header\">
              <i class=\"fas fa-chart-area\"></i>
              " .  __('Υγρασία κάδων')  . "</div>
            <div class=\"card-body\">
              
";
echo"
<canvas id=\"myChart2\" width=\"20\" height=\"5\"></canvas>
";
?>
<script>
    var ctx = document.getElementById("myChart2").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels:["<?php echo implode('","',$label_ch)?>"],
            datasets: [{
                label: '<?php echo  __('Υγρασία') ?>',
                data: [<?php echo implode(',',$data_ch) ?> ],
                backgroundColor: [
                    'rgba(53,201,127,0.2)'



                ],
                borderColor: [
                    'rgba(53,201,127,1)'
                ],
                borderWidth: 3
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true
                    }
                }]
            }
        }
    });


</script>

<?php
echo"
            </div>
            <div class=\"card-footer small text-muted\">Τελευταία ενημέρωση " .$lastUpdate[0]. "</div>
          </div>

";
//

//third charts
echo"
<div class=\"card mb-3\">
            <div class=\"card-header\">
              <i class=\"fas fa-chart-area\"></i>
              " .  __('Μέση θερμοκρασία κάδων')  . "</div>
            <div class=\"card-body\">
     
<canvas id=\"myChart3\" width=\"20\" height=\"5\"></canvas>
";
?>
<script>
    var ctx = document.getElementById("myChart3").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels:["<?php echo implode('","',$label_temp)?>"],
            datasets: [{
                label: '<?php echo  __('Θερμοκρασία') ?>',
                data: [<?php echo implode(',',$data_temp) ?> ],
                backgroundColor: [
                    'rgba(239,32,4,0.4)'

                ],
                borderColor: [
                    'rgba(239,32,4,1)'

                ],
                borderWidth: 3
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true
                    }
                }]
            }
        }
    });


</script>

<?php
echo"
            </div>
            <div class=\"card-footer small text-muted\">Τελευταία ενημέρωση " .$lastUpdate[0]. "</div>
          </div>

";


