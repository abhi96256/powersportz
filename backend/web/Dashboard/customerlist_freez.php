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
							<h3>Customers with Ares Global</h3>
							
						</div>
					</div>
				</div>
			</header>
			<section class="card">
				<div class="card-block">
					<table   id="example" class="display dataTable" id="example" class="display table table-striped table-bordered" cellspacing="0" width="100%">
						<thead>
						<tr>
	
           		
            <th>Sr. No	</th>
            <th>Reg. Date</th>
            <th>CustomerID</th>
            <th>Customer Name</th>
            
            <th>Designation</th>
            <th>Company</th>
              <th>Mobile</th>
               <th>Amount</th>
                <th>Amount Received</th>
                 <th>Amount Pending</th>
                <th>Product Type</th>
                  <th>Action</th>
          
              
						</tr>
						</thead>
						<tfoot>
						<tr>
						
            		
           <th>Sr. No	</th>
            <th>Reg. Date</th>
            <th>CustomerID</th>
            <th> Customer Name</th>
           
            <th>Designation</th>
            <th>Company</th>
              <th>Mobile</th>
               <th>Amount</th>
                <th>Amount Received</th>
                 <th>Amount Pending</th>
                 <th>Product Type</th>
                  <th>Action</th>
						</tr>
						</tfoot>
						<tbody>
				<?php
				try
		{
			$stmt1 = $auth_user->runQuery("SELECT `cID`, `regnDate`, `customerID`, `name`, `companyName`,"
                                . " `emailID`, `mobileNo`,  "
                                . "`state`, `city`, `picode`, `address`, `userName`, customerdetail.`typeID`, `department`, `division`, "
                                . "`desg`, `transactionType`, `dd_infavour`, `dd_chequeNo`, `amount`, `aReceived`, `payRecDate`, "
                                . "`paymentStatus`, `dd_chequeDate`, `bankName`, `dscStatus`, `hDsc`, `hPersonName`, `designation`,"
                                . " `hPersonMobileNo`, `dscRecvDate`, `e_token`, `e_tokenNo`, `e_tokenPassword`, `e_tokenType`, `rDox`,"
                                . " `doxRecd`, `doxRecVia`, `pDoxName`, `coverID`, `refferedBy`, `createdBy`, `category`, `savedBy`,"
                                . " `lastModifiedBy`,customertype.`typeID`, `typeName`, `duration`, `loginID`, `savedAt`, `lastModifiedAt`, `verifyCode`, `panCategory`, `panNo` "
                                . "FROM `customerdetail`  inner join `customertype` on customerdetail.`typeID`=customertype.typeID ");
			
		
	$stmt1->execute();
        if($stmt1->rowCount() > 0)
				{  $i=1;
					while($row = $stmt1->fetch()){  //echo '1';
                                            
                                            $newDate = date("d-m-Y", strtotime($row['regnDate']));
					?>
					
					<tr>
					
					  
           
         
            <td><?php echo $row['cID']; ?></td>
             <td><?php echo $newDate; ?></td>
              <td><?php echo $row['customerID']; ?></td>
               <td><?php echo $row['name']; ?></td>
             
                <td><?php echo $row['desg']; ?></td>
                 <td><?php echo $row['companyName']; ?></td>
                  <td><?php echo $row['mobileNo']; ?></td>
                   <td><?php echo $row['amount']; ?></td>
                    <td><?php echo $row['aReceived']; ?></td>
                     <td><?php echo $row['amount']-$row['aReceived']; ?></td>
                       <td><?php echo $row['typeName']; ?>
                     
                      <td><a href="editcustomers.php?id=<?php echo $row['cID']; ?>">Edit</a</td>

                    
                  
					
					
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
             "scrollX": true,
               lengthMenu: [
            [ 25, 50,100, -1 ],
            [ '25 rows', '50 rows','100 rows', 'Show all' ]
        ],
        
		"order": [[ 4, "desc" ]],
		"oLanguage": {
			"sInfo": "Showing _START_ to _END_ of _TOTAL_ items."
		},
		
        dom: 'Bfrtip',
        buttons: [ 
            'pageLength',
            {
                extend: 'copyHtml5',
                exportOptions: {
                    columns: [ 0, ':visible' ]
                }, title: 'Data_Customers'
            },
			{
                extend: 'print',
                exportOptions: {
                    columns: [ 0, ':visible' ]
                }, title: 'Data_Customers'
            },
			 {
                extend: 'csv',
                exportOptions: {
                    columns: [ 0, ':visible' ],
					 
                }, title: 'Data_Customers'
            },
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: ':visible'
                }, title: 'Data_Customers'
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2, 3,4,5,6,7,8,9]
                }, title: 'Data_Customers'
            },
            'colvis'
        ]
    } );
		
 

    $("#example tfoot th").each( function ( i ) {
        
  
   

		
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
    } );
  
}  );
	
	
	</script>
	
<script src="js/app.js"></script>
</body>
</html>