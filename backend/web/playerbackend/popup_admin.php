<html>
	<head>
		<title></title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
                <link rel="stylesheet" type="text/css" href="https://weareoutman.github.io/clockpicker/assets/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="https://weareoutman.github.io/clockpicker/dist/bootstrap-clockpicker.min.css">
<link rel="stylesheet" type="text/css" href="https://weareoutman.github.io/clockpicker/assets/css/github.min.css">
                
	<script type="text/javascript" src="https://weareoutman.github.io/clockpicker/assets/js/jquery.min.js"></script>
<script type="text/javascript" src="https://weareoutman.github.io/clockpicker/assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://weareoutman.github.io/clockpicker/dist/bootstrap-clockpicker.min.js"></script>
     
	</head>
	<body style='width:100% !important'>
            
            <?php
error_reporting(E_ALL ^ E_NOTICE);
//$connect = mysqli_connect("52.193.254.0", "powersport", "Google@123", "powersport");

$connect = mysqli_connect("10.10.10.28", "powersport", "Dgt569khd", "powersport");
//$connect = mysqli_connect("localhost", "root", "", "ps");
$sql="SELECT `l_text`, `l_link`, `l_thumb`, `l_active` FROM `homepage` WHERE `HomeID`=1 limit 1";

if ($result=mysqli_query($connect,$sql))
  {
 
  while ($row=mysqli_fetch_row($result))
    {
     $l_text=$row[0]; //die;
	  $l_link=$row[1];
	   $l_thumb=$row[2];
	    $wcwidget1=$row[3];
		

   
    }
  // Free result set
  mysqli_free_result($result);
}

//mysqli_close($connect);

if($wcwidget1=="0"){
    $checked1="checked";
	
    
}else{
	$checked11='checked';
}

 




            ?>
		<div class="container"  style='width:100% !important;padding-top:30px;'>
                   
		
			<div class="form-group">
				<form name="add_name" action="popup_ins.php" method="POST" enctype="multipart/form-data" >
					<div class="table-responsive">
						<table class="table table-bordered" id="dynamic_field"  style='font-size:14px !important;font-weight:bold'>
						
					
							
							           
                                                    <tr style="background-color:#000;color:#fff">
								<td ><label for="wcwidget"> Pop Up Setting</label>
                                                               
                                                                </td>
																
														
							</tr>
                                                    
                                                    <tr>
								<td ><label for="wcwidget"> Visibility:</label>
                                                                <input type="radio" name="wcwidget1" value="0"  <?php echo $checked1; ?> > Show
  <input type="radio" name="wcwidget1"  value="1"  <?php echo $checked11; ?> > Hide<br>
                                                                </td>
																
															
								
							</tr>
							
							
                                                        <tr>
                                                            <td>
                                                                <label for="p1t">Title:</label>
                                                                <input type="text" name="p1t"  class="form-control" value="<?php echo $l_text; ?>">
                                                                 
                                                               
                                                              </td>
                                                        
                                                        </tr>


                                                        <tr>
                                                            <td>
                                                                <label for="p1u">External URL (.http):</label>
                                                                    <input style='font-size:10px !important;font-weight:bold'  type="url" name="p1u"  class="form-control" value="<?php echo $l_link; ?>">
                                                                 
                                                              
                                                              </td>
															
                                                          
                                                        </tr>
														
														
														    <tr>
                                                            <td>
                                                                <label for="p1u">Thumbnail:</label>
                                                                    <input type="file" name="p1thu"  class="form-control" >
																	<img width='300px' src="../upload/player_images/<?php echo $l_thumb ?>"  />
                                                                 
                                                              
                                                              </td>
														
                                                          
                                                        </tr>
														
														
														
				                
							
                                                        
                                                        
                                                        
						</table>
						<input type="submit" name="submit" id="submit" class="btn btn-info" style="background-color: #c00 !important;color:#fff !important" value="Submit" />
					</div>
				</form>
			</div>
		</div>
	</body>
</html>





