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
				<form name="add_name" action="name.php" method="POST" >
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
<option <?php if($cur_matchid=='43651'){echo 'selected';} ?> value="43651">2019-06-05	43651	South Africa v India</option>
<option <?php if($cur_matchid=='43653'){echo 'selected';} ?> value="43653">2019-06-06  43653   Australia v West Indies</option>
<option <?php if($cur_matchid=='43654'){echo 'selected';} ?> value="43654">2019-06-07  43654   Pakistan v Sri Lanka</option> 
<option <?php if($cur_matchid=='43656'){echo 'selected';} ?> value="43656">2019-06-08  43656   Afghanistan v New Zealand</option>
<option <?php if($cur_matchid=='43655'){echo 'selected';} ?> value="43655">2019-06-08  43655   England v Bangladesh</option>
<option <?php if($cur_matchid=='43657'){echo 'selected';} ?> value="43657">2019-06-09  43657   India v Australia</option>
<option <?php if($cur_matchid=='43658'){echo 'selected';} ?> value="43658">2019-06-10  43658   South Africa v West Indies</option>
<option <?php if($cur_matchid=='43659'){echo 'selected';} ?> value="43659">2019-06-11  43659   Bangladesh v Sri Lanka</option> 
<option <?php if($cur_matchid=='43660'){echo 'selected';} ?> value="43660">2019-06-12  43660   Australia v Pakistan</option>
<option <?php if($cur_matchid=='43661'){echo 'selected';} ?> value="43661">2019-06-13  43661   India v New Zealand</option>
<option <?php if($cur_matchid=='43662'){echo 'selected';} ?> value="43662">2019-06-14	43662	England v West Indies</option>
<option <?php if($cur_matchid=='43663'){echo 'selected';} ?> value="43663">2019-06-15	43663	South Africa v Afghanistan</option> 
<option <?php if($cur_matchid=='43664'){echo 'selected';} ?> value="43664">2019-06-15	43664	Sri Lanka v Australia</option>
<option <?php if($cur_matchid=='43665'){echo 'selected';} ?> value="43665">2019-06-16	43665	India v Pakistan</option>
<option <?php if($cur_matchid=='43666'){echo 'selected';} ?> value="43666">2019-06-17	43666	West Indies v Bangladesh</option>
<option <?php if($cur_matchid=='43667'){echo 'selected';} ?> value="43667">2019-06-18	43667	England v Afghanistan</option>
<option <?php if($cur_matchid=='43668'){echo 'selected';} ?> value="43668">2019-06-19	43668	New Zealand v South Africa</option> 
<option <?php if($cur_matchid=='43669'){echo 'selected';} ?> value="43669">2019-06-20	43669	Australia v Bangladesh</option>
<option <?php if($cur_matchid=='43670'){echo 'selected';} ?> value="43670">2019-06-21	43670	England v Sri Lanka</option>
<option <?php if($cur_matchid=='43672'){echo 'selected';} ?> value="43672">2019-06-22	43672	West Indies v New Zealand</option>
<option <?php if($cur_matchid=='43671'){echo 'selected';} ?> value="43671">2019-06-22	43671	India v Afghanistan</option> 
<option <?php if($cur_matchid=='43673'){echo 'selected';} ?> value="43673">2019-06-23	43673	Pakistan v South Africa</option>
<option <?php if($cur_matchid=='43674'){echo 'selected';} ?> value="43674">2019-06-24	43674	Bangladesh v Afghanistan</option>
<option <?php if($cur_matchid=='43675'){echo 'selected';} ?> value="43675">2019-06-25	43675	England v Australia</option>
<option <?php if($cur_matchid=='43676'){echo 'selected';} ?> value="43676">2019-06-26	43676	New Zealand v Pakistan</option>
<option <?php if($cur_matchid=='43677'){echo 'selected';} ?> value="43677">2019-06-27	43677	West Indies v India</option> 
<option <?php if($cur_matchid=='43678'){echo 'selected';} ?> value="43678">2019-06-28	43678	Sri Lanka v South Africa</option>
<option <?php if($cur_matchid=='43680'){echo 'selected';} ?> value="43680">2019-06-29	43680	New Zealand v Australia</option>
<option <?php if($cur_matchid=='43679'){echo 'selected';} ?> value="43679">2019-06-29	43679	Pakistan v Afghanistan</option>
<option <?php if($cur_matchid=='43681'){echo 'selected';} ?> value="43681">2019-06-30	43681	England v India</option>
<option <?php if($cur_matchid=='43682'){echo 'selected';} ?> value="43682">2019-07-01	43682	Sri Lanka v West Indies</option> 
<option <?php if($cur_matchid=='43683'){echo 'selected';} ?> value="43683">2019-07-02	43683	Bangladesh v India</option>
<option <?php if($cur_matchid=='43684'){echo 'selected';} ?> value="43684">2019-07-03	43684	England v New Zealand</option>
<option <?php if($cur_matchid=='43685'){echo 'selected';} ?> value="43685">2019-07-04	43685	Afghanistan v West Indies</option>
<option <?php if($cur_matchid=='43686'){echo 'selected';} ?> value="43686">2019-07-05	43686	Pakistan v Bangladesh</option>
<option <?php if($cur_matchid=='43688'){echo 'selected';} ?> value="43688">2019-07-06	43688	Australia v South Africa</option> 
<option <?php if($cur_matchid=='43687'){echo 'selected';} ?> value="43687">2019-07-06	43687	Sri Lanka v India</option>
<option <?php if($cur_matchid=='43689'){echo 'selected';} ?> value="43689">2019-07-09	43689	India v New Zealand</option>
<option <?php if($cur_matchid=='43690'){echo 'selected';} ?> value="43690">2019-07-11	43690	Australia v England</option>
<option <?php if($cur_matchid=='43691'){echo 'selected';} ?> value="43691">2019-07-14	43691	SF1 v SF 2</option>
</select>
                                                                </td>
								<td></td>
							</tr>
                                                        <?php     $sql1="SELECT  `as1`, `ast1`, `as2`, `ast2`, `as3`, `ast3`, `as4`, `ast4`, `as5`, `ast5` FROM `homepage` where HomeID=1 limit 1 ";

