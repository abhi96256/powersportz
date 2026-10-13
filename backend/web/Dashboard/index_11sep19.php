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
if ($userRow['user_role'] == 'Admin') {
    $stmt1_cm1_grph = $auth_user->runQuery("SELECT DAYNAME(`aa_datetime`) as dt ,count(`aa_ip`) as aip,DATE(`aa_datetime`) as dt1 FROM ad_analytics group by date(`aa_datetime`) order by date(`aa_datetime`) desc limit 7 "
            . "  ");
} else {
    $stmt1_cm1_grph = $auth_user->runQuery("SELECT DAYNAME(`aa_datetime`) as dt ,count(`aa_ip`) as aip ,DATE(`aa_datetime`) as dt1 FROM ad_analytics inner join ads on aa_ad_id=`ad_id` inner join admin_users on ad_admin=user_id where `user_id`=$user_id group by date(`aa_datetime`) order by date(`aa_datetime`) desc limit 7 "
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
        if ($n > 1000000000000) return round(($n/1000000000000), 2).' trillion';
        elseif ($n > 1000000000) return round(($n/1000000000), 2).' billion';
        elseif ($n > 1000000) return round(($n/1000000), 2).' million';
        elseif ($n > 1000) return round(($n/1000), 2).' k';

        return number_format($n);
    }


//die;
?>						


                        </div>
                            <br/><br/>
                        <div class="container-fluid">
                    <div class="row">
                       
                        <div class="col-xl-12">
                            <div class="row">
                                <div class="col-sm-3">
                                    <article class="statistic-box red">
                                        <div>
                                            <div class="number"><?php
                                        if ($userRow['user_role'] == 'Admin') {
                                            $stmt1_cm1 = $auth_user->runQuery("SELECT  aa_ip FROM `ad_analytics` inner join ads on aa_ad_id=`ad_id` "
                                                    . "  ");
                                        } else {
                                            $stmt1_cm1 = $auth_user->runQuery("SELECT  aa_ip FROM `ad_analytics` inner join ads on aa_ad_id=`ad_id` inner join admin_users on ad_admin=user_id  where `user_id`=$user_id "
                                                    . "  ");
                                        }
                                        $stmt1_cm1->execute();
                                        $u1_forsess = $stmt1_cm1->rowCount();
                                        echo $u1 = nice_number($u1_forsess);
                                        ?>
                                            </div>
                                            <div class="caption"><div>Overall Users</div></div>
                                            <div class="percent">
                                                <div class="arrow up"></div>
                                                <p>5%</p>
                                            </div>
                                        </div>
                                    </article>
                                </div>
                                <div class="col-sm-3">
                                    <article class="statistic-box purple">
                                        <div>
                                            <div class="number"><?php
                                        if ($userRow['user_role'] == 'Admin') {
                                            $stmt1_lm1 = $auth_user->runQuery("SELECT distinct aa_ip FROM `ad_analytics` inner join ads on aa_ad_id=`ad_id`  "
                                                    . "  ");
                                        } else {
                                            $stmt1_lm1 = $auth_user->runQuery("SELECT distinct aa_ip FROM `ad_analytics` inner join ads on aa_ad_id=`ad_id` inner join admin_users on ad_admin=user_id  where `user_id`=$user_id "
                                                    . "  ");
                                        }
                                        $stmt1_lm1->execute();
                                        echo $u2 = nice_number($stmt1_lm1->rowCount()+$u1_forsess);

                                        $x1 = $stmt1_lm1->rowCount();
                                        $total1 = $stmt1_cm1->rowCount();
                                        $percentage1 = ($x1 * 100) / $total1;
                                        ?>  </div>
                                            <div class="caption"><div>Overall Sessions</div></div>
                                            <div class="percent">
                                                <div class="arrow down"></div>
                                                <p>11%</p>
                                            </div>
                                        </div>
                                    </article>
                                </div>
                                <div class="col-sm-3">
                                    <article class="statistic-box yellow">
                                        <div>
                                            <div class="number"><?php
                                        if ($userRow['user_role'] == 'Admin') {
                                            $stmt1_cm2 = $auth_user->runQuery("SELECT sum(aa_duration) as dur FROM `ad_analytics` inner join ads on aa_ad_id=`ad_id`  "
                                                    . " where aa_datetime > DATE_SUB(NOW(), INTERVAL 1 MONTH) ");
                                        } else {
                                            $stmt1_cm2 = $auth_user->runQuery("SELECT sum(aa_duration) as dur FROM `ad_analytics` inner join ads on aa_ad_id=`ad_id` inner join admin_users on ad_admin=user_id  where `user_id`=$user_id "
                                                    . " AND aa_datetime > DATE_SUB(NOW(), INTERVAL 1 MONTH) ");
                                        }
                                        $stmt1_cm2->execute();
                                        $result_cm = $stmt1_cm2->fetch();

                                        $dur1 = $result_cm ["dur"];

                                        if ($dur1 == null) {
                                            $dur1 = 0;
                                        }
                                        echo nice_number($dur1);
                                        ?></div>
                                            <div class="caption"><div>Overall Visit Duration (S)</div></div>
                                            <div class="percent">
                                                <div class="arrow down"></div>
                                                <p>5%</p>
                                            </div>
                                        </div>
                                    </article>
                                </div>
                                <div class="col-sm-3">
                                    <article class="statistic-box green">
                                        <div>
                                            <div class="number"><?php
                                        if ($userRow['user_role'] == 'Admin') {
                                            $stmt1_cm2 = $auth_user->runQuery("SELECT count(*) as dur FROM `ad_slots_his` inner join ads on as_ad_id=`ad_id`  order by as_createdon, as_starttime desc ");
                                        } else {
                                            $stmt1_cm2 = $auth_user->runQuery("SELECT count(*) as dur  FROM `ad_slots_his` inner join ads on as_ad_id=`ad_id` inner join admin_users on `ad_admin`=user_id AND ad_admin=$user_id  order by as_createdon, as_starttime desc  ");
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
                                    <div class="number"><?php
                                        if ($userRow['user_role'] == 'Admin') {
                                            $stmt1_cm1 = $auth_user->runQuery("SELECT  aa_ip FROM `ad_analytics` inner join ads on aa_ad_id=`ad_id` "
                                                    . "  ");
                                        } else {
                                            $stmt1_cm1 = $auth_user->runQuery("SELECT  aa_ip FROM `ad_analytics` inner join ads on aa_ad_id=`ad_id` inner join admin_users on ad_admin=user_id  where `user_id`=$user_id "
                                                    . "  ");
                                        }
                                        $stmt1_cm1->execute();
                                        echo $u1 = $stmt1_cm1->rowCount();
                                        ?></div>

                                </div>
                                <div class="widget-simple-sm-bottom statistic"><div class="caption color-blue"><b>Total Users</b></div></div>
                            </section>
                        </div>
                        <div class="col-xl-3">
                            <section class="widget widget-simple-sm">
                                <div class="widget-simple-sm-statistic">
                                    <div class="number"><?php
                                        if ($userRow['user_role'] == 'Admin') {
                                            $stmt1_lm1 = $auth_user->runQuery("SELECT distinct aa_ip FROM `ad_analytics` inner join ads on aa_ad_id=`ad_id`  "
                                                    . "  ");
                                        } else {
                                            $stmt1_lm1 = $auth_user->runQuery("SELECT distinct aa_ip FROM `ad_analytics` inner join ads on aa_ad_id=`ad_id` inner join admin_users on ad_admin=user_id  where `user_id`=$user_id "
                                                    . "  ");
                                        }
                                        $stmt1_lm1->execute();
                                        echo $u2 = $stmt1_lm1->rowCount();

                                        $x1 = $stmt1_lm1->rowCount();
                                        $total1 = $stmt1_cm1->rowCount();
                                        $percentage1 = ($x1 * 100) / $total1;
                                        ?></div>

                                </div>
                                <div class="widget-simple-sm-bottom statistic"><div class="caption color-green"><b>Total  Sessions</b></div></div>
                            </section>
                        </div>
                        <div class="col-xl-3">
                            <section class="widget widget-simple-sm">
                                <div class="widget-simple-sm-statistic">
                                    <div class="number"><?php
                                        if ($userRow['user_role'] == 'Admin') {
                                            $stmt1_cm2 = $auth_user->runQuery("SELECT sum(aa_duration) as dur FROM `ad_analytics` inner join ads on aa_ad_id=`ad_id`  "
                                                    . " where aa_datetime > DATE_SUB(NOW(), INTERVAL 1 MONTH) ");
                                        } else {
                                            $stmt1_cm2 = $auth_user->runQuery("SELECT sum(aa_duration) as dur FROM `ad_analytics` inner join ads on aa_ad_id=`ad_id` inner join admin_users on ad_admin=user_id  where `user_id`=$user_id "
                                                    . " AND aa_datetime > DATE_SUB(NOW(), INTERVAL 1 MONTH) ");
                                        }
                                        $stmt1_cm2->execute();
                                        $result_cm = $stmt1_cm2->fetch();

                                        $dur1 = $result_cm ["dur"];

                                        if ($dur1 == null) {
                                            $dur1 = 0;
                                        }
                                        echo $dur1;
                                        ?></div>

                                </div>
                                <div class="widget-simple-sm-bottom statistic"><div class="caption color-red"><b>Total Visit Duration (sec)</b> </div></div>
                            </section>
                        </div>
                        <div class="col-xl-3">

                            <section class="widget widget-simple-sm">
                                <div class="widget-simple-sm-statistic">
                                    <div class="number"><?php
                                        if ($userRow['user_role'] == 'Admin') {
                                            $stmt1_cm2 = $auth_user->runQuery("SELECT count(*) as dur FROM `ad_slots_his` inner join ads on as_ad_id=`ad_id`  order by as_createdon, as_starttime desc ");
                                        } else {
                                            $stmt1_cm2 = $auth_user->runQuery("SELECT count(*) as dur  FROM `ad_slots_his` inner join ads on as_ad_id=`ad_id` inner join admin_users on `ad_admin`=user_id AND ad_admin=$user_id  order by as_createdon, as_starttime desc  ");
                                        }
                                        $stmt1_cm2->execute();
                                        $result_cm = $stmt1_cm2->fetch();

                                        $dur1 = $result_cm ["dur"];

                                        if ($dur1 == null) {
                                            $dur1 = 0;
                                        }
                                        echo $dur1;
                                        ?></div>

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
							
                                                        
                                                        <?php 
                                                             $date_range=$_POST['date_value']; 
                                                        
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
                            
                            <h5>&nbsp;</h5><form method='POST' action='index.php'>
                            <div class="col-md-4">
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

        var lineChart = c3.generate({
            bindto: '#line-chart',
            data: {
                columns: [
                    ['data1', 30, 200, 100, 400, 150, 250],
                    ['data2', 50, 20, 10, 40, 15, 25]
                ],
                axes: {
                    data2: 'y2' // ADD
                }
            },
            axis: {
                y2: {
                    show: true // ADD
                }
            }
        });

        var splineChart = c3.generate({
            bindto: '#spline-chart',
            data: {
                columns: [
                    ['data1', 30, 200, 100, 400, 150, 250],
                    ['data2', 130, 100, 140, 200, 150, 50]
                ],
                type: 'spline'
            }
        });

        var stepChart = c3.generate({
            bindto: '#step-chart',
            data: {
                columns: [
                    ['data1', 300, 350, 300, 0, 0, 100],
                    ['data2', 130, 100, 140, 200, 150, 50]
                ],
                types: {
                    data1: 'step',
                    data2: 'area-step'
                }
            }
        });

        var areaChart = c3.generate({
            bindto: '#area-chart',
            data: {
                columns: [
                    ['data1', 300, 350, 300, 0, 0, 0],
                    ['data2', 130, 100, 140, 200, 150, 50]
                ],
                types: {
                    data1: 'area',
                    data2: 'area-spline'
                }
            }
        });

        var barChart = c3.generate({
            bindto: '#bar-chart',
            data: {
                columns: [
                    ['data1', 30, 200, 100, 400, 150, 250],
                    ['data2', 130, 100, 140, 200, 150, 50]
                ],
                type: 'bar'
            },
            bar: {
                width: {
                    ratio: 0.5
                }
            }
        });

        var scatterPlotChart = c3.generate({
            bindto: '#scatter-plot-chart',
            data: {
                xs: {
                    setosa: 'setosa_x',
                    versicolor: 'versicolor_x',
                },
                // iris data from R
                columns: [
                    ["setosa_x", 3.5, 3.0, 3.2, 3.1, 3.6, 3.9, 3.4, 3.4, 2.9, 3.1, 3.7, 3.4, 3.0, 3.0, 4.0, 4.4, 3.9, 3.5, 3.8, 3.8, 3.4, 3.7, 3.6, 3.3, 3.4, 3.0, 3.4, 3.5, 3.4, 3.2, 3.1, 3.4, 4.1, 4.2, 3.1, 3.2, 3.5, 3.6, 3.0, 3.4, 3.5, 2.3, 3.2, 3.5, 3.8, 3.0, 3.8, 3.2, 3.7, 3.3],
                    ["versicolor_x", 3.2, 3.2, 3.1, 2.3, 2.8, 2.8, 3.3, 2.4, 2.9, 2.7, 2.0, 3.0, 2.2, 2.9, 2.9, 3.1, 3.0, 2.7, 2.2, 2.5, 3.2, 2.8, 2.5, 2.8, 2.9, 3.0, 2.8, 3.0, 2.9, 2.6, 2.4, 2.4, 2.7, 2.7, 3.0, 3.4, 3.1, 2.3, 3.0, 2.5, 2.6, 3.0, 2.6, 2.3, 2.7, 3.0, 2.9, 2.9, 2.5, 2.8],
                    ["setosa", 0.2, 0.2, 0.2, 0.2, 0.2, 0.4, 0.3, 0.2, 0.2, 0.1, 0.2, 0.2, 0.1, 0.1, 0.2, 0.4, 0.4, 0.3, 0.3, 0.3, 0.2, 0.4, 0.2, 0.5, 0.2, 0.2, 0.4, 0.2, 0.2, 0.2, 0.2, 0.4, 0.1, 0.2, 0.2, 0.2, 0.2, 0.1, 0.2, 0.2, 0.3, 0.3, 0.2, 0.6, 0.4, 0.3, 0.2, 0.2, 0.2, 0.2],
                    ["versicolor", 1.4, 1.5, 1.5, 1.3, 1.5, 1.3, 1.6, 1.0, 1.3, 1.4, 1.0, 1.5, 1.0, 1.4, 1.3, 1.4, 1.5, 1.0, 1.5, 1.1, 1.8, 1.3, 1.5, 1.2, 1.3, 1.4, 1.4, 1.7, 1.5, 1.0, 1.1, 1.0, 1.2, 1.6, 1.5, 1.6, 1.5, 1.3, 1.3, 1.3, 1.2, 1.4, 1.2, 1.0, 1.3, 1.2, 1.3, 1.3, 1.1, 1.3],
                ],
                type: 'scatter'
            },
            axis: {
                x: {
                    label: 'Sepal.Width',
                    tick: {
                        fit: false
                    }
                },
                y: {
                    label: 'Petal.Width'
                }
            }
        });

        var combinationChart = c3.generate({
            bindto: '#combination-chart',
            data: {
                columns: [
                    ['data1', 30, 20, 50, 40, 60, 50],
                    ['data2', 200, 130, 90, 240, 130, 220],
                    ['data3', 300, 200, 160, 400, 250, 250],
                    ['data4', 200, 130, 90, 240, 130, 220],
                    ['data5', 130, 120, 150, 140, 160, 150],
                    ['data6', 90, 70, 20, 50, 60, 120]
                ],
                type: 'bar',
                types: {
                    data3: 'spline',
                    data4: 'line',
                    data6: 'area',
                },
                groups: [
                    ['data1', 'data2']
                ]
            }
        });

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
                    ['Total Users', <?php echo $u1; ?>],
                    ['Total Returning Users', <?php echo $u2; ?>]
                ],
                type: 'donut'
            },
            donut: {
                title: "Overall Users Vs Returning "
            }
        });

        var gaugeChart = c3.generate({
            bindto: '#gauge-chart',
            data: {
                columns: [
                    ['Ads Duration Current Month', <?php echo $percentage2; ?>]
                ],
                type: 'gauge',
                onclick: function (d, i) {
                    console.log("onclick", d, i);
                },
                onmouseover: function (d, i) {
                    console.log("onmouseover", d, i);
                },
                onmouseout: function (d, i) {
                    console.log("onmouseout", d, i);
                }
            },
            gauge: {
            },
            color: {
                pattern: ['#FF0000', '#F97600', '#F6C600', '#60B044'], // the three color levels for the percentage values.
                threshold: {
                    values: [30, 60, 90, 100]
                }
            },
            size: {
                height: 180
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





<script>
    $(document).ready(function () {
        $('.panel').lobiPanel({
            sortable: true
        });
        $('.panel').on('dragged.lobiPanel', function (ev, lobiPanel) {
            $('.dahsboard-column').matchHeight();
        });

        google.charts.load('current', {'packages': ['corechart']});
        google.charts.setOnLoadCallback(drawChart);
        function drawChart() {
            var dataTable = new google.visualization.DataTable();
            dataTable.addColumn('string', 'Day');
            dataTable.addColumn('number', 'Values');
            // A column for custom tooltip content
            dataTable.addColumn({type: 'string', role: 'tooltip', 'p': {'html': true}});
            dataTable.addRows([
                ['MON', 130, ' '],
                ['TUE', 130, '130'],
                ['WED', 180, '180'],
                ['THU', 175, '175'],
                ['FRI', 200, '200'],
                ['SAT', 170, '170'],
                ['SUN', 250, '250'],
                ['MON', 220, '220'],
                ['TUE', 220, ' ']
            ]);

            var options = {
                height: 314,
                legend: 'none',
                areaOpacity: 0.18,
                axisTitlesPosition: 'out',
                hAxis: {
                    title: '',
                    textStyle: {
                        color: '#fff',
                        fontName: 'Proxima Nova',
                        fontSize: 11,
                        bold: true,
                        italic: false
                    },
                    textPosition: 'out'
                },
                vAxis: {
                    minValue: 0,
                    textPosition: 'out',
                    textStyle: {
                        color: '#fff',
                        fontName: 'Proxima Nova',
                        fontSize: 11,
                        bold: true,
                        italic: false
                    },
                    baselineColor: '#16b4fc',
                    ticks: [0, 25, 50, 75, 100, 125, 150, 175, 200, 225, 250, 275, 300, 325, 350],
                    gridlines: {
                        color: '#1ba0fc',
                        count: 15
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
                    strokeWidth: 0,
                },
                chartArea: {
                    left: 0,
                    top: 0,
                    width: '100%',
                    height: '100%'
                },
                fontSize: 11,
                fontName: 'Proxima Nova',
                tooltip: {
                    trigger: 'selection',
                    isHtml: true
                }
            };

            var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
            chart.draw(dataTable, options);
        }
        $(window).resize(function () {
            drawChart();
            setTimeout(function () {
            }, 1000);
        });
    });
</script>
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
                ticks: [<?php echo round($nval_sum/12,-3); ?>,<?php echo round($nval_sum/6,-3); ?>,<?php echo round($nval_sum/4,-3); ?>,<?php echo round($nval_sum/3,-3); ?>],
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