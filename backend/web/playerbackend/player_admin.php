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

//$connect = mysqli_connect("52.193.254.0", "powersport", "Google@123", "powersport");

$connect = mysqli_connect("10.10.10.28", "powersport", "Dgt569khd", "powersport");
//$connect = mysqli_connect("localhost", "root", "root", "powersportztv");
$sql="SELECT `wcwidget1`, `wcwidget2`, `wcwidget3`, `wc_web`, `wc_ios`, `wc_fire`, `wc_android`, `p1_ttl`, `p2_ttl`, `p3_ttl`, `p1_url`, `p2_url`, `p3_url`, `p1_thumb`, `p2_thumb`, `p3_thumb`, `p1_gif`, `p2_gif`, `p3_gif`, `p1_auto`, `p2_auto`, `p3_auto`, `p1_adv`, `p2_adv`, `p3_adv` FROM homepage limit 1";

if ($result=mysqli_query($connect,$sql))
  {
 
  while ($row=mysqli_fetch_row($result))
    {
     $wcwidget1=$row[0]; //die;
	  $wcwidget2=$row[1];
	   $wcwidget3=$row[2];
	    $wc_web=$row[3];
		 $wc_ios=$row[4];
		  $wc_fire=$row[5];
		   $wc_android=$row[6];
		    $p1_ttl=$row[7];
			 $p2_ttl=$row[8];
			  $p3_ttl=$row[9];
			   $p1_url=$row[10];
			    $p2_url=$row[11];
				 $p3_url=$row[12];
				  $p1_thumb=$row[13];
				   $p2_thumb=$row[14];
				    $p3_thumb=$row[15];
					 $p1_gif=$row[16];
					  $p2_gif=$row[17];
					   $p3_gif=$row[18];
					    $p1_auto=$row[19];
						 $p2_auto=$row[20];
						  $p3_auto=$row[21];
						   $p1_adv=$row[22];
						    $p2_adv=$row[23];
							 $p3_adv=$row[24];
   
    }
  // Free result set
  mysqli_free_result($result);
}

//mysqli_close($connect);

if($wcwidget1=="true"){
    $checked1="checked";
	
    
}else{
	$checked11='checked';
}

 if($wcwidget2=="true"){
    $checked2="checked";
    
}else{
	$checked22='checked';
}
 if($wcwidget3=="true"){
    $checked3="checked";
    
}else{
	$checked33='checked';
}



