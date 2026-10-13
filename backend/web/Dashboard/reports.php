<?php

	require_once("Login/session.php");
	
	require_once("Login/class.user.php");

	
	$auth_user = new USER();
	
	
	$user_id = $_SESSION['user_session'];
	
	$stmt = $auth_user->runQuery("SELECT * FROM admin_users WHERE user_id=:user_id");
	$stmt->execute(array(":user_id"=>$user_id));
	
	$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
        
       
         
   // $date = new DateTime($date_range);
   // echo $date->format('d.m.Y');

?>
<!DOCTYPE html>

<html>
<head lang="en">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>PS Ads Dashboard</title>

	<link href="img/favicon.144x144.png" rel="apple-touch-icon" type="image/png" sizes="144x144">
	<link href="img/favicon.114x114.png" rel="apple-touch-icon" type="image/png" sizes="114x114">
	<link href="img/favicon.72x72.png" rel="apple-touch-icon" type="image/png" sizes="72x72">
	<link href="img/favicon.57x57.png" rel="apple-touch-icon" type="image/png">
	<link href="img/favicon.png" rel="icon" type="image/png">
	<link href="img/favicon.ico" rel="shortcut icon">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

    <link rel="stylesheet" href="css/lib/font-awesome/font-awesome.min.css">
   <link rel="stylesheet" href="css/separate/vendor/bootstrap-datetimepicker.min.css">
<link rel="stylesheet" href="css/separate/vendor/bootstrap-daterangepicker.min.css">
<link rel="stylesheet" href="css/lib/clockpicker/bootstrap-clockpicker.min.css">
    <link rel="stylesheet" href="css/lib/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="css/main.css">
	<link rel="stylesheet" href="css/lib/datatables-net/datatables.min.css">
<link rel="stylesheet" href="css/separate/vendor/datatables-net.min.css">
</head>
<body class="with-side-menu control-panel control-panel-compact">

<?php include("inc/head.php"); ?>
	
	<div class="mobile-menu-left-overlay"></div>
