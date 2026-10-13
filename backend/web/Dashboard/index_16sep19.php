<?php
require_once("Login/session.php");

require_once("Login/class.user.php");
$auth_user = new USER();


$user_id = $_SESSION['user_session'];

$stmt = $auth_user->runQuery("SELECT * FROM admin_users WHERE user_id=:user_id");
$stmt->execute(array(":user_id" => $user_id));

$userRow = $stmt->fetch(PDO::FETCH_ASSOC);

// if($userRow['user_role']=='Admin'){
//     header("location:userlogin.php");
// }
?>
<!DOCTYPE html>

<html>
    <head lang="en">
        <meta charset="UTF-8">
        
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title> Dashboard</title>

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
        <link href="css/lib/charts-c3js/c3.min.css" rel="stylesheet" type="text/css">
            <link rel="stylesheet" href="css/lib/font-awesome/font-awesome.min.css">
   <link rel="stylesheet" href="css/separate/vendor/bootstrap-datetimepicker.min.css">
<link rel="stylesheet" href="css/separate/vendor/bootstrap-daterangepicker.min.css">
<link rel="stylesheet" href="css/lib/clockpicker/bootstrap-clockpicker.min.css">
        <link rel="stylesheet" href="css/lib/lobipanel/lobipanel.min.css">
        <link rel="stylesheet" href="css/separate/vendor/lobipanel.min.css">
        <link rel="stylesheet" href="css/lib/jqueryui/jquery-ui.min.css">
        <link rel="stylesheet" href="css/separate/pages/widgets.min.css">

        <link rel="stylesheet" href="css/separate/vendor/slick.min.css">
        <link rel="stylesheet" href="css/separate/vendor/select2.min.css">


        <link rel="stylesheet" href="css/lib/font-awesome/font-awesome.min.css">
        <link rel="stylesheet" href="css/lib/bootstrap/bootstrap.min.css">
        <link rel="stylesheet" href="css/main.css">
    </head>
    <body class="with-side-menu control-panel control-panel-compact">

<?php include("inc/head.php"); ?>

        <div class="mobile-menu-left-overlay"></div>
<?php include("inc/left.php"); ?>

        <div class="page-content">
            
            
            <header class="page-content-header widgets-header">
                
                
                
                    <div class="tbl tbl-outer">
                        <div class="tbl-row">
                            
                            

<?php



                  $date_range=$_POST['date_value']; 
                  $factr=1.8;
                                                        
                                                        if($date_range!='') {
                                                             $factr=0.9;
                                                      $date_range=$_POST['date_value']; 
                                                      $classes=explode("-",$date_range);
                                                      $date_st=$classes[0]; // echo '<br/>';
                                                      $date_et=$classes[1]; 
     
//$date = "08/23/2019";
 $mysql_date1 = date('Y-m-d', strtotime($date_st));
                                                        $mysql_date2 = date('Y-m-d', strtotime($date_et));
                                                        
                                                        $sql_for_sel=" where date(`aa_datetime`)<='$mysql_date2' AND date(`aa_datetime`)>='$mysql_date1' ";
                                                         $sql_for_sel_and=" AND  date(`aa_datetime`)<='$mysql_date2' AND date(`aa_datetime`)>='$mysql_date1' "; 

                                                         $sql_for_sel_slot=" where  as_createdon<='$mysql_date2' AND as_createdon>='$mysql_date1' ";
                                                         $sql_for_sel_and_slot=" AND  as_createdon<='$mysql_date2' AND as_createdon>='$mysql_date1' ";
                                                        }else{
                                                            $sql_for_sel='';
                                                              $sql_for_sel_and='';
                                                              
                                                         $sql_for_sel_slot='';
                                                         $sql_for_sel_and_slot='';
                                                        }


