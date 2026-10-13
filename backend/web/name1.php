<?php
$connect = mysqli_connect("10.10.10.28", "powersport", "Dgt569khd", "powersport");
//$connect = mysqli_connect("localhost", "root", "root", "powersportztv");
$number = count($_POST["name"]);
$wid = $_POST["wcwidget"];
$wcactivematch = $_POST["wcactivematch"];
if($wcactivematch !=''){
 $sql_wid = "update homepage set  wcmatchid='$wcactivematch' where HomeID=1 "; //die;
			mysqli_query($connect, $sql_wid);   
    
}

$sql_wid = "update homepage set  wcwidget='$wid' where HomeID=1 "; //die;
			mysqli_query($connect, $sql_wid);

if($number > 0)
{
	for($i=0; $i<$number; $i++)
	{
		if(trim($_POST["name"][$i] != ''))
		{
                    
                    
			$sql = "INSERT INTO tbl_name(name) VALUES('".mysqli_real_escape_string($connect, $_POST["name"][$i])."')";
			mysqli_query($connect, $sql);
                        
                        
		}
	}
	echo "Data Updated!";
}
else
{
	echo "Please Enter Name";
}