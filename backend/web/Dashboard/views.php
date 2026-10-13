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
	

	
</head>
<body class="with-side-menu control-panel control-panel-compact">
<header class="site-header">
	    <div class="container-fluid">
	
	        <a href="index.php" class="site-logo">
	            <img class="hidden-md-down" src="img/ps_large.jpg" alt=""> 
	            <img class="hidden-lg-up" src="img/ps_logo.png" alt="">
				
	        </a>
	
	        <button id="show-hide-sidebar-toggle" class="show-hide-sidebar">
	            <span>toggle menu</span>
	        </button>
	
	        <button class="hamburger hamburger--htla">
	            <span>toggle menu</span>
	        </button>
	        <div class="site-header-content">
	            <div class="site-header-content-in">
	                <div class="site-header-shown">
	         
	
	      
	
	              
	
	                    <div class="dropdown user-menu">
						  <a  class="btn btn-inline btn-danger-outline" href="Login/logout.php?logout=true">
	                         Logout !  
                                 
                                 
	                        </a>
	                      
	                    </div>
	
	                    <button type="button" class="burger-right">
	                        <i class="font-icon-menu-addl"></i>
	                    </button>
	                </div><!--.site-header-shown-->
	
	                <div class="mobile-menu-right-overlay"></div>
	                <div class="site-header-collapsed">
	                    <div class="site-header-collapsed-in">
	
	                        <a class="btn btn-nav btn-nav btn-inline " href="#">
	                         Welcome !  <?php print($userRow['user_name']); ?>
                                 
                                 
	                        </a>
							 
                                
                              
	                        <div class="site-header-search-container">
	                
	                        </div>
	                    </div><!--.site-header-collapsed-in-->
	                </div><!--.site-header-collapsed-->
	            </div><!--site-header-content-in-->
	        </div><!--.site-header-content-->
	    </div><!--.container-fluid-->
	</header><!--.site-header-->
<div class="mobile-menu-left-overlay"></div>
  <?php
$connect = mysqli_connect("10.10.10.28", "powersport", "Dgt569khd", "powersport");
//$connect = mysqli_connect("localhost", "root", "", "powersport");
$sql="SELECT viewfactor,vfsd,vfed FROM homepage limit 1";

if ($result=mysqli_query($connect,$sql))
  {
 
  while ($row=mysqli_fetch_row($result))
    {
    $cur_val=$row[0];
	 $vfsd=$row[1];
	  $vfed=$row[2];
    
    }
  // Free result set
  mysqli_free_result($result);
}

//mysqli_close($connect);


            ?>
			<div >
			   <br/><br/><br/>
		  <br/><br/><br/>
		<div class="container" style='width:100% !important'>
		<header class="page-content-header">
			<div class="container-fluid">
				<div class="tbl">
					<div class="tbl-row">
						<div class="tbl-cell">
							<h3>VOD View Count  <small class="text-muted">& Overall Multiplier</small></h3>
						</div>
						<div class="tbl-cell tbl-cell-action">
							<a href="#" class="btn btn-rounded"></a>
						</div>
					</div>
				</div>
			</div>
		</header>
                 
			<div class="form-group">
				<form name="add_name" action="upviews_t.php" method="POST" >
					<div class="table-responsive">
						<table class="table table-bordered" id="dynamic_field">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />
				
	<script>
 $(document).ready(function () {
      $('select').selectize({
          sortField: 'text'
      });
  });
</script>	
						                                <tr>
								<td><label for="wcwidget">VOD:</label> </br>











                                                                    
                                                               <select style='font-size:13px' name="vodid" id="select-state" placeholder="Search or Choose VOD for Fix view count">
<option value="">....Choose VOD for Fix view count....</option>

 <?php     $sql1="SELECT  ID,Title,ViewCount FROM `video` where date(Created) > '2020-05-20' AND Status='1' order by ID DESC  ";

if ($result1=mysqli_query($connect,$sql1))
  {
 
  while ($row1=mysqli_fetch_row($result1))
    {
   $asid=  $row1[0];
      $astt=  $row1[1];
        $ascn=  $row1[2];
		
		?>
		<option  value="<?php echo $asid;  ?>"><?php echo substr($astt,0,100);  ?> - <?php echo $ascn;  ?></option>
		
		<?php
   
    }
  // Free result set
  mysqli_free_result($result1);
}

mysqli_close($connect);
       ?>                                           



</select>
                                                                </td>
								<td>   <label for="wcauto">Fix View Value:</label></br>
								<input type="text" name="fixcount"  class="form-control" value=""></td>
							</tr>
                                                             
                                                        
                                                        <tr>
                                                            <td>
                                                                <label for="wcauto">Start Date:</label>
                                                                <div class="input-group clockpicker" data-placement="right" data-align="top" data-autoclose="true">
                                                                    <input type="date" name="startdate"  class="form-control" value="<?php echo $vfsd; ?>">
                                                                    
                                                                </div>
                                                                </td>
                                                            <td>
                                                                <label for="wcauto">End Date:</label>
                                                                <div class="input-group clockpicker" data-placement="left" data-align="top" data-autoclose="true">
                                                                    <input type="date" name="enddate"  class="form-control" value="<?php echo $vfed; ?>">
                                                                  
                                                                </div>
                                                                </td>
                                                        </tr>
						
                                 <tr>
								<td><label for="wcwidget">Multiply VOD per Views by(1 hit view equal to input value):</label> </td><td>
                                                                <input  class="form-control" type="text" name="mulview" value="<?php echo $cur_val; ?>"   > 
                                                                </td>
							
							</tr>
							   <tr>
								<td><input type="submit" name="submit" id="submit" class="btn btn-info" style="background-color: #c00 !important;color:#fff !important" value="Submit" /></td><td>
                                                               
                                                                </td>
							
							</tr>
                                                        
                                                        
                                                        
                                                        
						</table>
						
					</div>
				</form>
			</div>
		</div>
</div>
</body>
</html>