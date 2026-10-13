<?php

	require_once("Login/session.php");
	
	require_once("Login/class.user.php");

	
	$auth_user = new USER();
	
	
	$user_id = $_SESSION['user_session'];
	
	$stmt = $auth_user->runQuery("SELECT * FROM admin_users WHERE user_id=:user_id");
	$stmt->execute(array(":user_id"=>$user_id));
        
        $del_id=$_REQUEST['del_id'];
        If($del_id !=''){
            
               $stmtsel = $auth_user->runQuery("SELECT as_starttime FROM ad_slots WHERE as_id=:user_id");
	$stmtsel->execute(array(":user_id"=>$del_id));
        
        	$userRow_sel=$stmtsel->fetch(PDO::FETCH_ASSOC);
              $del_id_h=  $userRow_sel['as_starttime']; //die;
            
           $stmtd = $auth_user->runQuery("delete from ad_slots WHERE as_id=:del_id order by as_id desc limit 1");
	$stmtd->execute(array(":del_id"=>$del_id));
        
     
        
        
         $stmtd_h = $auth_user->runQuery("delete from ad_slots_his WHERE as_starttime=:del_id order by as_id desc limit 1 ");
	$stmtd_h->execute(array(":del_id"=>$del_id_h)); 
        
        }
	
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
                     <?php
                                                        if($_REQUEST['f']=='t'){
                                                            echo '<div class="alert alert-success" role="alert">
					<p>Ads Slots Added Succesfully!
					</p>
				</div>';
                                                        }
                                                        
                                                        
                                                        
                                                           If($del_id !=''){
                                                                      echo '<div class="alert alert-success" role="alert">
					<p>Ad Slots Deleted Succesfully!
					</p>
				</div>';    
                                                           }
                                                        ?>
                    
                <section class="box-typical box-typical-dashboard panel panel-default scrollable">
	                   <header class="box-typical-header">
					<div class="tbl-row">
						<div class="tbl-cell tbl-cell-title">
                                                    
                                                    
							<h3>Running Advertisements Slots</h3>
                                                       
                                                        
						</div>
						
						
					</div>
				</header>
	                    <div class="panel-body">
	                        <table class="table table-hover">
	                            <tr>
                                        <th><div>#</div></th>
	                                <th><div>Status</div></th>
	                                <th><div>Name</div></th>
                                      
	                                <th ><div><i class="font-icon font-icon-cam-video"></i> Start Time</div></th>
	                                <th><div><i class="font-icon font-icon-clock"></i> Duration</div></th>
                                        
                                             <?php if($userRow['user_role']=='Admin'){ ?>
                                        <th><div class="tbl-cell tbl-cell-action-bordered">
							<button type="button" class="action-btn"><i class="font-icon font-icon-trash"></i></button>
						</div></th>
                                             <?php } ?>
	                            </tr>
                                    
                                     <?php
				try
		{
			
		
	if($userRow['user_role']=='Admin'){
			$stmt1 = $auth_user->runQuery("SELECT * FROM `ad_slots` inner join ads on as_ad_id=`ad_id` order by as_starttime  ");
			
        }else{
            $stmt1 = $auth_user->runQuery("SELECT * FROM `ad_slots` inner join ads on as_ad_id=`ad_id` inner join admin_users on `ad_admin`=user_id AND ad_admin=$user_id order by as_starttime  ");
			
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
$otext='To be Played';
$del_f=1;
}
else{
$otp='success';
$otext='Ad Played';
$del_f=0;
}


					
		
					?>
				
                                    <tr><td><?php echo $i; ?></td>
	                                <td>
	                                    <span class="label label-<?php echo $otp; ?>"><?php echo $otext; ?></span>
	                                </td>
	                                <td><?php echo $row['ad_name']; ?></td>
	                                <td align="center"><?php echo $row['as_starttime']; ?></td>
	                                <td nowrap align="center"><span class="semibold"><?php echo $row['ad_duration']; ?></span> Sec</td>
                                        <?php if($userRow['user_role']=='Admin'){
                                            
                                            
                                            ?>
                                        <td>
                                            
                                                <button <?php if($del_f=='1'){ echo ''; }else{ echo 'disabled'; } ?> type="button" onClick="deleteme(<?php echo $row['as_id']; ?>)" name="Delete" value="Delete" class="action-btn"><i class="font-icon font-icon-trash"></i></button>
                                            </td>
                                        <?php } ?>
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
	                      
	                        </table>
	                    </div><!--.box-typical-body-->
	                </section><!--.box-typical-dashboard-->
                    
			
			
		</div><!--.container-fluid-->
	</div><!--.page-content-->
<script language="javascript">
 function deleteme(delid)
 {
 if(confirm("Do you want Delete!")){
 window.location.href='slots.php?del_id=' +delid+'';
 return true;
 }
 } 
 </script>
	<script src="js/lib/jquery/jquery.min.js"></script>
	<script src="js/lib/tether/tether.min.js"></script>
	<script src="js/lib/bootstrap/bootstrap.min.js"></script>
	<script src="js/plugins.js"></script>

	<script src="js/lib/datatables-net/datatables.min.js"></script>
	<script>
	$(document).ready(function() {
		
	var table = 	$('#example').DataTable( {
		"order": [[ 0, "desc" ]],
		"oLanguage": {
			"sInfo": "Showing _START_ to _END_ of _TOTAL_ items."
		},
		
        dom: 'Bfrtip',
        buttons: [ 
            {
                extend: 'copyHtml5',
                exportOptions: {
                    columns: [ 0, ':visible' ]
                }, title: 'Data_VOTT'
            },
			{
                extend: 'print',
                exportOptions: {
                    columns: [ 0, ':visible' ]
                }, title: 'Data_VOTT'
            },
			 {
                extend: 'csv',
                exportOptions: {
                    columns: [ 0, ':visible' ],
					 
                }, title: 'Data_VOTT'
            },
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: ':visible'
                }, title: 'Data_VOTT'
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2, 3,4,5,6,7]
                }, title: 'Data_VOTT'
            },
            'colvis'
        ]
    } );
		
 

    $("#example tfoot th").each( function ( i ) {
        
        if(i < 6) {
   

		
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