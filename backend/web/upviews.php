<?php
//VAR_DUMP($_POST);
$connect = mysqli_connect("10.10.10.28", "powersport", "Dgt569khd", "powersport");
//$connect = mysqli_connect("localhost", "root", "root", "powersportztv");

$wid = $_POST["mulview"];


if($wid !=''){
 $sql_wid = "update homepage set  viewfactor='$wid' where HomeID=1 "; //die;
			mysqli_query($connect, $sql_wid);   
    
}



header('Location: setviews.php');
