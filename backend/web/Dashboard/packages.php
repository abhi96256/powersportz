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
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/rowreorder/1.2.3/css/rowReorder.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="css/editor.dataTables.min.css">
<script type="text/javascript" language="javascript" src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js">
	</script>
	
	<script type="text/javascript" language="javascript" src="//code.jquery.com/jquery-1.12.4.js">
	</script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.14/js/jquery.dataTables.min.js">
	</script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js">
	</script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/select/1.2.2/js/dataTables.select.min.js">
	</script>
        <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/rowreorder/1.2.3/js/dataTables.rowReorder.min.js">
	</script>
	<script type="text/javascript" language="javascript" src="js/dataTables.editor.min.js">
	</script>
	

	
	<script type="text/javascript" language="javascript" class="init">
	



var editor; // use a global for the submit and return data rendering in the examples

$(document).ready(function() {
	editor = new $.fn.dataTable.Editor( {
		ajax: "examples/php/packages.php",
		
		table: "#example",
		fields: [ {
                label: 'Order:',
                name: 'readingOrder',
                fieldInfo: 'This field can only be edited via click and drag row reordering.'
            },{
		
				label: "Package Name:",
				name: "tbl_package_master_view.PMV_NAME"

			}, {
		
				label: "Package Code:",
				name: "tbl_package_master_view.PMV_BDD_CODE"

			},{
				label: "Price:",
				name: "tbl_package_master_view.PMV_PRICE",
				attr: {
    "type": "number"
  }
			
			},{
		
				label: "Package Validity:",
				name: "tbl_package_master_view.PMV_VAL",
                                  fieldInfo: 'Validity in days 1,7,30,365'

			},{
				label: "Package Start Date:",
				name: "tbl_package_master_view.PMV_OPEN_DATE",
				// label:     'Updated date:',
               // name:      'updated_date',
                type:      'datetime',
                def:       function () { return new Date(); },
                format:    'MM-DD-YYYY h:mm A',
                fieldInfo: 'IN style MM-DD-YYYY h:mm A date input with 12 hour clock'
				
			},
			{
				label: "Pacakge Close Date:",
				name: "tbl_package_master_view.PMV_CLOSE_DATE",
				type:      'datetime',
                def:       function () { return new Date(); },
                format:    'MM-DD-YYYY h:mm A',
                fieldInfo: 'IN style MM-DD-YYYY h:mm A date input with 12 hour clock'

			},{
		
				label: "Package Description:",
				name: "tbl_package_master_view.PMV_DESCRIPTION",
                                 type: "textarea",
                                   fieldInfo: 'Inclusions of Package'

			},{
		
				label: "Package Renewable:",
				name: "tbl_package_master_view.PMV_RENEWFLAG",
                                type: "select",
                options: [ "Y", "N"  ],
                def: "N"

			},
			

			{
				label: "Status:",
				name: "tbl_package_master_view.PMV_STATUS",
				//label: "Show options:",
              //  name: "options",
                type: "select",
                options: [ "A", "D"  ],
                def: "A"
			}
		]
	} );

	var table = $('#example').DataTable( {
		dom: "Bfrtip",
		ajax: "examples/php/packages.php",
		// contentType: "application/json; charset=utf-8",
		columns: [
                 { data: 'readingOrder', className: 'reorder' },
			{ data: "tbl_package_master_view.PMV_NAME" },
                        { data: "tbl_package_master_view.PMV_BDD_CODE" },
			{ data: "tbl_package_master_view.PMV_PRICE" },
                        { data: "tbl_package_master_view.PMV_VAL" },
                        { data: "tbl_package_master_view.PMV_OPEN_DATE" },
                        { data: "tbl_package_master_view.PMV_CLOSE_DATE" },
                        { data: "tbl_package_master_view.PMV_DESCRIPTION" },
                        { data: "tbl_package_master_view.PMV_RENEWFLAG" },
                        { data: "tbl_package_master_view.PMV_STATUS" },
                        
		],
		 columnDefs: [
            { orderable: false, targets: [ 1,2,3 ] }
        ],
        rowReorder: {
            dataSrc: 'readingOrder',
            editor:  editor
        },
        select: true,
		buttons: [
			{ extend: "create", editor: editor },
			{ extend: "edit",   editor: editor },
			{ extend: "remove", editor: editor }
		],
		
	} );
          editor
        .on( 'postCreate postRemove', function () {
            // After create or edit, a number of other rows might have been effected -
            // so we need to reload the table, keeping the paging in the current position
            table.ajax.reload( null, false );
        } )
        .on( 'initCreate', function () {
            // Enable order for create
            editor.field( 'readingOrder' ).enable();
        } )
        .on( 'initEdit', function () {
            // Disable for edit (re-ordering is performed by click and drag)
            editor.field( 'readingOrder' ).disable();
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
							<h3>Packages</h3>
						</div>
					</div>
				</header>
			
			
			<table id="example" class="display" cellspacing="0" width="100%">
				<thead>
					<tr>
					<th>Order</th>
						<th>Packages Name</th>
                                                <th>Packages Code</th>
                                                <th>Price</th>
                                                <th>Validity</th>
                                                <th>Open Date</th>
                                                <th>Close Date</th>
                                                <th>Description</th>
                                                <th>Renewable</th>
						<th>Status</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
                                            <th>Order</th>
					<th>Packages Name</th>
                                                <th>Packages Code</th>
                                                <th>Price</th>
                                                <th>Validity</th>
                                                <th>Open Date</th>
                                                <th>Close Date</th>
                                                <th>Description</th>
                                                <th>Renewable</th>
						<th>Status</th>
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