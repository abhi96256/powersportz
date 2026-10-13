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
							<h2>User Logged In </h2>
							<div class="subtitle">Users Dashboard</div>
						</div>
					</div>
				</div>
			</header>
			<section class="card">
				<div class="card-block">
					<table   id="example" class="display table table-striped table-bordered" id="example" class="display table table-striped table-bordered" cellspacing="0" width="100%">
						<thead>
						<tr>
				
					
            <th>User</th>
           
            
            <th>Registered on</th>
            
						</tr>
						</thead>
						<tfoot>
						<tr>
						
            <th>User</th>
            
            
            <th>Registered on</th>
              
						</tr>
						</tfoot>
						<tbody>
						
						
				
				<?php
				try
		{
			
			if(@$_REQUEST['st']!=''){
		
		$st=@$_REQUEST['st'];
$st_q="where doc like '$st%' AND uemail !='' ";

if(@$_REQUEST['et']!=''){
		$et=@$_REQUEST['et'];
$st_q="where doc > '$st' AND doc < '$et' ";
	}else{ $st_q="where doc like '$st%' AND uemail !='' "; }


	}else{
		$st=''; 
		$et='';
		}
	
			$stmt1 = $auth_user->runQuery("SELECT `UID`, `Fuid`, `Ffname`, `Femail`, `fform`, `fotp`, `uemail`, `uphone`, `uaddress`, `ttsaved`, `fbpic`, `gender`, `state`, `city`, `dob`, `tnc`,doc FROM `users` where uemail=''  ");
			
		
			
	$stmt1->execute();
	
	//$userRow1=$stmt1->fetch(PDO::FETCH_ASSOC);
	

		if($stmt1->rowCount() > 0)
				{  $i=1;
					while($row = $stmt1->fetch()){  //echo '1';
					//var_dump($row);
					
					if($row[4]=='1'){
$otp='Verified';
}elseif($row[4]=='0'){
$otp='OTP sent not verified';
}
else{
$otp='Not Verified';
}

if($row[11]=='1'){
$gen='Female';
}elseif($row[11]=='0'){
$gen='Male';
}
else{
$gen='NA';
}
					
		
					?>
					
					<tr>
					
					  
            <td><img src="https://graph.facebook.com/<?php echo $row[1]; ?>/picture?type=square" /> <?php echo $row[2]; ?></td>
         
           
                   <td><?php echo(date("F d, Y h:i:s", strtotime($row['doc']))); ?></td>
                 
					
					
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
		
		$('#example').DataTable( {
        dom: 'Bfrtip',
        buttons: [ 
            {
                extend: 'copyHtml5',
                exportOptions: {
                    columns: [ 0, ':visible' ]
                }, title: 'Data_export_dimaglaga'
            },
			{
                extend: 'print',
                exportOptions: {
                    columns: [ 0, ':visible' ]
                }, title: 'Data_export_dimaglaga'
            },
			 {
                extend: 'csv',
                exportOptions: {
                    columns: [ 0, ':visible' ],
					 
                }, title: 'Data_export_dimaglaga'
            },
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: ':visible'
                }, title: 'Data_export_dimaglaga'
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: [ 0, 1 ]
                }, title: 'Data_export_dimaglaga'
            },
            'colvis'
        ]
    } );
		
    // Setup - add a text input to each footer cell
    $('#example tfoot th').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
    } );
 
    // DataTable
    var table = $('#example').DataTable();
 
    // Apply the search
    table.columns().every( function () {
        var that = this;
 
        $( 'input', this.footer() ).on( 'keyup change', function () {
            if ( that.search() !== this.value ) {
                that
                    .search( this.value )
                    .draw();
            }
        } );
    } );
} );
	
	
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