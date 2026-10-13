<?php

	require_once("Login/session.php");
	
	require_once("Login/class.user.php");

	
	$auth_user = new USER();
	
	
	$user_id = $_SESSION['user_session'];
	
	$stmt = $auth_user->runQuery("SELECT * FROM admin_users WHERE user_id=:user_id");
	$stmt->execute(array(":user_id"=>$user_id));
	
	$userRow=$stmt->fetch(PDO::FETCH_ASSOC);

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
							<h3>Pop up Image Advertisement Reports</h3>
							
						</div>
					</div>
				</div>
			</header>
			<section class="card">
				<div class="card-block">
					<table   id="example" class="display dataTable" id="example" class="display table table-striped table-bordered" cellspacing="0" width="100%">
						<thead>
						<tr>
				
           		
      <th>Status</th>
            <th>Name</th>
           
          
               <th>Total Impressions</th>
                <th>Unique Impressions</th>
          
          
              
						</tr>
						</thead>
						<tfoot>
						<tr>
						
            		
          <th>Status</th>
            <th>Name</th>
           
          
               <th>Total Impressions</th>
                <th>Unique Impressions</th>
            
        
						</tr>
						</tfoot>
						<tbody>
						
						
				
				<?php
				try
		{
			
		
	if($userRow['user_role']=='Admin'){
			$stmt1 = $auth_user->runQuery("SELECT `ap_id`, `ap_name`, `ap_pic_id`, `ap_admin_id`, `ap_status` FROM `ad_pop`     ");
			
        }else{
           $stmt1 = $auth_user->runQuery("SELECT `ap_id`, `ap_name`, `ap_pic_id`, `ap_admin_id`, `ap_status` FROM `ad_pop` inner join admin_users on `ap_admin_id`=user_id AND ap_admin_id=$user_id   ");
			 
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

					
					if($row['as_starttime']>$date_time){
$otp='warning';
$otext='Ad Viewed';
}
else{
$otp='success';
$otext='Ad Viewed';
}

$ad_id_usrs=$row['ap_id'];
$slot_id_usrs=$row['as_id'];

//echo "SELECT  aa_userid FROM `ad_analytics` inner join ads on ad_admin=ad_id where `ad_admin`=$user_id AND aa_ad_id=$ad_id_usrs AND aa_slot_id=$slot_id_usrs"; die;
			
$stmt1_lm1 = $auth_user->runQuery("SELECT  aa_ip FROM `ad_analytics_pop` where aa_ad_id=$ad_id_usrs "
        . "  ");
$stmt1_lm1->execute();
$cnt_ad_id_usrs= $stmt1_lm1->rowCount();


$stmt1_cm1 = $auth_user->runQuery("SELECT  distinct aa_ip FROM `ad_analytics_pop` where aa_ad_id=$ad_id_usrs  "
        . "  ");
$stmt1_cm1->execute();
$cnt_ad_id_usrs_uni= $stmt1_cm1->rowCount();
							
		
		
					?>
					
					<tr>
					
					  
         
         
            <td class="table-date"><span class="label label-<?php echo $otp; ?>"><?php echo $otext; ?></span></td>
					
             <td><?php echo $row['ap_name']; ?></td>
            
               
                  
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
                }, title: 'Data_Ads_image'
            },
			{
                extend: 'print',
                exportOptions: {
                    columns: [ 0, ':visible' ]
                }, title: 'Data_Ads_image'
            },
			 {
                extend: 'csv',
                exportOptions: {
                    columns: [ 0, ':visible' ],
					 
                }, title: 'Data_Ads_image'
            },
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: ':visible'
                }, title: 'Data_Ads_image'
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2, 3]
                }, title: 'Data_Ads_image'
            },
            'colvis'
        ]
    } );
		
 

    $("#example tfoot th").each( function ( i ) {
        
        if(i > 0 && i < 5) {
   

		
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

<script src="js/app.js"></script>
</body>
</html>