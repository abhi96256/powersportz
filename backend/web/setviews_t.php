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
	<body>
            
            <?php
$connect = mysqli_connect("10.10.10.28", "powersport", "Dgt569khd", "powersport");
//$connect = mysqli_connect("localhost", "root", "root", "powersportztv");
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
		<div class="container">
                    <br/><br/><br/>
		
			<div class="form-group">
				<form name="add_name" action="upviews_t.php" method="POST" >
					<div class="table-responsive">
						<table class="table table-bordered" id="dynamic_field">
						
						
						                                <tr>
								<td><label for="wcwidget">VOD:</label> </br>











                                                                    
                                                               <select style='font-size:13px' name="vodid">
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
		<option  value="<?php echo $asid;  ?>"><?php echo $astt;  ?> - <?php echo $ascn;  ?></option>
		
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
                                                        
                                                        
                                                        
                                                        
						</table>
						<input type="submit" name="submit" id="submit" class="btn btn-info" style="background-color: #c00 !important;color:#fff !important" value="Submit" />
					</div>
				</form>
			</div>
		</div>
	</body>
</html>