if($p1_adv=="true"){
    $checked1ad="checked";
	
    
}else{
	$checked11ad='checked';
}

 if($p2_adv=="true"){
    $checked2ad="checked";
    
}else{
	$checked22ad='checked';
}
 if($p3_adv=="true"){
    $checked3ad="checked";
    
}else{
	$checked33ad='checked';
}

 if($wc_web=="Web"){
    $checkedw="checked";
	$checkedwv="true";
}else{
$checkedwv="false";	
}

 if($wc_ios=="iOS"){
    $checkedi="checked";
	$checkediv="true";
}else{
$checkediv="false";	
}
 if($wc_fire=="FireTv"){
    $checkedf="checked";
	$checkedfv="true";
}else{
$checkedfv="false";	
}
 if($wc_android=="Android"){
    $checkeda="checked";
	$checkedav="true";
}else{
$checkedav="false";	
}


            ?>
		<div class="container"  style='width:100% !important;padding-top:30px;'>
                   
		
			<div class="form-group">
				<form name="add_name" action="player_ins.php" method="POST" enctype="multipart/form-data" >
					<div class="table-responsive">
						<table class="table table-bordered" id="dynamic_field"  style='font-size:14px !important;font-weight:bold'>
						
						 <tr>
								<td colspan=3 style="text-align:center !important;font-weight:bold;font-size:20px"><label for="wcwidget">Active Platforms:</label>
                                                                <input type="checkbox" name="wcwidget_web" value="Web" <?php echo $checkedw; ?>   > Web
  <input type="checkbox" name="wcwidget_ios"  value="iOS"  <?php echo $checkedi; ?> > iOS
   <input type="checkbox" name="wcwidget_android"  value="Android" <?php echo $checkeda; ?>  > Android
    <input type="checkbox" name="wcwidget_fire"  value="FireTv" <?php echo $checkedf; ?> > FireTv
                                                                </td>
								
							</tr>
							
							
							           
                                                    <tr style="background-color:#000;color:#fff">
								<td ><label for="wcwidget"> Player 1 Settings</label>
                                                               
                                                                </td>
																
															<td ><label for="wcwidget"> Player 2 Settings</label>
                                                               
                                                                </td>
																<td ><label for="wcwidget"> Player 3 Settings</label>
                                                               
                                                                </td>
							</tr>
                                                    
                                                    <tr>
								<td ><label for="wcwidget"> Visibility:</label>
                                                                <input type="radio" name="wcwidget1" value="true"  <?php echo $checked1; ?> > Show
  <input type="radio" name="wcwidget1"  value="false"  <?php echo $checked11; ?> > Hide<br>
                                                                </td>
																
																<td><label for="wcwidget">Visibility:</label>
                                                                <input type="radio" name="wcwidget2" value="true"  <?php echo $checked2; ?> > Show
  <input type="radio" name="wcwidget2"  value="false"  <?php echo $checked22; ?> > Hide<br>
                                                                </td>
																<td><label for="wcwidget"> Visibility:</label>
                                                                <input type="radio" name="wcwidget3" value="true"  <?php echo $checked3; ?> > Show
  <input type="radio" name="wcwidget3"  value="false"  <?php echo $checked33; ?> > Hide<br>
                                                                </td>
								
							</tr>
							
							
                                                        <tr>
                                                            <td>
                                                                <label for="p1t">Title:</label>
                                                                <input type="text" name="p1t"  class="form-control" value="<?php echo $p1_ttl; ?>">
                                                                 
                                                               
                                                              </td>
                                                           <td>
                                                                <label for="p2t">Title:</label>
                                                                <input type="text" name="p2t"  class="form-control" value="<?php echo $p2_ttl; ?>">
                                                                 
                                                               
                                                              </td>
															   <td>
                                                                <label for="p3t">Title:</label>
                                                                <input type="text" name="p3t"  class="form-control" value="<?php echo $p3_ttl; ?>">
                                                                 
                                                               
                                                              </td>
                                                        </tr>


                                                        <tr>
                                                            <td>
                                                                <label for="p1u">Streaming URL (.m3u8):</label>
                                                                    <input style='font-size:10px !important;font-weight:bold'  type="text" name="p1u"  class="form-control" value="<?php echo $p1_url; ?>">
                                                                 
                                                              
                                                              </td>
															  <td>
                                                                <label for="p2u">Streaming URL (.m3u8):</label>
                                                                    <input  style='font-size:10px !important;font-weight:bold'  type="text" name="p2u"  class="form-control" value="<?php echo $p2_url; ?>">
                                                                 OR
                                                               <label for="p2gif">Web Image(320w x 250h):</label>
                                                                    <input type="file" name="p2gif"  class="form-control" >
                                                                 <img width='50px' src="../upload/player_images/<?php echo $p2_gif ?>"  />
                                                              
                                                              </td>
															  <td>
                                                                <label for="p3u">Streaming URL (.m3u8):</label>
                                                                    <input  style='font-size:10px !important;font-weight:bold' type="text" name="p3u"  class="form-control" value="<?php echo $p3_url; ?>">
                                                                 
                                                              OR  <label for="p3gif">Web Image(320w x 250h):</label>
                                                                    <input type="file" name="p3gif"  class="form-control" >
                                                                 <img width='50px' src="../upload/player_images/<?php echo $p3_gif ?>"  />
                                                              
                                                              </td>
                                                          
                                                        </tr>
														
														
														    <tr>
                                                            <td>
                                                                <label for="p1u">Thumbnail:</label>
                                                                    <input type="file" name="p1thu"  class="form-control" >
																	<img width='50px' src="../upload/player_images/<?php echo $p1_thumb ?>"  />
                                                                 
                                                              
                                                              </td>
															  <td>
                                                                <label for="p2u">Thumbnail:</label>
                                                                    <input type="file" name="p2thu"  class="form-control" >
                                                                 <img width='50px' src="../upload/player_images/<?php echo $p2_thumb ?>"  />
                                                              
                                                              </td>
															  <td>
                                                                <label for="p3u">Thumbnail:</label>
                                                                    <input type="file" name="p3thu"  class="form-control" \>
                                                                 <img width='50px' src="../upload/player_images/<?php echo $p3_thumb ?>"  />
                                                              
                                                              </td>
                                                          
                                                        </tr>
														
														
														
														 <tr>
								<td ><label for="wcad1"> Advertisement:</label>
                                                                <input type="radio" name="wcad1" value="true"  <?php echo $checked1ad; ?> > Show
  <input type="radio" name="wcad1"  value="false"  <?php echo $checked11ad; ?> > Hide<br>
                                                                </td>
																
																<td><label for="wcad2">Advertisement:</label>
                                                                <input type="radio" name="wcad2" value="true"  <?php echo $checked2ad; ?> > Show
  <input type="radio" name="wcad2"  value="false"  <?php echo $checked22ad; ?> > Hide<br>
                                                                </td>
																<td><label for="wcad3"> Advertisement:</label>
                                                                <input type="radio" name="wcad3" value="true"  <?php echo $checked3ad; ?> > Show
  <input type="radio" name="wcad3"  value="false"  <?php echo $checked33ad; ?> > Hide<br>
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





