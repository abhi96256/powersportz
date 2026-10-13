<?php
//VAR_DUMP($_POST); die;
$connect = mysqli_connect("10.10.10.28", "powersport", "Dgt569khd", "powersport");
//$connect = mysqli_connect("localhost", "root", "root", "powersportztv");

$wid = $_POST["mulview"];
$fixcount = $_POST["fixcount"];
$startdate = $_POST["startdate"];
$enddate = $_POST["enddate"];
$vodid = $_POST["vodid"];


if($wid !=''){
	//echo  date('Y-m-d'); die;
  $sql_wid = "update homepage set  viewfactor='$wid',vfsd='$startdate',vfed='$enddate' where HomeID=1 "; //die;
			mysqli_query($connect, $sql_wid);   
    
}

if($vodid !=''){
  $sql_wid_v = "update video set  ViewCount='$fixcount' where ID='$vodid' "; //die;
			mysqli_query($connect, $sql_wid_v);   
    
}

//die;

header('Location: views.php');
