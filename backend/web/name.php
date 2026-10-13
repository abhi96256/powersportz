<?php
//VAR_DUMP($_POST);
$connect = mysqli_connect("10.10.10.28", "powersport", "Dgt569khd", "powersport");
//$connect = mysqli_connect("localhost", "root", "root", "powersportztv");
$number = count($_POST["name"]);
$wid = $_POST["wcwidget"];
$wcactivematch = $_POST["wcactivematch"];


$as1=  $_POST["as1"];
      $ast1=  $_POST["ast1"];
        $as2=  $_POST["as2"];
      $ast2=  $_POST["ast2"];
        $as3=  $_POST["as3"];
      $ast3=  $_POST["ast3"];
        $as4=  $_POST["as4"];
      $ast4=  $_POST["ast4"];
        $as5=  $_POST["as5"];
      $ast5=  $_POST["ast5"];


if($wcactivematch !=''){
 $sql_wid = "update homepage set  wcmatchid='$wcactivematch' where HomeID=1 "; //die;
			mysqli_query($connect, $sql_wid);   
    
}
if($wid !=''){

$sql_wid = "update homepage set  wcwidget='$wid' where HomeID=1 "; //die;
			mysqli_query($connect, $sql_wid);
                        
}

if($as1 !=''){

$sql_wid = "update homepage set as1='$as1' , ast1='$ast1' , as2='$as2' , ast2='$ast2' , as3='$as3', ast3='$ast3', as4='$as4', ast4='$ast4', as5='$as5', ast5='$ast5'  where HomeID=1 "; //die;
			mysqli_query($connect, $sql_wid);
                        
}

header('Location: wcconfig.php');
