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
            $ad_id_url=@$_REQUEST['ad_id'];
$connect = mysqli_connect("10.10.10.28", "powersport", "Dgt569khd", "powersport");
//$connect = mysqli_connect("localhost", "root", "", "powersport");



            ?>
		<div class="container">
                    <br/><br/><br/>
		
			<div class="form-group">
				<form name="add_name" action="cnt_t.php" method="POST" >
					<div class="table-responsive">
						<table class="table table-bordered" id="dynamic_field">
						
						
						                                <tr>
								


           
                                                             


 <?php     $sql1="SELECT * FROM `customadvertisement` where CustomAdvertiseID=$ad_id_url";

if ($result1=mysqli_query($connect,$sql1))
  {
 
  while ($row1=mysqli_fetch_row($result1))
    {
   $ad_id=  $row1[0];
      $ad_name=  $row1[1];
      $ad_sel=  $row1[21];
       $ad_url=  $row1[18];
 
   
    }

  mysqli_free_result($result1);
}
echo  "<h3>$ad_name </h3>";
echo  "Ad Running URL : <a href='https://d1y5fdo1lg4j4.cloudfront.net/$ad_url' target='_blank'>https://d1y5fdo1lg4j4.cloudfront.net/$ad_url</a></br></br>";
echo "Ad Running Status : </br></br>";
       ?>                                           



                                                              
								<td>  
									<input type='hidden' name="ad_id" value="<?php echo $ad_id; ?>">

							<?php 		$sqlc="SELECT Code,Name FROM `country` where CountryMapping=0";

if ($resultc=mysqli_query($connect,$sqlc))
  {
 
  while ($rowc=mysqli_fetch_row($resultc))
    {



$word = $rowc[0];
$mystring = $ad_sel;
  
if(strpos($mystring, $word) !== false){
   $chk="checked";
} else{
    $chk="";
}


     ?>

                  <label> <input name="cnt[]" value="<?php echo $rowc[0]; ?>" <?php echo $chk; ?> type="checkbox"> <?php echo $rowc[1]; ?></label>
<?php
}
}
 ?>
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





