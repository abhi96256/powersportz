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
							<h3>Users with Collab Recordings</h3>
							
						</div>
					</div>
				</div>
			</header>
			<section >
				<div >
				<table id="example" class="display nowrap" cellspacing="0" width="100%">
						<thead>
						<tr>
	
           		
            		
           <th>Sr. No	</th>
            <th>Date</th>
            <th>Customer Name</th>
             <th>Video/Audio</th>
            <th> Media File</th>
              <th>Song Name</th>
            <th>Picture</th>
            <th>Score</th>
            <th>Played</th>
            <th>Views</th>
           <th> MSISDN</th>
               
                 <th>Platform</th>
                
              
						</tr>
						</thead>
						<tfoot>
						<tr>
						
            		
                 		
          <th>Sr. No	</th>
            <th>Date</th>
            <th>Customer Name</th>
             <th>Video/Audio</th>
            <th> Media File</th>
              <th>Song Name</th>
            <th>Picture</th>
            <th>Score</th>
            <th>Played</th>
            <th>Views</th>
           <th> MSISDN</th>
             
                 <th>Platform</th>
         
						</tr>
						</tfoot>
						<tbody>
				<?php
				try
		{
			$stmt1 = $auth_user->runQuery("SELECT `tbu_id`, `tbu_track_id`, `tbu_savedfile`, `tbu_score`*100 as scre,  `tbu_userid`, `tbu_active`, `tbu_cntplay`, `tbu_cntview`, `tbu_createdon`, `tbu_totalTime`, `tbu_totalRecodingTime`, `tbu_singableRecodingTime`, `tbu_surScore`, `tbu_expressionScore`, `tbu_bonusScore`,  `tbu_platform`, `tbu_inptype`,
`tmt_name`,`reg_name`,`reg_pic`,`reg_msisdn`,`platform`
FROM `tbl_usertracksCollab` inner join tbl_master_tracks on `tmt_id`=tbu_track_id 
inner join tbl_registered_users on `reg_id`=tbu_userid
");
			
		
	$stmt1->execute();
        if($stmt1->rowCount() > 0)
				{  $i=1;
					while($row = $stmt1->fetch()){  //echo '1';
                                            
                                            $newDate = date("d-m-Y", strtotime($row['tbu_createdon']));
                                            
                                            $purescore=$row['scre'];
                                            
                                            if($row['scre']<25){
                                                
                                               
                                                 $otp_status="<span class='label label-danger' style='background-color:red;color:white'>$purescore</span>";
                                            }else if($row['scre']>=25 && $row['scre']<=75){
                                                
                                                $otp_status="<span class='label label-warning' style='background-color:orange;color:white'>$purescore</span>";
                                            }else if($row['scre']>75){
                                                $otp_status="<span class='label label-success' style='background-color:green;color:white'>$purescore</span>";
                                            }
                                            
                                             if($row['tbu_inptype']=='true'){
                                                
                                               
                                                 $inp="<span class='label label-danger' style='background-color:purple;color:white'>VIDEO</span>";
                                            }else if($row['tbu_inptype']=='false' ){
                                                
                                                $inp="<span class='label label-warning' style='background-color:blue;color:white'>AUDIO</span>";
                                            }
                                            
                                           
					?>
					
					<tr>
					
					  

         
            <td><?php echo $row['reg_id']; ?></td>
      
              <td><?php echo $newDate; ?></td>
               <td><?php echo $row['reg_name']; ?></td>
                 <td><?php echo $inp; ?></td>
             <td><video  height="100" controls>
  <source src="http://ec2-52-214-189-182.eu-west-1.compute.amazonaws.com/musicscorer/uploads/Collab/<?php echo $row['tbu_savedfile']; ?>" type="video/mp4">
  
Your browser does not support the video tag.
</video></td>
                        <td><?php echo $row['tmt_name']; ?></td>
               
                 <td><img  src="<?php echo "http://ec2-52-214-189-182.eu-west-1.compute.amazonaws.com/musicscorer/img/".$row['reg_pic']
                ?>"</td>
                  <td><?php echo $otp_status; ?></td>
                   
                    <td><?php echo $row['tbu_cntplay']; ?></td>
                     <td><?php echo $row['tbu_cntview']; ?></td>
                      <td><?php echo $row['reg_msisdn']; ?></td>
                      
                         
                      
                     
                           <td><?php echo $row['platform']; ?></td>
                             
                     
                     
                 

                    
                  
					
					
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