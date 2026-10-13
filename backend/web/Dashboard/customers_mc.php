<?php

	require_once("Login/session.php");
	
	require_once("Login/class.user.php");

	
	$auth_user = new USER();
	
	
	$user_id = $_SESSION['user_session'];
	
	$stmt = $auth_user->runQuery("SELECT * FROM admin_users WHERE user_id=:user_id");
	$stmt->execute(array(":user_id"=>$user_id));
	
	$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
//print_r($_SESSION);die;
?>
<!DOCTYPE html>

<html>
<head lang="en">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Dashboard</title>

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

        <link rel="stylesheet" href="css/separate/vendor/bootstrap-select/bootstrap-select.min.css">
<link rel="stylesheet" href="css/separate/vendor/select2.min.css">
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
							<h3>Form extras</h3>
							<ol class="breadcrumb breadcrumb-simple">
								<li><a href="#">StartUI</a></li>
								<li><a href="#">Forms</a></li>
								<li class="active">Form extras</li>
							</ol>
						</div>
					</div>
				</div>
			</header>

			<section class="card">
				<div class="card-block">
					<h5 class="with-border">Elastic textarea</h5>

					<div class="row">
						<div class="col-xs-12">
							<fieldset class="form-group">
								<label class="form-label" for="exampleInputEmail1">Text</label>
								<textarea rows="4" class="form-control" placeholder="Press Enter" data-autosize></textarea>
							</fieldset>
						</div>
					</div><!--.row-->

					<h5 class="with-border m-t-lg">Max Length</h5>

					<div class="row">
						<div class="col-lg-4">
							<fieldset class="form-group">
								<label class="form-label" for="exampleInput">First Name</label>
								<input type="text" class="form-control maxlength-simple" id="exampleInput" placeholder="First Name" maxlength="15">
								<small class="text-muted">Max length 15, simple</small>
							</fieldset>
						</div>
						<div class="col-lg-4">
							<fieldset class="form-group">
								<label class="form-label" for="exampleInputEmail1">Email address</label>
								<input type="email" class="form-control maxlength-custom-message" id="exampleInputEmail1" placeholder="Enter email" maxlength="20">
								<small class="text-muted">Max length 20, custom message</small>
							</fieldset>
						</div>
						<div class="col-lg-4">
							<fieldset class="form-group">
								<label class="form-label" for="exampleInputPassword1">Password</label>
								<input type="password" class="form-control maxlength-always-show" id="exampleInputPassword1" placeholder="Password" maxlength="10">
								<small class="text-muted">Max length 10, always show</small>
							</fieldset>
						</div>
					</div>

					<div class="row">
						<div class="col-xs-12">
							<fieldset class="form-group">
								<label class="form-label" for="exampleInputEmail1">Text</label>
								<textarea rows="2" class="form-control maxlength-simple" placeholder="Textarea max length 20 chars" maxlength="20"></textarea>
							</fieldset>
						</div>
					</div>

					<h5 class="with-border m-t-lg">Hide/Show Password</h5>

					<div class="row">
						<div class="col-md-4 col-sm-6">
							<div class="form-group">
								<label class="form-label" for="hide-show-password">Password</label>
								<input id="hide-show-password" type="password" class="form-control" value="Example">
							</div>
						</div>
					</div>
                                        	<h5 class="with-border m-t-lg">Select2 Multiple</h5>

					<div class="row">
						<div class="col-md-6">
							<select class="select2" multiple="multiple">
								<option data-icon="font-icon-home">Quant Verbal</option>
								<option selected data-icon="font-icon-cart">Real Gmat Test</option>
								<option data-icon="font-icon-speed">Prep test</option>
								<option data-icon="font-icon-users">Catprep test</option>
								<option data-icon="font-icon-comments">Third Party Test</option>
							</select>
							<br/>
							<br/>
						</div>
					</div><!--.row-->
                                        
                                        <div class="row m-t-lg">
						<div class="col-md-6">
							<form id="form-signup_v1" name="form-signup_v1" method="POST">
								<div class="form-group">
									<label class="form-label" for="signup_v1-username">Username</label>
									<div class="form-control-wrapper">
										<input id="signup_v1-username"
											   class="form-control"
											   name="signup_v1[username]"
											   type="text" data-validation="[L>=6, L<=18, MIXED]"
											   data-validation-message="$ must be between 6 and 18 characters. No special characters allowed."
											   data-validation-regex="/^((?!admin).)*$/i"
											   data-validation-regex-message="The word &quot;Admin&quot; is not allowed in the $">
									</div>
								</div>
								<div class="form-group">
									<label class="form-label" for="signup_v1-password">Password</label>
									<div class="form-control-wrapper">
										<input id="signup_v1-password"
											   class="form-control"
											   name="signup_v1[password]"
											   type="password" data-validation="[L>=6]"
											   data-validation-message="$ must be at least 6 characters">
									</div>
								</div>
								<div class="form-group">
									<label class="form-label" for="signup_v1-password-confirm">Confirm Password</label>
									<div class="form-control-wrapper">
										<input id="signup_v1-password-confirm"
											   class="form-control"
											   name="signup_v1[password-confirm]"
											   type="password" data-validation="[V==signup_v1[password]]"
											   data-validation-message="$ does not match the password">
									</div>
								</div>
								<div class="form-group">
									<label class="form-label" for="signup_v1-email">Email</label>
									<div class="form-control-wrapper">
										<input id="signup_v1-email"
											   class="form-control"
											   name="signup_v1[email]"
											   type="text"
											   data-validation="[EMAIL]">
									</div>
								</div>
								<div class="form-group">
									<label class="form-label" for="signup_v1-email-confirm">Confirm Email</label>
									<div class="form-control-wrapper">
										<input id="signup_v1-email-confirm"
											   class="form-control"
											   name="signup_v1[email-confirm]"
											   type="text"
											   data-validation="[V==signup_v1[email]]"
											   data-validation-message="$ does not match the email">
									</div>
								</div>
								<div class="form-group">
									<button type="submit" class="btn">Sign up!</button>
								</div>
							</form>
						</div>
						<div class="col-md-6">
							<form id="form-signup_v2" name="form-signup_v2" method="POST">
								<div class="form-group">
									<label class="form-label" for="signup_v2-name">Name</label>
									<div class="form-control-wrapper">
										<input id="signup_v2-name"
											   class="form-control"
											   name="signup_v2[name]"
											   type="text"
											   data-validation="[OPTIONAL, NAME, L>=2, TRIM]">
									</div>
								</div>
								<div class="form-group form-group-radios">
									<label class="form-label" id="signup_v2-gender">
										Gender <span class="color-red">*</span>
									</label>
									<div class="radio">
										<input id="signup_v2-gender-male"
											   name="signup_v2[gender]"
											   data-validation="[NOTEMPTY]"
											   data-validation-group="signup_v2-gender"
											   data-validation-message="You must select a gender"
											   type="radio"
											   value="male">
										<label for="signup_v2-gender-male">Male</label>
									</div>
									<div class="radio">
										<input id="signup_v2-gender-female"
											   name="signup_v2[gender]"
											   data-validation-group="signup_v2-gender"
											   type="radio"
											   value="female">
										<label for="signup_v2-gender-female">Female</label>
									</div>
									<div class="radio">
										<input id="signup_v2-gender-other"
											   name="signup_v2[gender]"
											   data-validation-group="signup_v2-gender"
											   type="radio"
											   value="other">
										<label for="signup_v2-gender-other">Other</label>
									</div>
								</div>
								<div class="form-group form-group-checkbox">
									<div class="checkbox">
										<input id="signup_v2-agree"
											   name="signup_v2[agree]"
											   data-validation="[NOTEMPTY]"
											   data-validation-message="You must agree the terms and conditions"
											   type="checkbox">
										<label for="signup_v2-agree">I agree the <a href="#">terms</a> and <a href="#">conditions</a></label>
									</div>
								</div>
								<button type="submit" class="btn">Sign up!</button>
							</form>
						</div>
					</div><!--.row-->
				</div>
			</section>
		</div><!--.container-fluid-->
	</div><!--.page-content-->



	<script src="js/lib/datatables-net/datatables.min.js"></script>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.3.1/css/buttons.dataTables.min.css">
	<script type="text/javascript" language="javascript" src="//code.jquery.com/jquery-1.12.4.js">
	</script>
        <script src="js/lib/jquery/jquery.min.js"></script>
	<script src="js/lib/tether/tether.min.js"></script>
	<script src="js/lib/bootstrap/bootstrap.min.js"></script>
	<script src="js/plugins.js"></script>
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
	<script>
	$(document).ready(function() {
		
	var table = 	$('#example').DataTable( {
		"order": [[ 2, "desc" ]],
		"oLanguage": {
			"sInfo": "Showing _START_ to _END_ of _TOTAL_ items."
		},
		
        dom: 'Bfrtip',
        buttons: [ 
            {
                extend: 'copyHtml5',
                exportOptions: {
                    columns: [ 0, ':visible' ]
                }, title: 'Data_Visitors'
            },
			{
                extend: 'print',
                exportOptions: {
                    columns: [ 0, ':visible' ]
                }, title: 'Data_Visitors'
            },
			 {
                extend: 'csv',
                exportOptions: {
                    columns: [ 0, ':visible' ],
					 
                }, title: 'Data_Visitors'
            },
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: ':visible'
                }, title: 'Data_Visitors'
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2, 3,4,5,6]
                }, title: 'Data_Visitors'
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
		<script src="js/lib/select2/select2.full.min.js"></script>
<script src="js/app.js"></script>
</body>
</html>