<?php include("inc/left.php"); ?>

	
	<div class="page-content">
		<div class="container-fluid">
                    
			<header class="section-header">
				<div class="tbl">
					<div class="tbl-row">
						<div class="tbl-cell">
							<h3>Advertisement Reports</h3>
                                                        
                                                        <?php 
                                                        
                                                        if($date_range!='') {
                                                      $date_range=$_POST['date_value']; 
                                                      $classes=explode("-",$date_range);
                                                      $date_st=$classes[0]; // echo '<br/>';
                                                      $date_et=$classes[1]; 
     
//$date = "08/23/2019";
 $mysql_date1 = date('Y-m-d', strtotime($date_st));
                                                        $mysql_date2 = date('Y-m-d', strtotime($date_et)); }
                                                        ?>
							
						</div>
					</div>
				</div>
			</header>
                    
                    
			<section class="card">
                            
                            <h5>&nbsp;</h5><form method='POST' action='reports.php'>
                            <div class="col-md-4">
							<div class="form-group">
								<div class='input-group date'>
									
                                                                
								</div>
							</div>
						</div>
                           
			
                            <div class="col-md-4">
							
							<div class="form-group">
								<div class='input-group date'>
                                                                        <input id="daterange2" type="text" name='date_value' value="<?php if($date_range!=''){ echo $date_range; }else{ echo'01/08/2019 - 01/08/2019';} ?>" class="form-control">
									<span class="input-group-addon">
										<i class="font-icon font-icon-calend"></i>
									</span>
								</div>
							</div>
						
						</div>
                               <div class="col-md-4">
							<div class="form-group">
								<div class='input-group date'>
									
                                                                 <button type="button" onclick = this.form.submit(); value='Submit' class="btn btn-inline btn-warning-outline">Filter</button>
								</div>
							</div>
                               </div> </form>
					
						
				<div class="card-block">
					<table   id="example" class="display dataTable" id="example" class="display table table-striped table-bordered" cellspacing="0" width="100%">
						<thead>
						<tr>
				     <th>Date</th>
                                       <th>Name</th>
                                       <th>Duration</th>
                                       <th>Spots</th>
                                       <th>Time</th>
           		
           
           <th>Status</th>
          
           
            
             
         
                   <th>Total Users</th>
                <th>Unique Users</th>
          
          
              
						</tr>
						</thead>
						<tfoot>
						<tr>
						
            		
         <th>Date</th>
                                       <th>Name</th>
                                       <th>Duration</th>
                                       <th>Spots</th>
                                       <th>Time</th>
           		
           
           <th>Status</th>
          
           
            
             
         
                   <th>Total Users</th>
                <th>Unique Users</th>
            
        
						</tr>
						</tfoot>
						<tbody>
						
						
				
				<?php
                                                                
 function nice_number($n) {
        // first strip any formatting;
        $n = (0+str_replace(",", "", $n));

        // is this a number?
        if (!is_numeric($n)) return false;

        // now filter it;
        if ($n > 1000000000000) return round(($n/1000000000000), 2).' trillion';
        elseif ($n > 1000000000) return round(($n/1000000000), 2).' billion';
        elseif ($n > 1000000) return round(($n/1000000), 2).' million';
        elseif ($n > 1000) return round(($n/1000), 2).' k';

        return number_format($n);
    }
	$todaymisdate = date("Y-m-d"); 
                                
				try
		{
			
		
	if($userRow['user_role']=='Admin'){
            
            if($mysql_date1!=''){
                 $stmt1 = $auth_user->runQuery("SELECT * FROM `ad_slots_his` inner join ads on as_ad_id=`ad_id`  AND as_createdon !='$todaymisdate' AND as_createdon<='$mysql_date2' AND as_createdon>='$mysql_date1'   order by as_createdon, as_starttime desc  ");
           
                 
                
            }else{
			$stmt1 = $auth_user->runQuery("SELECT * FROM `ad_slots_his` inner join ads on as_ad_id=`ad_id` order by as_createdon, as_starttime desc  ");
			
            }}else{
            
            if($mysql_date1!=''){
             //   echo $mysql_date1; die;
                 $stmt1 = $auth_user->runQuery("SELECT * FROM `ad_slots_his` inner join ads on as_ad_id=`ad_id` inner join admin_users on `ad_admin`=user_id AND ad_admin=$user_id AND as_createdon !='$todaymisdate' AND as_createdon<='$mysql_date2' AND as_createdon>='$mysql_date1' group by `as_createdon`  order by as_createdon, as_starttime desc  ");
           
                 
                
            }
            else{
               // echo '--hi';die;
            
            
           $stmt1 = $auth_user->runQuery("SELECT * FROM `ad_slots_his` inner join ads on as_ad_id=`ad_id` inner join admin_users on `ad_admin`=user_id AND ad_admin=$user_id AND as_createdon !='$todaymisdate' group by `as_createdon`  order by as_createdon, as_starttime desc  ");
            }//var_dump($stmt1);	 
        }
			
	$stmt1->execute();
	
	//$userRow1=$stmt1->fetch(PDO::FETCH_ASSOC);
	

		if($stmt1->rowCount() > 0)
				{  $i=1;
					while($row = $stmt1->fetch()){  //echo '1';
					//var_dump($row);
                                            
                                            
                        date_default_timezone_set('Asia/Kolkata');

$timestamp = time();
$date_time = date("H:i:s", $timestamp);

					


$dateofslot=date($row['as_createdon']);

$ad_id_usrs=$row['ad_id'];
$slot_id_usrs=$row['as_id'];


$stmt1_lm1_sl = $auth_user->runQuery("SELECT `as_id`, `as_ad_id` FROM `ad_slots_his` WHERE `as_ad_id`=$ad_id_usrs AND as_createdon='$dateofslot' "
        . "  ");
$stmt1_lm1_sl->execute();
 $cnt_ad_id_usrs_sl= $stmt1_lm1_sl->rowCount(); //die;

//echo "SELECT  aa_userid FROM `ad_analytics` inner join ads on ad_admin=ad_id where `ad_admin`=$user_id AND aa_ad_id=$ad_id_usrs AND aa_slot_id=$slot_id_usrs"; die;
	//echo "SELECT  aa_ip FROM `ad_analytics` where aa_ad_id=$ad_id_usrs AND aa_datetime='$dateofslot'";		
$stmt1_lm1 = $auth_user->runQuery("SELECT  aa_ip FROM `ad_analytics` where aa_ad_id=$ad_id_usrs AND date(aa_datetime)='$dateofslot'"
        . "  ");
$stmt1_lm1->execute();
$cnt_ad_id_usrs= $stmt1_lm1->rowCount();
$cnt_ad_id_usrs=nice_number($cnt_ad_id_usrs);


$stmt1_cm1 = $auth_user->runQuery("SELECT  distinct aa_ip FROM `ad_analytics` where aa_ad_id=$ad_id_usrs  AND date(aa_datetime)='$dateofslot' "
        . "  ");
$stmt1_cm1->execute();
$cnt_ad_id_usrs_uni= $stmt1_cm1->rowCount();
$cnt_ad_id_usrs_uni=nice_number($cnt_ad_id_usrs_uni);
							
		
		
					?>
					
					<tr>
					
					  
         <td><?php echo(date("F d, Y ", strtotime($row['as_createdon']))); ?></td>
         <td><?php echo $row['ad_name']; ?></td>
         <td><?php echo $row['ad_duration']*$cnt_ad_id_usrs; ?> sec</td>
         <td><?php echo $cnt_ad_id_usrs_sl; ?></td>
         <td><?php echo $row['as_starttime']; ?></td>
         
            <td class="table-date"><span class="label label-success">Ad Played</span></td>
					
             
            
               
                  
                   
                    
                     <td><span class="btn btn-rounded btn-inline btn-primary"><?php echo $cnt_ad_id_usrs; ?></span></td>
                       <td><span class="btn btn-rounded btn-inline btn-info"><?php echo $cnt_ad_id_usrs_uni; ?></span></td>
                    
         
                  
                  
                   
                    
                  
					
					
						</tr>
					
				
					
					
					<?php
				
				$i++; } }else
				{
					echo 'No Data Available !';
				}
				}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
				
			

