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
	<title>  Dashboard</title>

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

	<script type="text/javascript" language="javascript" src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js">
	</script>
<script type="text/javascript" language="javascript" src="//code.jquery.com/jquery-1.12.4.js">
	</script>
        <script src="js/lib/jquery/jquery.min.js"></script>
	<script src="js/lib/tether/tether.min.js"></script>
	<script src="js/lib/bootstrap/bootstrap.min.js"></script>
	<script src="js/plugins.js"></script>
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
		ajax: "examples/php/purchaserequest.php",
		
		table: "#example",
		fields: [ {
                label:     "Status:",
                name:      "tbl_sub_counters.active",
                type:      "checkbox",
                separator: "|",
                options:   [
                    { label: '', value: 1 }
                ]
            }, {
		
				label: "User ID:",
				name: "tbl_subdealer.tsb_userid",
				//  def: "Quiz"

			},{
		
				label: "Applicant Name:",
				name: "tbl_subdealer.tsb_applicantname",
				//  def: "Quiz"

			},{
				label: "Category:",
				//label: "Site:",
                name: "tbl_sub_counters.tsc_countertype",
                type: "select"
			//	name: "catid"
			},
			
                            {
		
				label: "Rate:",
				name: "tbl_sub_counters.tsc_rate",
                                attr: {
    "type": "number"
  }
				//  def: "Quiz"

			},{
		
				label: "Duration:",
				name: "customertype.duration",
				//  def: "Quiz"

			},{
		
				label: "Quantity:",
				name: "tbl_sub_counters.tsc_counterqty",
				//  def: "Quiz"

			},
		]
	} );

	var table = $('#example').DataTable( {
		dom: "Bfrtip",
		ajax: "examples/php/purchaserequest.php",
		// contentType: "application/json; charset=utf-8",
		columns: [
			{ data: "tbl_subdealer.tsb_userid" },
                        { data: "tbl_subdealer.tsb_applicantname" },
			{ data: "customertype.typeName" },
			
			
                            { data: "tbl_sub_counters.tsc_rate" },
                             { data: "customertype.duration" },
                             { data: "tbl_sub_counters.tsc_counterqty" },
                            {
                data:   "tbl_sub_counters.active",
                render: function ( data, type, row ) {
                    if ( type === 'display' ) {
                        return '<input type="checkbox" class="editor-active">';
                    }
                    return data;
                },
                className: "dt-body-center"
            }
		],
		select: {
            style: 'os',
            selector: 'td:not(:last-child)' // no row selection on last column
        },
		buttons: [
			{ extend: "create", editor: editor },
			{ extend: "edit",   editor: editor },
			{ extend: "remove", editor: editor },
			{
                extend: 'collection',
                text: 'Export',
                buttons: [
                    'copy',
                    'excel',
                    'csv',
                    'pdf',
                    'print'
                ]
            }
		], rowCallback: function ( row, data ) {
            // Set the checked state of the checkbox in the table
            $('input.editor-active', row).prop( 'checked', data.tbl_sub_counters.active == 1 );
        }
		
	} );
          $('#example').on( 'change', 'input.editor-active', function () {
        editor
            .edit( $(this).closest('tr'), false )
            .set( 'tbl_sub_counters.active', $(this).prop( 'checked' ) ? 1 : 0 )
            .submit();
    } );
} );



	</script>
		<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js">
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
	<script type="text/javascript" language="javascript" src="../resources/syntax/shCore.js">
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
							<h3>Sub Dealer Purchase Requests </h3>
						</div>
					</div>
				</header>
			
			
			<table id="example" class="display" cellspacing="0" width="100%">
				<thead>
					<tr>
				
						<th>User ID </th>
                                                <th>Applicant Name </th>
						<th>Counter Type</th>
						
						   <th>Rate</th>
						
					
                                                <th>Duration</th>
                                                  <th>Quantity</th>
                                                    
                                                  <th>Active</th>
                                                
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th>User ID </th>
                                                    <th>Customer Name </th>
						<th>Counter Type</th>
						
						   <th>Rate</th>
						
					
                                                <th>Duration</th>
                                                  <th>Quantity</th>
                                                  
                                                  <th>Active</th>
					</tr>
				</tfoot>
			</table>
	
			
				
			</div>
		
</div><!--.page-content-->


<script src="js/app.js"></script>




</body>
</html>