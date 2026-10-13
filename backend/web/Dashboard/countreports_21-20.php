<?php

	//require_once("Login/session.php");
	
	require_once("Login/class.user.php");

	
	$auth_user = new USER();
	
        if(!empty($_POST)){
           // var_dump($_POST);
          $dfrom=  $_POST['datepicker_from'];
          $dto=  $_POST['datepicker_to'];
         // echo '--hi--';
        }
	
       //die;
         
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

`
    <link rel="stylesheet" href="css/lib/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="css/main.css">
	<link rel="stylesheet" href="css/lib/datatables-net/datatables.min.css">
<link rel="stylesheet" href="css/separate/vendor/datatables-net.min.css">
</head>
<body class="with-side-menu control-panel control-panel-compact">

<?php include("inc/head.php"); ?>
	
	<div class="mobile-menu-left-overlay"></div>
<?php //include("inc/left.php"); ?>
        <style>
            .control-panel .page-content {
     padding-right: 0px !important; 
}
.with-side-menu .page-content {
    padding-left: 0px !important;
}
            
        </style>
	
	<div class="page-content">
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
                            
                            
					
						
				<div class="card-block">
                                    <h2>Advertisement Click Report&nbsp;</h2>
					
                                    <div><p>
                                        <form action="countreports.php" method="POST" >
    <span id="date-label-from" class="date-label">From: </span><input class="date_range_filter date" type="date" value="<?php if($dfrom !=''){ echo $dfrom;} ?>" name="datepicker_from" />
    <span id="date-label-to" class="date-label">To:<input class="date_range_filter date" value="<?php if($dto !=''){ echo $dto;} ?>" type="date" name="datepicker_to" />
        <input type="submit" class="btn btn-inline btn-secondary" style="height:30px !important;padding:1px !important;"  value=" Go ">
                                        </form></p></div>
                                    <table   id="example" class="display dataTable" id="example" class="display table table-striped table-bordered" cellspacing="0" width="100%">
						<thead>
						<tr>
								
         <th>S.no</th>   		
        <th>Date </th>
                                    
                                       <th>Count</th>
                                       <th>Action</th>
           
            
             
         
          
          
              
						</tr>
						</thead>
						<tfoot>
						<tr>
						
         <th>S.no</th>   		
        <th>Date </th>
                                    
                                       <th>Count</th>
                                        <th>Action</th>
                                       
                                      
           		
            
             
         
            
        
						</tr>
						</tfoot>
						<tbody>
						
						
				
				<?php
                                                                

	
                                
				try
		{
			
		if($dfrom !='' AND $dto !=''){ 
	  $stmt1 = $auth_user->runQuery("SELECT date(`ac_datetime`) as cdate,count(*) as cnt FROM `a_count` where date(`ac_datetime`) between '$dfrom' AND '$dto'  group by date(`ac_datetime`) ");
                }else{
                $stmt1 = $auth_user->runQuery("SELECT date(`ac_datetime`) as cdate,count(*) as cnt FROM `a_count` group by date(`ac_datetime`) ");
              
                }
              //  echo "SELECT date(`ac_datetime`) as cdate,count(*) as cnt FROM `a_count` where date(`ac_datetime`) between '$dfrom' AND '$dto'  group by date(`ac_datetime`) ";
			
	$stmt1->execute();
	
	//$userRow1=$stmt1->fetch(PDO::FETCH_ASSOC);
	//echo $stmt1->rowCount(); die;

		if($stmt1->rowCount() > 0)
				{  $i=1;
					while($row = $stmt1->fetch()){  //echo '1';
					



					


$cdate=$row['cdate'];

$cnt=$row['cnt'];



							
		
		
					?>
					
					<tr>
					
	<td><?php echo $i ?></td>				  
         <td class="table-date"><span class="label label-warning"><?php echo $cdate; ?></td>
         
      
         
            <td class="table-date"><span class="label label-success"><?php echo $cnt; ?></span></td>
            <td class="table-date"><span class="btn btn-inline btn-primary btn-sm ladda-button"><a style='color:#fff' href="countreports_detail.php?d=<?php echo $cdate; ?>"> Detail</a></span></td>
             
	
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
		"order": [[ 1, "desc" ]],
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
                    columns: [ 0, 1, 2]
                }, title: 'Data_Ads'
            },
            'colvis'
        ]
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