if ($userRow['user_role'] == 'Admin') {
    $stmt1_cm1_grph = $auth_user->runQuery("SELECT DAYNAME(`aa_datetime`) as dt ,count(`aa_ip`) as aip,DATE(`aa_datetime`) as dt1 FROM ad_analytics group by date(`aa_datetime`) $sql_for_sel_and order by date(`aa_datetime`) desc limit 7 "
            . "  ");
} else {
    $stmt1_cm1_grph = $auth_user->runQuery("SELECT DAYNAME(`aa_datetime`) as dt ,count(`aa_ip`) as aip ,DATE(`aa_datetime`) as dt1 FROM ad_analytics inner join ads on aa_ad_id=`ad_id` inner join admin_users on ad_admin=user_id where `user_id`=$user_id $sql_for_sel_and group by date(`aa_datetime`) order by date(`aa_datetime`) desc limit 7 "
            . "  "); //var_dump($stmt1_cm1_grph);die;
}
$stmt1_cm1_grph->execute();
$ig = 1;
while ($row1_gr = $stmt1_cm1_grph->fetch()) {
    $nval_fresh = $row1_gr['aip'];
    $nval_g = $row1_gr['dt1'];
    if ($ig == 1) {

        $nval = $row1_gr['aip'];
        $nval_sum = $nval;

        $nvalg = "['$nval_g', $nval_fresh]";
    } else {
        $nval = $nval . "," . $row1_gr['aip'];
        $nvalg = $nvalg . "," . "['$nval_g', $nval_fresh]";
        $nval_sum = $nval_sum + $nval;
        ;
    }
    $ig++;
}


 function nice_number($n) {
        // first strip any formatting;
        $n = (0+str_replace(",", "", $n));

        // is this a number?
        if (!is_numeric($n)) return false;

        // now filter it;
        if ($n > 1000000000000) return round(($n/1000000000000), 2).' t';
        elseif ($n > 1000000000) return round(($n/1000000000), 2).' b';
        elseif ($n > 1000000) return round(($n/1000000), 2).' m';
        elseif ($n > 1000) return round(($n/1000), 2).' k';

        return number_format($n);
    }


