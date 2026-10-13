<?php
//VAR_DUMP($_POST);
$connect = mysqli_connect("10.10.10.28", "powersport", "Dgt569khd", "powersport");
//$connect = mysqli_connect("localhost", "root", "root", "powersportztv");


//var_dump($_POST);
$array_values="";
$ad_id = $_POST["ad_id"];




if (isset($_POST["sl"]) && is_array($_POST["sl"])){ 
    $input_array_name = array_filter($_POST["sl"]); 
    foreach($input_array_name as $field_value){
        
       if($field_value!=''){
           $sql_wid = "INSERT INTO `ad_slots`( `as_ad_id`, `as_starttime`) VALUES('$ad_id','$field_value')"; //die;
			mysqli_query($connect, $sql_wid); 
                        $date_his = date('Y-m-d');
                        
           $sql_wid_his = "INSERT INTO `ad_slots_his`( `as_ad_id`, `as_starttime`,as_createdon) VALUES('$ad_id','$field_value','$date_his')"; //die;
			mysqli_query($connect, $sql_wid_his);              
       }
    }
}


if($wcactivematch !=''){
 //$sql_wid = "update homepage set  wcmatchid='$wcactivematch' where HomeID=1 "; //die;
//			mysqli_query($connect, $sql_wid);   
    
}


header('Location: slots.php?f=t');
