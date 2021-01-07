<?php

	// Access: Employee
	// Purpose: Index Page for Employees
	
require 'includes/functions.php';
require 'includes/emp_functions.php';

is_emp();
emp_page();

$count=select_bin_emps_sql()[0];
$count1=select_bin_emps_sql()[1];

$count2=admin_change_sql_mode()[0];

$label=select_bin_emps_sql()[2];
$data=select_bin_emps_sql()[3];

$sql="SELECT max(timestamp) FROM stats " ;
$lastUpdate=get_last_update($sql);

SessionData::get();
echo"
<ol class=\"breadcrumb\">
            <li class=\"breadcrumb-item\">
              <a href=\"#\">Αρχική</a>
            </li>
            <li class=\"breadcrumb-item active\">Υπάλληλος</li>
</ol>
";

echo"
<div class='row'>
<div class=\"col-xl-6 col-sm mb-4\">
              <div class=\"card text-white bg-primary o-hidden h-100\">
                <div class=\"card-body\">
                  <div class=\"card-body-icon\">
                    <i class=\"fas fa-fw fa-trash\"></i>
                  </div>
                  <div class=\"mr-5\">" .  __('Κάδοι που λειτουργούν:')  . " ".$count." </div>
                </div>
                <a class=\"card-footer text-white clearfix small z-1\" href=\"emp_list_of_bins.php\">
                  <span class=\"float-left\">Λεπτομέρειες</span>
                  <span class=\"float-right\">
                    <i class=\"fas fa-angle-right\"></i>
                  </span>
                </a>
              </div>
</div>


<div class=\"col-xl-6 col-sm mb-4\">
              <div class=\"card text-white bg-danger o-hidden h-100\">
                <div class=\"card-body\">
                  <div class=\"card-body-icon\">
                    <i class=\"fas fa-fw fa-exclamation-triangle\"></i>
                  </div>
                  <div class=\"mr-5\">" .  __('Κάδοι πάνω από το όριο:')  . " ".$count2." </div>
                </div>
                </div>
</div>

</div>
";


echo"

<div class=\"card mb-3\">
            <div class=\"card-header\">
              <i class=\"fas fa-chart-area\"></i>
              " .  __('Μέση πληρότητα κάδων')  . "</div>
            <div class=\"card-body\">
              
";
echo"
<canvas id=\"myChart\" width=\"20\" height=\"10\"></canvas>
";
?>
    <script>
        var ctx = document.getElementById("myChart").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels:["<?php echo implode('","',$label)?>"],
                datasets: [{
                    label: '<?php echo  __('Περιεκτικότητα') ?>',
                    data: [<?php echo implode(',',$data) ?> ],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
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
empFooter();
?>