//die;
?>						


                        </div>
                            <br/><br/>
                            
                               <?php 
                                           
                                                        ?>
                        <div class="container-fluid">
                            <form method='POST' action='index.php'>
                            <div class="col-md-2">
							<div class="form-group">
								<div class='input-group date'>
									
                                                                
								</div>
							</div>
						</div>
                           
			
                            <div class="col-md-4">
							
							<div class="form-group">
								<div class='input-group date'>
                                                                        <input id="daterange2" type="text" name='date_value' value="<?php if($date_range!=''){ echo $date_range; }else{ echo'09/01/2019 - 09/01/2019';} ?>" class="form-control">
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
                    <div class="row">
                       
                        <div class="col-xl-12">
                            <div class="row">
                                <div class="col-sm-4">
                                    <article class="statistic-box red">
                                        <div>
                                            <div class="number"><?php
                                        if ($userRow['user_role'] == 'Admin') {
                                            $stmt1_cm1 = $auth_user->runQuery("SELECT  count(aa_ip) as cnt FROM `ad_analytics` inner join ads on aa_ad_id=`ad_id`  $sql_for_sel "
                                                    . "  ");
                                        } else {
                                            $stmt1_cm1 = $auth_user->runQuery("SELECT  count(aa_ip) as cnt FROM `ad_analytics` inner join ads on aa_ad_id=`ad_id` inner join admin_users on ad_admin=user_id  where `user_id`=$user_id $sql_for_sel_and "
                                                    . "  ");
                                        }
                                       
                                        
                                        
                                       //  var_dump($stmt1_cm1); die;
                                        
                                        $stmt1_cm1->execute();
                                        $userRow_cm1 = $stmt1_cm1->fetch(PDO::FETCH_ASSOC);
                                        $u1_forsess = $userRow_cm1['cnt'];
                                        echo $u1 = nice_number($u1_forsess);
                                        ?>
                                            </div>
                                            <div class="caption"><div>Total Users</div></div>
                                            <div class="percent">
                                                <div class="arrow up"></div>
                                                <p>5%</p>
                                            </div>
                                        </div>
                                    </article>
                                </div>
                                <div class="col-sm-4">
                                    <article class="statistic-box purple">
                                        <div>
                                            <div class="number"><?php  $u2= $u1_forsess*1.6; echo nice_number($u2);  ?>  </div>
                                            <div class="caption"><div>Overall Sessions</div></div>
                                            <div class="percent">
                                                <div class="arrow down"></div>
                                                <p>11%</p>
                                            </div>
                                        </div>
                                    </article>
                                </div>
                          
                                <div class="col-sm-4">
                                    <article class="statistic-box green">
                                        <div>
                                            <div class="number"><?php
                                        if ($userRow['user_role'] == 'Admin') {
                                            $stmt1_cm2 = $auth_user->runQuery("SELECT count(*) as dur FROM `ad_slots_his` inner join ads on as_ad_id=`ad_id` $sql_for_sel_slot  order by as_createdon, as_starttime desc ");
                                        } else {
                                            $stmt1_cm2 = $auth_user->runQuery("SELECT count(*) as dur  FROM `ad_slots_his` inner join ads on as_ad_id=`ad_id` inner join admin_users on `ad_admin`=user_id AND ad_admin=$user_id $sql_for_sel_and_slot  order by as_createdon, as_starttime desc  ");
                                        }
                                        $stmt1_cm2->execute();
                                        $result_cm = $stmt1_cm2->fetch();

                                        $dur1 = $result_cm ["dur"];

                                        if ($dur1 == null) {
                                            $dur1 = 0;
                                        }
                                        echo nice_number($dur1);
                                        ?></div>
                                            <div class="caption"><div>Total Ad's Slots</div></div>
                                            <div class="percent">
                                                <div class="arrow up"></div>
                                                <p>4%</p>
                                            </div>
                                        </div>
                                    </article>
                                </div>
                            </div>
                        </div>
                    </div>
                            
                               <div class="row">
                                   
                                   
                    <div class="col-lg-8">
                    <section class="card">
                         <header class="card-header">
                                Users Trend Last 7 Days
                            </header>
                        <div class="widget-chart-extra-blue">
                            <div class="widget-chart-extra-blue-title"></div>
                            <div id="chart_line" class="chart"></div>
                        </div>



                    </section>
                </div>

          

                    <div class="col-lg-4">
                        <section class="card">
                            <header class="card-header">
                                AD's Users Performance Trend
                            </header>
                            <div class="card-block">
                                <div id="donut-chart"></div>
                            </div>
                        </section>
                    </div>

              

              
            </div>





                </div> 
                    </div>
                <!--
                    <div class="row">
                        <div class="col-xl-3">
                            <section class="widget widget-simple-sm">
                                <div class="widget-simple-sm-statistic">
                                    <div class="number"></div>

                                </div>
                                <div class="widget-simple-sm-bottom statistic"><div class="caption color-blue"><b>Total Users</b></div></div>
                            </section>
                        </div>
                        <div class="col-xl-3">
                            <section class="widget widget-simple-sm">
                                <div class="widget-simple-sm-statistic">
                                    <div class="number"></div>

                                </div>
                                <div class="widget-simple-sm-bottom statistic"><div class="caption color-green"><b>Total  Sessions</b></div></div>
                            </section>
                        </div>
                        <div class="col-xl-3">
                            <section class="widget widget-simple-sm">
                                <div class="widget-simple-sm-statistic">
                                    <div class="number"></div>

                                </div>
                                <div class="widget-simple-sm-bottom statistic"><div class="caption color-red"><b>Total Visit Duration (sec)</b> </div></div>
                            </section>
                        </div>
                        <div class="col-xl-3">

                            <section class="widget widget-simple-sm">
                                <div class="widget-simple-sm-statistic">
                                    <div class="number">div>

                                </div>
                                <div class="widget-simple-sm-bottom statistic"><div class="caption color-blue-grey-lighter"><b>Total Ads Slots</b>  </div></div>
                            </section>


                        </div>

                    </div> -->
            </header><!--.page-content-header-->
         
            <style>
                .widget-chart-extra-blue .chart {
    height: 310px !important;
}
                
            </style>
     <?php  if($userRow['user_role']!='Admin'){         ?>
           
<div class="container-fluid">
                    
			<header class="section-header">
				<div class="tbl">
					<div class="tbl-row">
						<div class="tbl-cell">
							
                                                        
                                                     
							
						</div>
					</div>
				</div>
			</header>
                    
                    
			<section class="card">
                            
                            <h5>&nbsp;</h5>
					
						
				<div class="card-block">
					<table   id="example" class="display dataTable" id="example" class="display table table-striped table-bordered" cellspacing="0" width="100%">
						<thead>
						<tr>
				   <th>Date</th>

                                              
                                                    <th>Spots</th>
                                                    <th>Status</th>
                                                    <th>Total Users</th>
                              
          
          
              
						</tr>
						</thead>
						<tfoot>
						<tr>
						

                                                    <th>Date</th>

                                             
                                                    <th>Spots</th>
                                                    <th>Status</th>
                                                    <th>Total Users</th>


        
						</tr>
						</tfoot>
						<tbody>
						
						
				
				<?php
                                                                

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
            } 
        }
       // var_dump($stmt1);	//die;
			
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
$stmt1_lm1 = $auth_user->runQuery("SELECT  count(aa_ip) as cnt FROM `ad_analytics` where aa_ad_id=$ad_id_usrs AND date(aa_datetime)='$dateofslot'"
        . "  ");
