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
	

	
	<script type="text/javascript" language="javascript" class="init">
	



var editor; // use a global for the submit and return data rendering in the examples

$(document).ready(function() {
	
	editor = new $.fn.dataTable.Editor( {
		
		ajax: "examples/php/tourcat.php",
		
		table: "#example",
		fields: [ {
		
				label: "Tour Heading:",
				name: "sk_tour_categories.stc_title",
				attr: {
   placeholder :'Title'
  }


			},{label: "Tour Description:",
				name: "sk_tour_categories.stc_desc",
				type: 'textarea',
				
				attr: {
   placeholder :'Decription'
  }

			}, {
				label: "Tour Order:",
				name: "sk_tour_categories.stc_order",
						default: 1,
				attr: {
				"type": "number"
				}
			
			},{label: "Tour Tags:",
				name: "sk_tour_categories.stc_tags",
				attr: {
   placeholder :'Tours,Travel etc'
  }


			},
			

			{
				label: "Tour Small Image",
				name: "sk_tour_categories.stc_file_id",
				type: "upload",
				display: function ( file_id ) {
					return '<img width="150px" src="'+editor.file( 'files', file_id ).web_path+'"/>';
				},
				clearText: "Clear",
				noImageText: 'No image'
			},
				{
				label: "Tour Header Image",
				name: "sk_tour_categories.stc_file_id_big",
				type: "upload",
				display: function ( file_id ) {
					return '<img width="150px" src="'+editor.file( 'files', file_id ).web_path+'"/>';
				},
				clearText: "Clear",
				noImageText: 'No image'
			},{
				label: "Status:",
				name: "sk_tour_categories.stc_status",
				//label: "Show options:",
              //  name: "options",
                type: "select",
                options: [ "On", "Off"  ],
                def: "On"
			}
		]
	} );

	var table = $('#example').DataTable( {
		
		dom: "Bfrtip",
		ajax: "examples/php/tourcat.php",
		// contentType: "application/json; charset=utf-8",
		columns: [
			
			{ data: "sk_tour_categories.stc_title" },
			{ data: "sk_tour_categories.stc_desc" },
			
			{ data: "sk_tour_categories.stc_order" },
			{ data: "sk_tour_categories.stc_tags" },
			
			{
				data: "sk_tour_categories.stc_file_id",
				render: function ( file_id ) {
					return file_id ?
						'<img width="150px" src="'+editor.file( 'files', file_id ).web_path+'"/>' :
						null;
				},
				defaultContent: "No image",
				title: "Tour Small Image"
			},
			{
				data: "sk_tour_categories.stc_file_id_big",
				render: function ( file_id ) {
					return file_id ?
						'<img width="150px" src="'+editor.file( 'files', file_id ).web_path+'"/>' :
						null;
				},
				defaultContent: "No image",
				title: "Tour Large Image"
			},
				{ data: "sk_tour_categories.stc_status" },
		],
		select: true,
		buttons: [
			{ extend: "create", editor: editor },
			{ extend: "edit",   editor: editor },
			{ extend: "remove", editor: editor }
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
							<h3>Tour Categories !!</h3>
						</div>
					</div>
				</header>
			
			
			<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>Tour Heading</th>
						<th>Tour Description</th>
						<th>Tour Order</th>
						<th>Tour Tags</th>
						<th>Tour Small Image</th>
						<th>Tour Large Image</th>
						<th>Tour Status</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
					    <th>Tour Heading</th>
						<th>Tour Description</th>
						<th>Tour Order</th>
						<th>Tour Tags</th>
						<th>Tour Small Image</th>
						<th>Tour Large Image</th>
						<th>Tour Status</th>
					</tr>
				</tfoot>
			</table>
	
			
				
			</div>
		
</div><!--.page-content-->
<script src="js/lib/bootstrap/bootstrap.min.js"></script>


	

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