?>
		
						
						
						
					
						</tbody>
					</table>
				</div>
			</section>
		</div><!--.container-fluid-->
	</div><!--.page-content-->

	<script src="js/lib/jquery/jquery.min.js"></script>
	<script src="js/lib/tether/tether.min.js"></script>
	<script src="js/lib/bootstrap/bootstrap.min.js"></script>
	<script src="js/plugins.js"></script>

	<script src="js/lib/datatables-net/datatables.min.js"></script>
	<script>
	$(document).ready(function() {
		
	var table = 	$('#example').DataTable( {
		"order": [[ 4, "asc" ]],
		"oLanguage": {
			"sInfo": "Showing _START_ to _END_ of _TOTAL_ items."
		},
		
        dom: 'Bfrtip',
        buttons: [ 
            {
                extend: 'copyHtml5',
                exportOptions: {
                    columns: [ 0, ':visible' ]
                }, title: 'Data_Ads'
            },
			{
                extend: 'print',
                exportOptions: {
                    columns: [ 0, ':visible' ]
                }, title: 'Data_Ads'
            },
			 {
                extend: 'csv',
                exportOptions: {
                    columns: [ 0, ':visible' ],
					 
                }, title: 'Data_Ads'
            },
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: ':visible'
                }, title: 'Data_Ads'
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2, 3,4,5,6]
                }, title: 'Data_Ads'
            },
            'colvis'
        ]
    } );
		
 

    $("#example tfoot th").each( function ( i ) {
        
        if(i < 5) {
   

		
		if ($(this).text() !== '') {
	        var isStatusColumn = (($(this).text() == 'Status') ? true : false);
			var select = $('<select><option value=""></option></select>')
	            .appendTo( $(this).empty() )
	            .on( 'change', function () {
	                var val = $(this).val();
					
	                table.column( i )
	                    .search( val ? '^'+$(this).val()+'$' : val, true, false )
	                    .draw();
	            } );
	 		
			// Get the Status values a specific way since the status is a anchor/image
			if (isStatusColumn) {
				var statusItems = [];
				
                /* ### IS THERE A BETTER/SIMPLER WAY TO GET A UNIQUE ARRAY OF <TD> data-filter ATTRIBUTES? ### */
				table.column( i ).nodes().to$().each( function(d, j){
					var thisStatus = $(j).attr("data-filter");
					if($.inArray(thisStatus, statusItems) === -1) statusItems.push(thisStatus);
				} );
				
				statusItems.sort();
								
				$.each( statusItems, function(i, item){
				    select.append( '<option value="'+item+'">'+item+'</option>' );
				});

			}
            // All other non-Status columns (like the example)
			else {
				table.column( i ).data().unique().sort().each( function ( d, j ) {  
					select.append( '<option value="'+d+'">'+d+'</option>' );
		        } );	
			}
	        
		}
    }} );
  
}  );
	
	
	</script>
		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.3.1/css/buttons.dataTables.min.css">
	<script type="text/javascript" language="javascript" src="//code.jquery.com/jquery-1.12.4.js">
	</script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js">
	</script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js">
	</script>
        	
	
	

	<script type="text/javascript" src="js/lib/moment/moment-with-locales.min.js"></script>
	<script type="text/javascript" src="js/lib/eonasdan-bootstrap-datetimepicker/bootstrap-datetimepicker.min.js"></script>
	<script src="js/lib/clockpicker/bootstrap-clockpicker.min.js"></script>
	<script src="js/lib/clockpicker/bootstrap-clockpicker-init.js"></script>
	<script src="js/lib/daterangepicker/daterangepicker.js"></script>
	<script src="js/lib/bootstrap-select/bootstrap-select.min.js"></script>
	<script type="text/javascript" language="javascript" src="//cdn.datatables.net/buttons/1.3.1/js/buttons.flash.min.js">
	</script>
	<script type="text/javascript" language="javascript" src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js">
	</script>
	<script type="text/javascript" language="javascript" src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/pdfmake.min.js">
	</script>
	<script type="text/javascript" language="javascript" src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/vfs_fonts.js">
	</script>
	<script type="text/javascript" language="javascript" src="//cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js">
	</script>
	<script type="text/javascript" language="javascript" src="//cdn.datatables.net/buttons/1.3.1/js/buttons.print.min.js">
	</script>
		<script type="text/javascript" language="javascript" src="//cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js">
	</script>
	<script type="text/javascript" language="javascript" src="//cdn.datatables.net/buttons/1.3.1/js/buttons.colVis.min.js">
	</script>
        
        <script>
		$(function() {
			function cb(start, end) {
				$('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
			}
			cb(moment().subtract(29, 'days'), moment());

			$('#daterange').daterangepicker({
				"timePicker": true,
				ranges: {
					'Today': [moment(), moment()],
					'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
					'Last 7 Days': [moment().subtract(6, 'days'), moment()],
					'Last 30 Days': [moment().subtract(29, 'days'), moment()],
					'This Month': [moment().startOf('month'), moment().endOf('month')],
					'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
				},
				"linkedCalendars": false,
				"autoUpdateInput": false,
				"alwaysShowCalendars": true,
				"showWeekNumbers": true,
				"showDropdowns": true,
				"showISOWeekNumbers": true
			});

			$('#daterange2').daterangepicker(
                                {
                                    "showDropdowns": true,
                            ranges: {
					'Today': [moment(), moment()],
					'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
					'Last 7 Days': [moment().subtract(6, 'days'), moment()],
					'Last 30 Days': [moment().subtract(29, 'days'), moment()],
					'This Month': [moment().startOf('month'), moment().endOf('month')],
					'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
				},
                                });

			$('#daterange3').daterangepicker({
				singleDatePicker: true,
				showDropdowns: true
			});

			$('#daterange').on('show.daterangepicker', function(ev, picker) {
				/*$('.daterangepicker select').selectpicker({
					size: 10
				});*/
			});

			/* ==========================================================================
			 Datepicker
			 ========================================================================== */

			$('.datetimepicker-1').datetimepicker({
				widgetPositioning: {
					horizontal: 'right'
				},
				debug: false
			});

			$('.datetimepicker-2').datetimepicker({
				widgetPositioning: {
					horizontal: 'right'
				},
				format: 'LT',
				debug: false
			});
		});
	</script>

<script src="js/app.js"></script>
</body>
</html>