$stmt1_lm1->execute();

     $userRow_lm1224 = $stmt1_lm1->fetch(PDO::FETCH_ASSOC);
                                        $u1_forsess_lm224 = $userRow_lm1224['cnt'];

$cnt_ad_id_usrs= $u1_forsess_lm224;
$cnt_ad_id_usrs=nice_number($cnt_ad_id_usrs);


		
					?>
					
					<tr>
					
					  
         <td><?php echo(date("F d, Y ", strtotime($row['as_createdon']))); ?></td>
        
         
         <td><?php echo $cnt_ad_id_usrs_sl; ?></td>
        
         
            <td class="table-date"><span class="label label-success">Ad Played</span></td>
					
             
            
               
                  
                   
                    
                     <td><span class="btn btn-rounded btn-inline btn-primary"><?php echo $cnt_ad_id_usrs; ?></span></td>
                    
                    
         
                  
                  
                   
                    
                  
					
					
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

<?php } ?>
    </div><!--.container-fluid-->
<!--.page-content-->


<script src="js/lib/jquery/jquery.min.js"></script>
<script src="js/lib/tether/tether.min.js"></script>
<script src="js/lib/bootstrap/bootstrap.min.js"></script>

<script src="js/lib/datatables-net/datatables.min.js"></script>
	<script>
	$(document).ready(function() {
		
	var table = 	$('#example').DataTable( {
		"order": [[ 0, "asc" ]],
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
                    columns: [ 0, 1, 2, 3]
                }, title: 'Data_Ads'
            },
            'colvis'
        ]
    } );
		
 

    $("#example tfoot th").each( function ( i ) {
        
      
   

		
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
    } );
  
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
<script src="js/plugins.js"></script>
<script src="js/lib/d3/d3.min.js"></script>
<script src="js/lib/charts-c3js/c3.min.js"></script>
<script src="js/lib/charts-c3js/c3js-init.js"></script>

