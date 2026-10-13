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
</head>
<body class="with-side-menu control-panel control-panel-compact">

<?php include("inc/head.php"); ?>
	
	<div class="mobile-menu-left-overlay"></div>
<?php include("inc/left.php"); ?>

	
	<div class="page-content">
		<div class="container-fluid">
		<header class="box-typical-header">
					<div class="tbl-row">
						<div class="tbl-cell tbl-cell-title">
							<h3>Category</h3>
						</div>
					</div>
				</header>

			<table id="table-edit" class="table table-bordered table-hover">
				<thead>
				<tr>
					<th width="1">
						#
					</th>
					<th>Name</th>
				
					
					
					<th >Date Created</th>
					<th width='20%'>Created By</th>
					<th >Date Modified</th>
				
					<th>Action</th>
				</tr>
				</thead>
				<tbody>
				
				<?php
				try
		{
		
			$stmt1 = $auth_user->runQuery("select  `sub_id`, `sub_name`, `sub_active`, mst_subject.`doc` as cod, `cby`, `lmon`, `lmby`,`user_id`, `user_name`, `user_email`, `user_pass`, `joining_date`, `uicon`, admin_users.`doc` from mst_subject  inner join  admin_users ON user_id=cby where sub_active='0'");
			
		
			
	$stmt1->execute();
	
	//$userRow1=$stmt1->fetch(PDO::FETCH_ASSOC);
	

		if($stmt1->rowCount() > 0)
				{  $i=1;
					while($row = $stmt1->fetch()){  //echo '1';
					//var_dump($row);
		
					?>
					
					<tr>
						<td id="<?php echo $row['sub_id']; ?>"><?php echo $row['sub_id']; ?></td>
						
						<td id="<?php echo $row['sub_name']; ?>"; class="color-blue-grey-lighter"><?php echo $row['sub_name']; ?></td>
						
						<td class="color-blue-grey-lighter"><?php echo(date("F d, Y h:i:s", strtotime($row['cod']))); ?></td>
						
						<td class="table-photo"><?php echo $row['lmby']; ?>
							<img src="img/<?php echo $row['uicon']; ?>" alt="" data-toggle="tooltip" data-placement="bottom" title=""><?php echo $row['user_name']; ?>
						</td>
						<td class="color-blue-grey-lighter"><?php if($row['lmon']!='0000-00-00 00:00:00'){ 
						echo(date("F d, Y h:i:s", strtotime($row['lmon']))); }else{ echo 'Not Modified Yet';} ?></td>
						
					
						
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

	</div><!--.container-fluid-->
	</div><!--.page-content-->

<script src="js/lib/jquery/jquery.min.js"></script>
	<script src="js/lib/tether/tether.min.js"></script>
	<script src="js/lib/bootstrap/bootstrap.min.js"></script>
	<script src="js/plugins.js"></script>

	<script src="js/lib/peity/jquery.peity.min.js"></script>
	<script src="js/lib/table-edit/jquery.tabledit.min.js"></script>
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

			$('#table-edit').Tabledit({
				url: 'updatecat.php',
				columns: {
					identifier: [0, 'id'],
					editable: [[1, 'name']]
				}
			});
		});
	</script>

<script src="js/app.js"></script>
</body>
</html>