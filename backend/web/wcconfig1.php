<html>
	<head>
		<title></title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
	</head>
	<body>
            
            <?php
$connect = mysqli_connect("10.10.10.28", "powersport", "Dgt569khd", "powersport");
//$connect = mysqli_connect("localhost", "root", "root", "powersportztv");
$sql="SELECT wcwidget,wcmatchid FROM homepage limit 1";

if ($result=mysqli_query($connect,$sql))
  {
 
  while ($row=mysqli_fetch_row($result))
    {
    $cur_val=$row[0];
     $cur_matchid=$row[1];
    }
  // Free result set
  mysqli_free_result($result);
}

//mysqli_close($connect);

if($cur_val=="true"){
    $checked="checked";
    $checked1='';
}else if($cur_val=="false"){
    $checked1="checked";
    $checked='';
}
            ?>
		<div class="container">
                    <br/><br/><br/>
		
			<div class="form-group">
				<form name="add_name" id="add_name">
					<div class="table-responsive">
						<table class="table table-bordered" id="dynamic_field">
                                                    
                                                    <tr>
								<td><label for="wcwidget">Widget Visibility:</label><br/>
                                                                <input type="radio" name="wcwidget" value="true"  <?php echo $checked; ?> > Show
  <input type="radio" name="wcwidget"  value="false"  <?php echo $checked1; ?> > Hide<br>
                                                                </td>
								<td></td>
							</tr>
                                                         <tr>
								<td><label for="wcwidget">Active Match:</label>
                                                                    
                                                               <select name="wcactivematch">
<option value="">....Choose Live Match Feed to Display....</option>
<option <?php if($cur_matchid=='43644'){echo 'selected';} ?> value="43644">2019-05-30	43644	England v South Africa</option>
<option <?php if($cur_matchid=='43645'){echo 'selected';} ?> value="43645">2019-05-31	43645	West Indies v Pakistan</option>
<option <?php if($cur_matchid=='43647'){echo 'selected';} ?> value="43647">2019-06-01	43647	Afghanistan v Australia</option>
<option <?php if($cur_matchid=='43646'){echo 'selected';} ?> value="43646">2019-06-01	43646	New Zealand v Sri Lanka</option>
<option <?php if($cur_matchid=='43648'){echo 'selected';} ?> value="43648">2019-06-02	43648	South Africa v Bangladesh</option>
<option <?php if($cur_matchid=='43649'){echo 'selected';} ?> value="43649">2019-06-03	43649	England v Pakistan</option> 
<option <?php if($cur_matchid=='43650'){echo 'selected';} ?> value="43650">2019-06-04	43650	Afghanistan v Sri Lanka</option>
<option <?php if($cur_matchid=='43652'){echo 'selected';} ?> value="43652">2019-06-05	43652	Bangladesh v New Zealand</option>
<option <?php if($cur_matchid=='436451'){echo 'selected';} ?> value="43651">2019-06-05	43651	South Africa v India</option>
<option <?php if($cur_matchid=='43645'){echo 'selected';} ?>value="43653">SAP</option>
<option value="43654">SAP</option> 
<option value="43655">SAP</option>
<option value="43656">SAP</option>
<option value="43657">SAP</option>
<option value="43658">SAP</option>
<option value="43659">SAP</option> 
<option value="43660">SAP</option>
<option value="43661">SAP</option>
<option value="43662">SAP</option>
<option value="43663">SAP</option>
<option value="43664">SAP</option> 
<option value="43665">SAP</option>
<option value="43666">SAP</option>
<option value="43667">SAP</option>
<option value="43668">SAP</option>
<option value="43669">SAP</option> 
<option value="43670">SAP</option>
<option value="43671">SAP</option>
<option value="43672">SAP</option>
<option value="43673">SAP</option> 
<option value="43674">SAP</option>
<option value="43675">SAP</option>
<option value="43676">SAP</option>
<option value="43677">SAP</option>
<option value="43678">SAP</option> 
<option value="43679">SAP</option>
<option value="43680">SAP</option>
<option value="43681">SAP</option>
<option value="43682">SAP</option>
<option value="43683">SAP</option> 
<option value="43684">SAP</option>
<option value="43685">SAP</option>
<option value="43686">SAP</option>
<option value="43687">SAP</option>
<option value="43688">SAP</option> 
<option value="43689">SAP</option>
<option value="43690">SAP</option>
<option value="43691">SAP</option>
</select>
                                                                </td>
								<td></td>
							</tr>
							<tr>
								<td><label for="wcauto">Autoplay/Thumbnail Shedule:</label><br/><input type="datetime-local" name="name[]" placeholder="Enter your Name" class="form-control name_list" /></td>
								<td><button type="button" name="add" id="add" class="btn btn-success" style="background-color: #c00 !important;color:#fff !important">Add More</button></td>
							</tr>
                                                        <tr>
                                                            <td colspan="2">
                                                           <?php     $sql1="SELECT name FROM tbl_name ";

if ($result1=mysqli_query($connect,$sql1))
  {
 
  while ($row1=mysqli_fetch_row($result1))
    {
   echo  $row1[0]."<br/>";
    }
  // Free result set
  mysqli_free_result($result1);
}

mysqli_close($connect);
       ?>                                                         
                                                            </td>
                                                        </tr>
						</table>
						<input type="button" name="submit" id="submit" class="btn btn-info" style="background-color: #c00 !important;color:#fff !important" value="Submit" />
					</div>
				</form>
			</div>
		</div>
	</body>
</html>

<script>
$(document).ready(function(){
	var i=1;
	$('#add').click(function(){
		i++;
		$('#dynamic_field').append('<tr id="row'+i+'"><td><input type="datetime-local" name="name[]"  class="form-control name_list" /></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');
	});
	
	$(document).on('click', '.btn_remove', function(){
		var button_id = $(this).attr("id"); 
		$('#row'+button_id+'').remove();
	});
	
	$('#submit').click(function(){		
		$.ajax({
			url:"name.php",
			method:"POST",
			data:$('#add_name').serialize(),
			success:function(data)
			{
				alert(data);
				$('#add_name')[0].reset();
			}
		});
	});
	
});
</script>