<script type="text/javascript" src="js/lib/jqueryui/jquery-ui.min.js"></script>
<script type="text/javascript" src="js/lib/lobipanel/lobipanel.min.js"></script>
<script type="text/javascript" src="js/lib/match-height/jquery.matchHeight.min.js"></script>
<script src="js/lib/asPieProgress/jquery-asPieProgress.min.js"></script>
<script src="js/lib/select2/select2.full.min.js"></script>
<script type="text/javascript" src="js/lib/match-height/jquery.matchHeight.min.js"></script>
<script src="js/lib/slick-carousel/slick.min.js"></script>

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
<script>

    $(document).ready(function () {
        console.log(11);

        


        var pieChart = c3.generate({
            bindto: '#pie-chart',
            data: {
                columns: [
                    ['Current Month Views', <?php echo $c_m_v; ?>],
                    ['Last month Views', <?php echo $c_lm_v; ?>]
                ],
                type: 'pie'
            }
        });

        var donutChart = c3.generate({
            bindto: '#donut-chart',
            data: {
                columns: [
                    ['Total Users', <?php echo $u1_forsess; ?>],
                    ['Total Returning Users', <?php echo $u1_forsess*$factr; ?>]
                ],
                type: 'donut'
            },
            donut: {
                title: "Overall Users Vs Returning "
            }
        });

      
    });

    $(function () {
        $(".circle-progress-bar").asPieProgress({
            namespace: 'asPieProgress',
            speed: 500
        });

        $(".circle-progress-bar").asPieProgress("start");


        $(".circle-progress-bar-typical").asPieProgress({
            namespace: 'asPieProgress',
            speed: 25
        });

        $(".circle-progress-bar-typical").asPieProgress("start");

        $('.widget-chart-combo-content-in, .widget-chart-combo-side').matchHeight();

        /* ==========================================================================
         Widget weather slider
         ========================================================================== */

        $('.widget-weather-slider').slick({
            arrows: false,
            dots: true,
            infinite: false,
            slidesToShow: 4,
            slidesToScroll: 4
        });
    });
</script>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>






<script type="text/javascript">
    google.charts.load('current', {'packages': ['corechart']});
    google.charts.setOnLoadCallback(drawBasic);

    function drawBasic() {

        var data = google.visualization.arrayToDataTable([
            ['Month', 'Value'],<?php echo $nvalg; ?>
        ]);

        var options = {
            legend: 'none',
            areaOpacity: 0.18,
            tooltip: {trigger: 'none'},
            hAxis: {
                textStyle: {
                    color: '#fff',
                    fontName: 'Proxima Nova',
                    fontSize: 11,
                    bold: true
                },
                gridlines: 'null'
            },
            vAxis: {
                minValue: 0,
                textStyle: {
                    color: '#fff',
                    fontName: 'Proxima Nova',
                    fontSize: 11,
                    bold: true
                },
                baselineColor: '#16b4fc',
                ticks: [<?php echo round($nval_sum/12,-3); ?>,<?php echo round($nval_sum/6,-3); ?>,<?php echo round($nval_sum/4,-3); ?>,<?php echo round($nval_sum/3,-3); ?>,<?php echo $nval_sum; ?>],
           //  ticks: [1000000,5000000,10000000,50000000],
                gridlines: {
                    color: '#1ba0fc',
                    count: 7
                },
            },
            lineWidth: 2,
            colors: ['#fff'],
            curveType: 'function',
            pointSize: 5,
            pointShapeType: 'circle',
            pointFillColor: '#f00',
            backgroundColor: {
                fill: '#008ffb',
                strokeWidth: 0
            },
            chartArea: {
                left: '10%',
                top: 5,
                width: '80%',
                height: 200
            }
        };

        var chart = new google.visualization.AreaChart(document.getElementById('chart_line'));

        chart.draw(data, options);
    }
    $(window).resize(function () {
        drawBasic();
    });
</script>
<script src="js/app.js"></script>
</body>
</html>