if ($result1=mysqli_query($connect,$sql1))
  {
 
  while ($row1=mysqli_fetch_row($result1))
    {
   $as1=  $row1[0];
      $ast1=  $row1[1];
        $as2=  $row1[2];
      $ast2=  $row1[3];
        $as3=  $row1[4];
      $ast3=  $row1[5];
        $as4=  $row1[6];
      $ast4=  $row1[7];
        $as5=  $row1[8];
      $ast5=  $row1[9];
    }
  // Free result set
  mysqli_free_result($result1);
}

mysqli_close($connect);
       ?>                                              
                                                        
                                                        <tr>
                                                            <td>
                                                                <label for="wcauto">Autoplay Start Time 1:</label>
                                                                <div class="input-group clockpicker" data-placement="right" data-align="top" data-autoclose="true">
                                                                    <input type="text" name="as1"  class="form-control" value="<?php echo $as1; ?>">
                                                                    <span class="input-group-addon">
                                                                        <span class="glyphicon glyphicon-time"></span>
                                                                    </span>
                                                                </div>
                                                                <script type="text/javascript">
                                                                $('.clockpicker').clockpicker();
                                                                </script></td>
                                                            <td>
                                                                <label for="wcauto">Autoplay Stop Time 1:</label>
                                                                <div class="input-group clockpicker" data-placement="left" data-align="top" data-autoclose="true">
                                                                    <input type="text" name="ast1"  class="form-control" value="<?php echo $ast1; ?>">
                                                                    <span class="input-group-addon">
                                                                        <span class="glyphicon glyphicon-time"></span>
                                                                    </span>
                                                                </div>
                                                                <script type="text/javascript">
                                                                $('.clockpicker').clockpicker();
                                                                </script></td>
                                                        </tr>
                                                        
                                                           <tr>
                                                            <td>
                                                                <label for="wcauto">Autoplay Start Time 2:</label>
                                                                <div class="input-group clockpicker" data-placement="right" data-align="top" data-autoclose="true">
                                                                    <input type="text" name="as2"  class="form-control" value="<?php echo $as2; ?>">
                                                                    <span class="input-group-addon">
                                                                        <span class="glyphicon glyphicon-time"></span>
                                                                    </span>
                                                                </div>
                                                                <script type="text/javascript">
                                                                $('.clockpicker').clockpicker();
                                                                </script></td>
                                                            <td>
                                                                <label for="wcauto">Autoplay Stop Time 2:</label>
                                                                <div class="input-group clockpicker" data-placement="left" data-align="top" data-autoclose="true">
                                                                    <input type="text" name="ast2"  class="form-control" value="<?php echo $ast2; ?>">
                                                                    <span class="input-group-addon">
                                                                        <span class="glyphicon glyphicon-time"></span>
                                                                    </span>
                                                                </div>
                                                                <script type="text/javascript">
                                                                $('.clockpicker').clockpicker();
                                                                </script></td>
                                                        </tr>
                                                        
                                                           <tr>
                                                            <td>
                                                                <label for="wcauto">Autoplay Start Time 3:</label>
                                                                <div class="input-group clockpicker" data-placement="right" data-align="top" data-autoclose="true">
                                                                    <input type="text" name="as3"  class="form-control" value="<?php echo $as3; ?>">
                                                                    <span class="input-group-addon">
                                                                        <span class="glyphicon glyphicon-time"></span>
                                                                    </span>
                                                                </div>
                                                                <script type="text/javascript">
                                                                $('.clockpicker').clockpicker();
                                                                </script></td>
                                                            <td>
                                                                <label for="wcauto">Autoplay Stop Time 3:</label>
                                                                <div class="input-group clockpicker" data-placement="left" data-align="top" data-autoclose="true">
                                                                    <input type="text" name="ast3"  class="form-control" value="<?php echo $ast3; ?>">
                                                                    <span class="input-group-addon">
                                                                        <span class="glyphicon glyphicon-time"></span>
                                                                    </span>
                                                                </div>
                                                                <script type="text/javascript">
                                                                $('.clockpicker').clockpicker();
                                                                </script></td>
                                                        </tr>
                                                        
                                                           <tr>
                                                            <td>
                                                                <label for="wcauto">Autoplay Start Time 4:</label>
                                                                <div class="input-group clockpicker" data-placement="right" data-align="top" data-autoclose="true">
                                                                    <input type="text" name="as4"  class="form-control" value="<?php echo $as4; ?>">
                                                                    <span class="input-group-addon">
                                                                        <span class="glyphicon glyphicon-time"></span>
                                                                    </span>
                                                                </div>
                                                                <script type="text/javascript">
                                                                $('.clockpicker').clockpicker();
                                                                </script></td>
                                                            <td>
                                                                <label for="wcauto">Autoplay Stop Time 4:</label>
                                                                <div class="input-group clockpicker" data-placement="left" data-align="top" data-autoclose="true">
                                                                    <input type="text" name="ast4"  class="form-control" value="<?php echo $ast4; ?>">
                                                                    <span class="input-group-addon">
                                                                        <span class="glyphicon glyphicon-time"></span>
                                                                    </span>
                                                                </div>
                                                                <script type="text/javascript">
                                                                $('.clockpicker').clockpicker();
                                                                </script></td>
                                                        </tr>
                                                        
                                                           <tr>
                                                            <td>
                                                                <label for="wcauto">Autoplay Start Time 5:</label>
                                                                <div class="input-group clockpicker" data-placement="right" data-align="top" data-autoclose="true">
                                                                    <input type="text" name="as5"  class="form-control" value="<?php echo $as5; ?>">
                                                                    <span class="input-group-addon">
                                                                        <span class="glyphicon glyphicon-time"></span>
                                                                    </span>
                                                                </div>
                                                                <script type="text/javascript">
                                                                $('.clockpicker').clockpicker();
                                                                </script></td>
                                                            <td>
                                                                <label for="wcauto">Autoplay Stop Time 5:</label>
                                                                <div class="input-group clockpicker" data-placement="left" data-align="top" data-autoclose="true">
                                                                    <input type="text" name="ast5"  class="form-control" value="<?php echo $ast5; ?>">
                                                                    <span class="input-group-addon">
                                                                        <span class="glyphicon glyphicon-time"></span>
                                                                    </span>
                                                                </div>
                                                                <script type="text/javascript">
                                                                $('.clockpicker').clockpicker();
                                                                </script></td>
                                                        </tr>
                                                        
                                                        
                                                        
                                                        
						</table>
						<input type="submit" name="submit" id="submit" class="btn btn-info" style="background-color: #c00 !important;color:#fff !important" value="Submit" />
					</div>
				</form>
			</div>
		</div>
	</body>
</html>





