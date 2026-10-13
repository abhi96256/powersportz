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
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.14/css/jquery.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.3.1/css/buttons.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/select/1.2.2/css/select.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="css/editor.dataTables.min.css">

	<style type="text/css" class="init">
	
	</style>
	<script src="//cdn.ckeditor.com/4.6.2/basic/ckeditor.js"></script>
	<script type="text/javascript" language="javascript" src="//code.jquery.com/jquery-1.12.4.js">
	</script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.14/js/jquery.dataTables.min.js">
	</script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js">
	</script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/select/1.2.2/js/dataTables.select.min.js">
	</script>
	<script type="text/javascript" language="javascript" src="js/dataTables.editor.min.js">
	</script>
		<style>
	div.DTED_Lightbox_Wrapper {
    left: 1em;
    right: 1em;
    margin-left: 0;
	
    width: auto;

}
table.display td {
	
overflow: hidden;
white-space: nowrap;
text-overflow: ellipsis;
-o-text-overflow: ellipsis;
}
	</style>

	
	<script type="text/javascript" language="javascript" class="init">
	



var editor; // use a global for the submit and return data rendering in the examples

$(document).ready(function() {
	editor = new $.fn.dataTable.Editor( {
		ajax: "examples/php/sitemanager.php",
		
		table: "#example",
		fields: [ {
		
				label: "About MD:",
				name: "tbl_sitemanager.ts_about",
				   type: "ckeditor",

			}, {
				label: "MD Picture:",
				name: "tbl_sitemanager.ts_picid",
				type: "upload",
				display: function ( file_id ) {
					return '<img width="150px" src="'+editor.file( 'files', file_id ).web_path+'"/>';
				},
				clearText: "Clear",
				noImageText: 'No image'
			},{
				label: "Payment:",
				name: "tbl_sitemanager.ts_payment",
				   type: "ckeditor",
				
			
			},{
				label: "Refund Plolicy:",
				name: "tbl_sitemanager.ts_refund",
				   type: "ckeditor",
				
			
			},
			{
				label: "Terms & Conditions:",
				name: "tbl_sitemanager.ts_terms",
				//label: "Show options:",
              //  name: "options",
                type: "ckeditor",
                
			}

			
		]
	} );

	var table = $('#example').DataTable( {
		dom: "Bfrtip",
		ajax: "examples/php/sitemanager.php",
		// contentType: "application/json; charset=utf-8",
		
		columns: [
			{ data: "tbl_sitemanager.ts_about" ,"width": "30%" },
                            
			
			{
				data: "tbl_sitemanager.ts_picid", 
				display: function ( file_id ) {
					return '<img width="150px" src="'+editor.file( 'files', file_id ).web_path+'"/>';
				},
				defaultContent: "No image",
				title: "Image"
			},
                               { data: "tbl_sitemanager.ts_payment" ,"width": "30%"  },
			{ data: "tbl_sitemanager.ts_refund" ,"width": "30%"  },
                     
			{ data: "tbl_sitemanager.ts_terms" ,"width": "30%"  }
			
		],
		select: true,
		buttons: [
			
			{ extend: "edit",   editor: editor }
		],
		
	} );
} );



	</script>
	
</head>
<body class="with-side-menu control-panel control-panel-compact">

<?php include("inc/head.php"); ?>
	
	<div class="mobile-menu-left-overlay"></div>
<?php include("inc/left.php"); ?>

	
	<div class="page-content">
	
	<div class="container">
	
				<header class="box-typical-header">
					<div class="tbl-row">
						<div class="tbl-cell tbl-cell-title">
							<h3>Site Manager!!</h3>
						</div>
					</div>
				</header>
			
			
			<table id="example" class="display" cellspacing="0" width="100%">
				<thead>
					<tr>
					
						<th>About Us</th>
						<th>MD Picture</th>
						
					
						
							<th>Payment</th>
                                                        <th>Refund Policy</th>
							<th>Terms & Conditions</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
					
						<th>About Us</th>
						<th>MD Picture</th>
						
					
						
							<th>Payment</th>
                                                        <th>Refund Policy</th>
							<th>Terms & Conditions</th>
					</tr>
				</tfoot>
			</table>
	
			
				
			</div>
		
</div><!--.page-content-->
<script src="js/lib/bootstrap/bootstrap.min.js"></script>


			<script type="text/javascript" language="javascript" src="js/editor.ckeditor.js">
</script>
	<script>
		$(function () {
			$(".bar-chart").peity("bar",{
				delimiter: ",",
				fill: ["#919fa9"],
				height: 16,
				max: null,
				min: 0,
				padding: 0.1,
				width: 384
			});

			
		});
	</script>

</body>
</html>