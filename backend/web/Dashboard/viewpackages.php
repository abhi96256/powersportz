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
	<title>Music Scorer Dashboard</title>

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
<link rel="stylesheet" href="css/separate/pages/prices.min.css">
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
			<section class="box-typical box-typical-full-height">
				<div class="box-typical-center">
					<div class="box-typical-center-in prices-page">
						<header class="prices-page-title">Music Scorer Current Packages for customers</header>
						<p class="prices-page-subtitle"></p>
						<article class="price-card">
							<header class="price-card-header">Basic</header>
							<div class="price-card-body">
								<div class="price-card-amount">49</div>
								<div class="price-card-amount-lbl">per week</div>
								<ul class="price-card-list">
									<li><i class="font-icon font-icon-ok"></i>Up to 5000 bins</li>
									<li><i class="font-icon font-icon-ok"></i>UNLIMITED users</li>
								</ul>
								<div class="clear"></div>
								<a href="#" class="btn btn-rounded">Start your trial</a>
							</div>
						</article>
						<article class="price-card">
							<header class="price-card-header">Medium</header>
							<div class="price-card-body">
								<div class="price-card-amount">99</div>
								<div class="price-card-amount-lbl">per month</div>
								<div class="price-card-label">Our most popular plan</div>
								<ul class="price-card-list">
									<li><i class="font-icon font-icon-ok"></i>Up to 5000 bins</li>
									<li><i class="font-icon font-icon-ok"></i>UNLIMITED users</li>
								</ul>
								<div class="clear"></div>
								<a href="#" class="btn btn-rounded">Start your trial</a>
							</div>
						</article>
						<article class="price-card">
							<header class="price-card-header">Annual</header>
							<div class="price-card-body">
								<div class="price-card-amount">599</div>
								<div class="price-card-amount-lbl">per year</div>
								<ul class="price-card-list">
									<li><i class="font-icon font-icon-ok"></i>Up to 5000 bins</li>
									<li><i class="font-icon font-icon-ok"></i>UNLIMITED users</li>
								</ul>
								<div class="clear"></div>
								<a href="#" class="btn btn-rounded">Start your trial</a>
							</div>
						</article>
					
						<div class="prices-page-bottom">
							<p> plans are available on request.</p>
							<p>Save 10% by signing up for a year in advance. <a href="#">Contact us</a> for more information.</p>
						</div>
					</div>
				</div>
			</section><!--.box-typical.prices-page-->
		</div><!--.container-fluid-->
	</div><!--.page-content-->


	<script src="js/lib/datatables-net/datatables.min.js"></script>
        
        <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/foundation/5.5.2/css/foundation.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/dataTables.foundation.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.1/css/responsive.foundation.min.css">
        

	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.3.1/css/buttons.dataTables.min.css">
	<script type="text/javascript" language="javascript" src="//code.jquery.com/jquery-1.12.4.js">
	</script>
        
        <script type="text/javascript" language="javascript" src="//cdnjs.cloudflare.com/ajax/libs/foundation/5.5.2/js/foundation.min.js">
	</script>
        
        
        	<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
        
       
	<script src="js/lib/tether/tether.min.js"></script>
	<script src="js/lib/bootstrap/bootstrap.min.js"></script>
	<script src="js/plugins.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js">
	</script>
        <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js">
	</script>
   
        
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js">
	</script>
        <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.16/js/dataTables.foundation.min.js">
	</script>
        
             <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js">
	</script>
        
             <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/responsive/2.2.1/js/responsive.foundation.min.js">
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
    $('#example').DataTable( {
         dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ],
        responsive: {
            details: {
                display: $.fn.dataTable.Responsive.display.modal( {
                    header: function ( row ) {
                        var data = row.data();
                        return 'Details for '+data[3]+' - '+data[2];
                    }
                } ),
                renderer: $.fn.dataTable.Responsive.renderer.tableAll()
            }
        }
    } );
} );
	
	</script>
       
	
<script src="js/app.js"></script>
</body>
</html>